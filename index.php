<?php

session_start();

if(isset($_SESSION["user"])) {
    echo $_SESSION["user"];
}else {
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

    ?>

<?php

if (isset($_GET["page"]) && $_GET["page"] == "login") {
    include "pages/login.php";
} elseif (isset($_GET["page"]) && $_GET["page"] == "register") {
    include "pages/register.php";
} else {
    include('./pages/main.php');
}
 
?>

<footer>
    <?php
    include('./pages/footer.php');
    ?>
</footer>
</body>

</html>
