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
    echo '<div class = articles>' . '<h1>' . $resultat['title'] . '</h1>' . '<div class=articlesContent>' . $resultat['content'] . '</div>' . '</div>' . '<br>';
}
echo "</div>";

$requeteComm = mysqli_query($connection, "
    SELECT blog_comments.id_commentaire, blog_comments.content, blog_user.user_pseudo
    FROM blog_comments
    INNER JOIN blog_user ON blog_comments.id_user = blog_user.id_user
    WHERE blog_comments.id_article = $idArticle
");

while ($resultat = mysqli_fetch_array($requeteComm)) {
    echo "<form method='POST' action='/EchimineVibes/BDD_Functions/delete_comments.php'>";
    echo '<input type="hidden" value="' . htmlspecialchars($id_user) . '" name="id_user">';
    echo '<input type="hidden" value="' . htmlspecialchars($idArticle) . '" name="idArticle">';
    echo '<input type="hidden" value="' . $resultat["id_commentaire"] . '" name="id_commentaire">'; // Nom corrigé
    echo "<p>Commentaire de " . $resultat["user_pseudo"] . " : " . $resultat["content"] . "</p>";
    echo "<button type='submit'>Supprimer</button>";
    echo "</form>";
}
echo "<div>";
echo '<form action="/EchimineVibes/BDD_Functions/comments_fonctions.php" method="POST">';
echo '    <label for="texte">Votre texte :</label>';
echo '    <input type="text" name="texte" id="texte" required>';
echo '    <input type="hidden" value="' . htmlspecialchars($id_user) . '" id="id_user" name="id_user">';
echo '    <input type="hidden" value="' . htmlspecialchars($idArticle) . '" id="idArticle" name="idArticle">';
echo '    <button type="submit">Envoyer</button>';

echo '</form>';
echo "</div>";

$result = mysqli_query($connection, "SELECT id_user FROM blog_article WHERE id_article = $idArticle");

if ($row = mysqli_fetch_assoc($result)) {
    $id_user_creator = $row['id_user'];
    $id_user_creator = (int) $id_user_creator; 

    if ($_SESSION["user"] === $id_user_creator || $_SESSION["role"] === "admin") {
        echo '<a href="/EchimineVibes/BDD_Functions/delete_post.php/?id=' . $idArticle . '" onclick="return confirm(\'Confirmer la suppression ?\')">Supprimer</a>';
    }
}
