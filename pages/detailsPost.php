<?php


$id_user = $_SESSION['user'];



$idArticle = $_GET['id'];
// if (!$connection) { //Si la connexion n'a pas été effectué
//     die("Connection impossible");
// } else {
    $requete = mysqli_query($connection, "SELECT * FROM blog_article WHERE id_article = $idArticle");
    echo "<div>";
    while ($resultat = mysqli_fetch_array($requete)) {
        // $link = '/EchimineVibes/pages/detailsPost/?post=' . $resultat['id_article'];
        echo '<div class = articles>'. '<h1>'.$resultat['title'].'</h1>'.'<div class=articlesContent>'.$resultat['content'].'</div>'.'<img class=articlesImage src= ../'.$resultat['img_article'].'>' .'</div>' . '<br>';
    }
    echo "</div>";


    echo "<div>";
    echo '<form action="/EchimineVibes/BDD_Functions/comments_fonctions.php" method="POST">';
    echo '    <label for="texte">Votre texte :</label>';
    echo '    <input type="text" name="texte" id="texte" required>'; 
    echo '    <input type="hidden" value="' . htmlspecialchars($id_user) . '" id="id_user" name="id_user">';
    echo '    <input type="hidden" value="' . htmlspecialchars($idArticle) . '" id="idArticle" name="idArticle">';
    echo '    <button type="submit">Envoyer</button>';
    echo '</form>';
    echo "</div>";
// }
// include('../BDD_Functions/delete_post.php');
echo '<a href="/EchimineVibes/BDD_Functions/delete_post.php/?id='.$idArticle.'" onclick="return confirm("Confirmer la suppression ?")">Supprimer</a>';
// echo '<button>'..'</button>';
// include('postEdit.php');