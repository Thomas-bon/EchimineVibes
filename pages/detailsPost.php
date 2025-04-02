<?php
include("../connection_session/connection.php");

$connection = mysqli_connect($servername, $username, $password, $database);

// if (isset($_GET['post'])) {
//     if ($_GET['post'] == '1') {
//         echo '<h1>post 1</h1>';
//     } elseif ($_GET['post'] == '3') {
//         echo '<h1>post 2</h1>';
//     } else {
//         echo '<h1>pas de post</h1>';
//     }
// }

$idArticle = $_GET['post'];
if (!$connection) { //Si la connexion n'a pas été effectué
    die("Connection impossible");
} else {
    $requete = mysqli_query($connection, "SELECT * FROM blog_article WHERE id_article = $idArticle");
    echo "<div>";
    while ($resultat = mysqli_fetch_array($requete)) {
        // $link = '/EchimineVibes/pages/detailsPost/?post=' . $resultat['id_article'];
        echo '<div class = articles>'. '<h1>'.$resultat['title'].'</h1>'.'<div class=articlesContent>'.$resultat['content'].'</div>'.'<img class=articlesImage src= ../'.$resultat['img_article'].'>' .'</div>' . '<br>';
    }
    echo "</div>";
}
// include('../BDD_Functions/delete_post.php');
echo '<a href="/EchimineVibes/BDD_Functions/delete_post.php/?id='.$idArticle.'" onclick="return confirm("Confirmer la suppression ?")">Supprimer</a>';
// echo '<button>'..'</button>';
// include('postEdit.php');