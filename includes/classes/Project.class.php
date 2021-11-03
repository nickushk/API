<?php
class Project
{
    // Attributes
    private $db;
    private $project;
    private $about;
    private $link;
    private $image_link;

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
     * Get projects
     * @return array
    */
    public function getAllProjects(): array
    {
        $sql = "
        SELECT * FROM projects;";
        $projects = $this->db->query($sql);

        // return to array
        return $projects_array = $projects->fetch_all(MYSQLI_ASSOC);

    }

    /**
     * Get cours by id
     * @return array
     */
    public function getProjectById(int $id_in): array
    {
        $sql = "
        SELECT * FROM projects WHERE id = $id_in;";
        $projects = $this->db->query($sql);

        // return to array
        return $projects_array = $projects->fetch_all(MYSQLI_ASSOC);

    }

    /**
     * Add project
     * @param string project, code...
     * @return bool
     */
    public function addProject(string $name, string $about, string $image_link, string $link): bool
    {       
        
            $this->project = $name;
            $this->about = $about;
            $this->image_link = $image_link;
            $this->link = $link;

            // Check input fomat
            $prepare_statment = $this->db->prepare
            ("INSERT INTO projects (project, about, image_link, link) 
            VALUES (?, ?, ?, ?)");
            $prepare_statment->bind_param("ssss", 
            $this->project, $this->about, $this->image_link, $this->link);

            if ($prepare_statment->execute()) {
                return true;
            } else {
                return false;
            }
            // cloce statement
            $prepare_statment->close();


    }

    /**
     * delete a project by id
     * @param int id_in
     * @return bool
     */
    public function deleteProject(int $id_in): bool
    {
        // make input to integer
        $id = intval($id_in);

        $sql = " DELETE FROM projects WHERE id = $id;";
        if ($this->db->query($sql)) {
            return true;
        }
        return false;
    }

    /**
     * update project
     * @param string project, code...
     * @param int id_in
     * @return bool
     */
    public function UpdateProject(string $name, string $about, string $image_link, string $link, string $id_in): bool
    {
        $this->project = $name;
        $this->about = $about;
        $this->image_link = $image_link;
        $this->link = $link;

        $id = intval($id_in);
        if (strlen($this->project) < 1 | strlen($this->about) < 1 | strlen($this->image_link) < 1 | strlen($this->link) < 1) {
            return false;
        }else{
            // Check input fomat
            $prepare_statment = $this->db->prepare("UPDATE projects SET project= ? , about = ?, image_link= ?, link= ? WHERE id = $id");
            $prepare_statment->bind_param("ssss", $this->project, $this->about, $this->image_link, $this->link);

            if ($prepare_statment->execute()) {
                return true;
            } else {
                return false;
            }

            $prepare_statment->close();
        }       
    }

   

}