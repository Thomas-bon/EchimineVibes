<?php
include("connection_session/connection.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>home page</h1>
    <button> <a href="?page=login">LOGIN PAGE</a></button>
    <?php

        if (!$connection) { //Si la connexion n'a pas été effectué
            die("Connection impossible");
        } else {
            $requete = mysqli_query($connection, "SELECT * FROM `blog_article`");
            echo "<div>";
            while($resultat=mysqli_fetch_array($requete)) {
                // $link='?post='.$resultat['id_article'];
                echo '<div>'.'<h1>'.$resultat['title'].'</h1>'.'</div>'.'<br>';
                }
            echo "</div>";
            }

    ?>
</body>

</html>