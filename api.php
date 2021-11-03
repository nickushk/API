<?php
// *Headers med inställningar för din REST webbtjänst*/
include "includes/config.php";


// ? Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
header('Access-Control-Allow-Origin:*');

// ? Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

// ? Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

// ? Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem
// ? med CORS (Cross-Origin Resource Sharing)utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// ? Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];
$response =[];
$login = "";
$table = "";
$link = "https://studenter.miun.se/~niku2001/writeable/webb3/portfolio/admin_projekt.html";


// ? Om en parameter av id finns i urlen lagras det i en variabel
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_GET['table'])) {
    $_SESSION['table'] = $_GET['table'];
    $table = $_SESSION['table'];
}

// if user want to login
if (isset($_GET['login'])) {
    $_SESSION['login']= $_GET['login'];
    $login = $_SESSION['login'];
}


// * create objects
$course = new Course();
$work = new Work();
$project = new Project();
$admin = new Admin();

switch ($method) {
    case 'GET':
        //Skickar en "HTTP response status code"
        http_response_code(200); //Ok - The request has succeeded

        if ($table == "works") { //!controll the table name before print out
            $response = $work->getAllWorks();
            // reset admin infor/logout
            session_destroy();

        } else if ($table == "courses") {
            $response = $course->getAllCourses();
        } else if ($table == "projects") {
            $response = $project->getAllProjects();
        } else if ($login == "login") {
            if(isset($_SESSION['user'])){
                $response = array("admin"=>"yes");
            }else{
                $response = array("admin"=>"no");
                
            }
            
        }

        break;
    case 'POST':

        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));

        if ($table == "works") { //!controll the table name before print out
            $response = addDataResponse($work->addWork($data->work, $data->place, $data->start_date, $data->end_date));
        } else if ($table == "courses") {
            $response = addDataResponse($course->addCourse($data->course, $data->place, $data->start_date, $data->end_date));
        } else if ($table == "projects") {
            $response = addDataResponse($project->addProject($data->project, $data->about, $data->image_link, $data->link));
        }else if ($login == "login") {
            if($admin->checkUser($data->user, $data->pass)){
                $_SESSION['user'] = "set";
                $response =array("login" => "user logged in"); 
            }else{
                $response = array ("login" => "user not logged in");
                session_destroy();
            }
        }

        break;
    case 'PUT':
        // ? Om inget id är med skickat, skicka felmeddelande
        if (!isset($id)) {
            http_response_code(400); // !Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "No id is sent");
            //Om id är skickad
        } else {
            $table = $_SESSION['table'];
            $data = json_decode(file_get_contents("php://input"));

            if ($table == "works") { //!controll the table name before print out
                $response = $work->updateWork($data->work, $data->place, $data->start_date, $data->end_date, $id);
                
            } else if ($table == "courses") {
                $response = $course->uppdateCours($data->course, $data->place, $data->start_date, $data->end_date, $id);
            } else if ($table == "projects") {
                $response = $project->UpdateProject($data->project, $data->about, $data->image_link, $data->link, $id);
            }

            http_response_code(200);
            $response = array("message" => "Post i tabell=$table with id=$id is updated");
        }
        break;
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");
        } else {

            if ($table == "works") { //!controll the table name before print out
                $response = $work->deleteWork($id);
            } else if ($table == "courses") {
                $response = $course->deleteCourse($id);
            } else if ($table == "projects") {
                $response = $project->deleteProject($id);
            }

            http_response_code(200);
            $response = array("message" => "Post in table: $table with id: $id is deleted");
        }
        break;

}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);
