<?php
include("connection_session/connection.php");


session_start();

if (isset($_SESSION["user"])) {
    echo $_SESSION["user"];//id de l'utilisateur
    echo "  ";
    echo $_SESSION["role"];
} else {
    echo "j'suis pas connecté";
}


?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1dc9ffc1cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./pages/header/style.css">
    <title>Document</title>
</head>

<body>
    <?php

    include('./pages/header/header.php');

    ?><?php
    
    if (!isset($_SESSION["user"])) { 
        // Si l'utilisateur essaie d'accéder à une autre page que login ou register, il est redirigé vers login
        if (!isset($_GET["page"]) || ($_GET["page"] !== "login" && $_GET["page"] !== "register")) {
            header("Location: ?page=login");
            exit();
        }
    }
    
    
    // Si l'utilisateur est connecté, il peut naviguer normalement
    if (isset($_GET["page"])) {
        switch ($_GET["page"]) {
            case "login":
                include "pages/login.php";
                break;
            case "register":
                include "pages/register.php";
                break;
            case "admin_dashboard":
                include "pages/adminDashboard.php";
                break;
            case "user_dashboard":
                include "pages/userDashboard.php";
                break;
            case "logout":
                include "connection_session/logout.php";
                break;
            case "postEdit":
                include "pages/postEdit.php";
                break;
            case "detailPost":
                include "pages/detailsPost.php";
                break;
            default:
                include "pages/main.php";
        }
    } elseif (isset($_GET["delete_user"]) || isset($_GET["update_user"]) || isset($_GET["add_user"])) {
        include "pages/adminDashboard.php";
    } else {
        include "pages/main.php";
    }
    ?>
    
    

    <footer>
        <?php
        include('./pages/footer.php');
        ?>
    </footer>
</body>

</html>