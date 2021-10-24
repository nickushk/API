<?php
// appearance of title
$site_title = "Nick Kushkbaghi";
$divider = " | ";
$class_name1 = "Course";
$class_name2 = "Work";
$class_name3 = "Project";

// add functions
include("includes/functions/function.php");

// Auto_load calssfiles
spl_autoload_register(function ($class_name1) {
    include ("includes/classes/" . $class_name1 . ".class.php");
});
spl_autoload_register(function ($class_name2) {
    include ("includes/classes/" . $class_name2 . ".class.php");
});
spl_autoload_register(function ($class_name3) {
    include ("includes/classes/" . $class_name3 . ".class.php");
});
// start session for storing locale variable
session_start();
// with coding
$devmode = false;

if ($devmode) {

    // active error messages
    error_reporting(-1);
    ini_set("display_errors", 1);

    // send explained error from MYSQL
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // const/ info for database conection LOCALHOST
    define('DBHOST', 'localhost');
    define('DBUSER', 'niku2001');
    define('DBPASS', '1111');
    define('DBNAME', 'portfolio');
} else {
    // Database-settings- published
    // active error messages
    error_reporting(-1);
    ini_set("display_errors", 1);

    // send explained error from MYSQL
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // const/ info for database conection
    define('DBHOST', 'studentmysql.miun.se');
    define('DBUSER', 'niku2001');
    define('DBPASS', 'Je8pCj2Zxq');
    define('DBNAME', 'niku2001');

}
