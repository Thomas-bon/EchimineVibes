<?php
include("connection_session/connection.php");

$connection = mysqli_connect($servername, $username, $password, $database);

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
        echo '<h1>Nos recettes du moment</h1>' . '<section class="recipes">';
        while ($resultat = mysqli_fetch_array($requete)) {
            $link = '?post=' . $resultat['id_article'];
            $chemin = glob("image/recette/" . $resultat['id_recette'] . ".*");
            echo '<div class="recipe-card">' . '<img class="img page acceuil"src="' . $chemin[0] . '" alt="Pâtes maison">' . '<div class="info">' . '<a href="' . $link . '">' . $resultat['nomRecette'] . '</a>' . '</div>' . '</div>' . '<br>';
        }
        echo "</div>";
    }


    ?>
</body>

</html>