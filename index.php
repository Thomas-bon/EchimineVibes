<link rel="stylesheet" href="style.css">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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

