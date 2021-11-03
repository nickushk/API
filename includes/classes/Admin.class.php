
<?php


class Admin
{
    private $db ;
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



     // check user input with database data
     public function checkUser (string $user, string $pass):bool{
        $sql = "
        SELECT user FROM admins ";
        $dbUser= $this->db->query($sql);
        $dbUser = mysqli_fetch_row($dbUser);
        //To string
        $_dbUser = $dbUser[0];

        $sql = "
        SELECT pass FROM admins ";
        $dbPass= $this->db->query($sql);
        $dbPass= mysqli_fetch_row($dbPass);

        //To string
        $_dbPass =$dbPass[0];
        if(strcmp($_dbUser, $user) == 0 && strcmp($_dbPass, $pass) == 0){
            return true; 
        }
        return false;
     
     }
}
     

?>