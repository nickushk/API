<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install kurser</title>
</head>
<body>

<!-- Database conection -->
<?php
// Include config
include "includes/config.php";

// Condection to databe
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// connection check
if ($db->connect_errno > 0) {

    die('Fel vid anslutning [' . $db->connect_error . ']');
}

/*---------------
 *
 *Install courses tabell
 *
-----------------*/
// create courses tabell
$sql = " DROP TABLE IF EXISTS courses;
     CREATE TABLE courses(
    id INT (11) PRIMARY KEY AUTO_INCREMENT,
    course VARCHAR (225) NOT NULL,
    place VARCHAR (64) NOT NULL,
    start_date VARCHAR (7) NOT NULL,
    end_date VARCHAR (7) NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
    );";

// Insert courses as query
$sql .= "INSERT INTO courses
(course, place, start_date, end_date)
        VALUES ('Webbutveckling I', 'Mittuniversitetet', '2020/08', '2020/10');

        INSERT INTO courses
        (course, place, start_date, end_date)
        VALUES ('Introduktion till programmering i JavaScript','Mittuniversitetet','2020/08','2020/10');

        INSERT INTO courses
        (course, place, start_date, end_date)
        VALUES ('Digital bildbehandling för webb', 'Mittuniversitetet','2020/11','2021/01' );

        INSERT INTO courses
        (course, place, start_date, end_date)
        VALUES ('Webbanvändbarhet',  'Mittuniversitetet', '2020/11', '2021/01' );

        INSERT INTO courses
        (course, place, start_date, end_date)
        VALUES ('Databaser', 'Mittuniversitetet', '2021/02', '2021/04' );
        ";

// Print sql query
echo "<pre> $sql</pre>";

if ($db->multi_query($sql)) {
    echo "<p>Tabeller installerade</p>";
} else {

    echo "<p> class='error'> Fel vid installering av tabeller</p>";
}

?>
</body>
</html>
