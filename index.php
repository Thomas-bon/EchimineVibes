<link rel="stylesheet" href="style.css">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>

<?php


// include('./pages/detailsPost.php');

if (isset($_GET["page"]) && $_GET["page"] == "login") {
    include "pages/login.php";
} elseif (isset($_GET["page"]) && $_GET["page"] == "register") {
    include "pages/register.php";
} else {
    include('./pages/main.php');
}