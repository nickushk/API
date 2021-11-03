<?php
$class_name = "User";
$page_title = "Loggin/Register";
$user_exist = true;
$error_array = [];
$home = "home";
$admin = "admin";
$login = "active";
$blogg = "blogg";
$email_reg = "";
$password_reg = "";
$password_reg2 = "";
$firstname_reg = "";
$lastname_reg = "";
$password_reg = "";
$youAreIn = "";
$email_in = "";
$password_in = "";
$username = "";
$message = '';
include "includes/functions/function.php";
include_once "includes/config.php";
include "includes/header.php";
$post_obj = new Post();
$user_obj = new User();
$db_obj = new DBConnection();

$email = $user_obj->getEmail();
$user_obj->setToArray();
$my_array = $user_obj->getArray();
?>
    <?php // -----------------login section//controll email and password ----------------

// set admins firstname into a section variabel
if (isset($_GET['username'])) {
    $_SESSION['firstname'] = $_GET['username'];
}

// check user inputs
if (isset($_POST['password_in'])) {
    $email_in = $_POST['email_in'];
    // control email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Ogiltig email format!";
        $password_in = $_POST['password_in'];
        // if both email input and password are match
        if ($user_obj->checkPasswords($password_in, $email_in)) {
            $_SESSION['email'] = $email_in;
            $_SESSION['firstname'] =

            $db_obj->getPulisherFirstName("SELECT firstname FROM users WHERE email = '$email_in';");
            $username = $_SESSION['firstname'];
            //send username to the admin page
            header("Location: admin.php?username=$username ");
        } else {
            $message = "Felaktigt användarnamn/lösenord!";
            $user_exist = false;
        }
    }
}
?>
<!-- Login section -->
        <section class="login">
            <h2 class="title2">Inloggning</h2>
            <p class="error"> <?=$message?></p>
            <?php

// inform user if account is created
if (isset($_SESSION['firstname']) && $user_exist) {
    ?>
                <p class="done"> Ditt konto har skapat
                <span> <?=$_SESSION['firstname']?>,vänligen logga in! </span></p>
            <?php
unset($username);}
?>
            <!-- form -->
            <form class= "login form" method="post" action="loggin.php">
                <label for="email_in">Mejladress</label>
                <input  type="text" name="email_in"  id="email_in" placeholder="exemple@gmail.com" >
                <label for="password_in">Lösenord</label>
                <input name="password_in" id="password_in"  type="password">
                <input class="btn submit" type="submit" value="Logga in">
            </form>
        </section>

        <?php //--------------- Sign up section----------------//
$message = '';
if (isset($_POST['firstname_reg'])) {
    $firstname_reg = $_POST['firstname_reg'];
    $lastname_reg = $_POST['lastname_reg'];
    // check if is email is unique and passwords are idential
    if (itemExistInList($my_array, 'email', $_POST['email_reg'])) {
        array_push($error_array,
            "Det här mejladress har redan registrerats, vänligen testa annat mejl!");
    } elseif (!filter_var($_POST['email_reg'], FILTER_VALIDATE_EMAIL)) {
        array_push($error_array, "Ogiltig email format!");
        
        // check email format
    }elseif ($_POST['password_reg'] !== $_POST['password_reg2']) {
        array_push($error_array, "Lösenord överensstämmer inte");
    }  else {
        $email_reg = $_POST['email_reg'];
        $password_reg = $_POST['password_reg'];
    }
}
// controll if lenght is ok
if ($user_obj->setFirstname($firstname_reg) &&
    $user_obj->setLastname($lastname_reg) &&
    $user_obj->setEmail($email_reg) &&
    $user_obj->setPassword($password_reg)) {
    $user_obj->setToDB();
    // send username to the admin page
    header("Location: loggin.php?username= $firstname_reg ");
}
?>
        <!-- Register section  -->
        <section class="login">
            <h2 class="title2">Registrering</h2>

            <?php // print if there is any error
perintArrayAsError($error_array);
unset($error_array);
?>
            <!-- form -->
            <form class= "form reg" method="post">
                <label for="firstname_reg">Förname</label>
                <input  type="text" name="firstname_reg"  id="firstname_reg" value=" <?=$firstname_reg?>">
                <label for="lastname_reg">Efternamn</label>
                <input  type="text" name="lastname_reg"  id="lastname_reg" value=" <?=$lastname_reg?>">
                <label for="email_reg">Mejladress</label>
                <input  type="text" name="email_reg"  id="email_reg" placeholder="exemple@gmail.com" value=" <?=$email_reg?>">
                <label for="password_reg">Lösenord</label>
                <input name="password_reg" id="password_reg"  type="password" placeholder="Minst 4 karaktär">
                <label for="password_reg2">bekräfta</label>
                <input name="password_reg2" id="password_reg2"  type="password" placeholder="Minst 4 karaktär">
                <input class="btn submit" type="submit" value="Register">
            </form>
        </section>
        <?php
include "includes/footer.php";
?>
</html>