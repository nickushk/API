<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install projekt</title>
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
 *Install projekt tabell
 *
-----------------*/
// create projects tabell
$sql = "DROP TABLE IF EXISTS projects;
    CREATE TABLE projects(
    id INT (11) PRIMARY KEY AUTO_INCREMENT,
    project VARCHAR (225) NOT NULL,
    about VARCHAR (225)NOT NULL,
    image_link VARCHAR (225) NOT NULL,
    link VARCHAR (225) NOT NULL,
    postdate timestamp NOT NULL DEFAULT current_timestamp()
);";

// Insert Projects as query
$sql .= "INSERT INTO projects(project, about, image_link, link)
   VALUES ('Skåne färdtjänst', 'Webbplats med fokus på användbarhet och WCAG AAA krav.',
    'https://studenter.miun.se/~niku2001/writeable/webb3/api/images/project1.jpg', 'https://studenter.miun.se/~niku2001/dt068/');


INSERT INTO projects(project, about, image_link, link)
   VALUES ('WD', 'Webbplats med fokus på webbtypogerafi', 'https://studenter.miun.se/~niku2001/writeable/webb3/api/images/project3.jpg', 'https://studenter.miun.se/~niku2001/gd008g/projekt/home.html');


INSERT INTO projects(project, about, image_link, link)
   VALUES ('VOMusic', 'Webbplats med fokus på E-handel', 'https://studenter.miun.se/~niku2001/writeable/webb3/api/images/project2.jpg', 'https://studenter.miun.se/~niku2001/dt163g/project/home.html');


INSERT INTO projects(project, about, image_link, link)
   VALUES ('Skog AB', 'Webbplats med fokus på CMS och skappas via Wordpress', 'https://studenter.miun.se/~niku2001/writeable/webb3/api/images/project4.jpg', 'https://studenter.miun.se/~niku2001/dt152g/moment1.2/');


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
