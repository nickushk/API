<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install admin</title>
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
*Install works tabell
*
-----------------*/
// create works tabell
$sql = "DROP TABLE IF EXISTS admins;
    CREATE TABLE admins(
    id INT (11) PRIMARY KEY AUTO_INCREMENT,
    user VARCHAR (225) NOT NULL,
    pass VARCHAR (225) NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
);";

// Insert works as query
$sql .= "INSERT INTO admins(user, pass )
        VALUES ('niku2001', '1111');
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
