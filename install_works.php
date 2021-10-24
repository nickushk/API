<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install arbetserfarenheter</title>
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
$sql = "DROP TABLE IF EXISTS works;
    CREATE TABLE works(
    id INT (11) PRIMARY KEY AUTO_INCREMENT,
    work VARCHAR (225) NOT NULL,
    place VARCHAR (64) NOT NULL,
    start_date VARCHAR (7) NOT NULL,
    end_date VARCHAR (7) NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
);";

// Insert works as query
$sql .= "INSERT INTO works(work, place, start_date, end_date)
        VALUES ('lärarassistent', 'Skåne', '2015/11', '2019');

        INSERT INTO works
        (work, place, start_date, end_date)
        VALUES ('Mattelärare', 'Skåne', '2019/01', '2021/08');

        INSERT INTO works
        (work, place, start_date, end_date)
        VALUES ('Digital kompetens lärare', 'Skåne', '2019/01', '2021/08');
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
