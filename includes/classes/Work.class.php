<?php
class Work
{
    // Attributes
    private $db;
    private $work;
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
     * Get works
     * @return array
     */
    public function getAllWorks(): array
    {
        $sql = "
        SELECT * FROM works;";
        $coutrses = $this->db->query($sql);

        // return to array
        return $works_array = $coutrses->fetch_all(MYSQLI_ASSOC);

    }

    /**
     * Get cours by id
     * @return array
     */
    public function getWorkById($id_in): array
    {
        $sql = "
        SELECT * FROM works WHERE id = $id_in;";
        $coutrses = $this->db->query($sql);

        // return to array
        return $courses_array = $coutrses->fetch_all(MYSQLI_ASSOC);

    }

    /**
     * Add worke
     * @param string work, code...
     * @return bool
     */
    public function addWork(string $name, string $place, string $start_date, string $end_date): bool
    {       
        
            $this->work = $name;
            $this->place = $place;
            $this->start_date = $start_date;
            $this->end_date = $end_date;

            // Check input fomat
            $prepare_statment = $this->db->prepare
            ("INSERT INTO works (work, place, start_date, end_date) 
            VALUES (?, ?, ?, ?)");
            $prepare_statment->bind_param("ssss", 
            $this->work, $this->place, $this->start_date, $this->end_date);

            if ($prepare_statment->execute()) {
                return true;
            } else {
                return false;
            }
            // cloce statement
            $prepare_statment->close();


    }

    /**
     * delete a work by id
     * @param int id_in
     * @return bool
     */
    public function deleteWork(int $id_in): bool
    {
        // make input to integer
        $id = intval($id_in);

        $sql = " DELETE FROM works WHERE id = $id;";
        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    /**
     * update worke
     * @param string work, code...
     * @param int id_in
     * @return bool
     */
    public function updateWork(string $name, string $place, string $start_date, string $end_date,int $id_in): bool
    {
        $this->work = $name;
        $this->place = $place;
        $this->start_date = $start_date;
        $this->end_date = $end_date;

        $id = intval($id_in);
        if (strlen($this->work) < 1 | strlen($this->place) < 1 | strlen($this->start_date) < 1 | strlen($this->end_date) < 1) {
            return false;
        }else{
            // Check input fomat
            $prepare_statment = $this->db->prepare("UPDATE works SET work= ? , place = ?, start_date= ?, end_date= ? WHERE id = $id");
            $prepare_statment->bind_param("ssss", $this->work, $this->place, $this->start_date, $this->end_date);

            if ($prepare_statment->execute()) {
                return true;
            } else {
                return false;
            }

            $prepare_statment->close();
        }       
    }

   

}