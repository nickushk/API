<?php
class Course
{
    // Attributes
    private $db;
    private $course;
    private $place;
    private $start_date;
    private $end_date;

    // Construct
    public function __construct()
    {
        // Db conection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

        // Check conection
        if ($this->db->connect_error) {
            die("Conection failed" . $this->db->connect_error);
        }
    }

    /**
     * Get courses
     * @return array
     */
    public function getAllCourses(): array
    {
        $sql = "
        SELECT * FROM courses;";
        $coutrses = $this->db->query($sql);

        // return to array
        return $courses_array = $coutrses->fetch_all(MYSQLI_ASSOC);

    }

    /**
     * Get cours by id
     * @return array
     */
    public function getCourseById(int $id_in): array
    {
        $sql = "
        SELECT * FROM courses WHERE id = $id_in;";
        $coutrses = $this->db->query($sql);

        // return to array
        return $courses_array = $coutrses->fetch_all(MYSQLI_ASSOC);

    }
    /**
     * Add course
     * @param string course, code...
     * @return bool
     */
    public function addCourse(string $name, string $place, string $start_date, string $end_date): bool
    {       
        
            $this->course = $name;
            $this->place = $place;
            $this->start_date = $start_date;
            $this->end_date = $end_date;

            // Check input fomat
            $prepare_statment = $this->db->prepare
            ("INSERT INTO courses (course, place, start_date, end_date) 
            VALUES (?, ?, ?, ?)");
            $prepare_statment->bind_param("ssss", 
            $this->course, $this->place, $this->start_date, $this->end_date);

            if ($prepare_statment->execute()) {
                return true;
            } else {
                return false;
            }
            // cloce statement
            $prepare_statment->close();


    }

    /**
     * delete a course by id
     * @param int id_in
     * @return bool
     */
    public function deleteCourse(int $id_in): bool
    {
        // make input to integer
        $id = intval($id_in);

        $sql = " DELETE FROM courses WHERE id = $id;";
        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    /**
     * update course
     * @param string cours, code...
     * @param int id_in
     * @return bool
     */
    public function uppdateCours(string $name, string $place, string $start_date, string $end_date, string $id_in): bool
    {
        $this->course = $name;
        $this->place = $place;
        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $id = intval($id_in);
        if (strlen($this->course) < 1 | strlen($this->place) < 1 | strlen($this->start_date) < 1 | strlen($this->end_date) < 1) {
            return false;
        }else{
            // Check input fomat
            $prepare_statment = $this->db->prepare("UPDATE courses SET course= ? , place = ?, start_date= ?, end_date= ? WHERE id = $id");
            $prepare_statment->bind_param("ssss", $this->course, $this->place, $this->start_date, $this->end_date);

            if ($prepare_statment->execute()) {
                return true;
            } else {
                return false;
            }

            $prepare_statment->close();
        }       
    }

}