<?php
$id_user = $_SESSION['user'];
$idArticle = $_GET['id'];

$requete = mysqli_query($connection, "SELECT * FROM blog_article WHERE id_article = $idArticle");
echo "<div>";
while ($resultat = mysqli_fetch_array($requete)) {
    // $link = '/EchimineVibes/pages/detailsPost/?post=' . $resultat['id_article'];
    echo '<div class = details-container>' . '<h1>' . $resultat['title'] . '</h1>' . '<div class=articlesContent>' . $resultat['content'] . '</div>' . '</div>' . '<br>';
}
echo "</div>";

$requeteComm = mysqli_query($connection, "
    SELECT blog_comments.id_commentaire, blog_comments.content, blog_user.user_pseudo
    FROM blog_comments
    INNER JOIN blog_user ON blog_comments.id_user = blog_user.id_user
    WHERE blog_comments.id_article = $idArticle
    ORDER BY blog_comments.id_commentaire DESC
");

while ($resultat = mysqli_fetch_array($requeteComm)) {
    echo '<div class="comment-box">';
    echo "<p><strong>" . htmlspecialchars($resultat["user_pseudo"]) . "</strong> : " . htmlspecialchars($resultat["content"]) . "</p>";
    
    echo "<form method='POST' action='/EchimineVibes/BDD_Functions/delete_comments.php'>";
    echo '<input type="hidden" value="' . htmlspecialchars($id_user) . '" name="id_user">';
    echo '<input type="hidden" value="' . htmlspecialchars($idArticle) . '" name="idArticle">';
    echo '<input type="hidden" value="' . $resultat["id_commentaire"] . '" name="id_commentaire">';
    echo '<input type="hidden" value="' . $resultat["id_commentaire"] . '" name="id_commentaire">';
    echo "<button type='submit'>Supprimer</button>";
    echo "</form>";
    
    echo '</div>';
}

echo "<div>";
echo '<form class="comment-form" action="/EchimineVibes/BDD_Functions/comments_fonctions.php" method="POST">';
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

?>

<style>
.details-container {
  max-width: 800px;
  margin: 40px auto;
  padding: 24px;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.details-container h1 {
  font-size: 32px;
  color: #1f2937;
  margin-bottom: 20px;
  text-align: center;
}

.articlesContent {
  font-size: 18px;
  color: #334155;
  line-height: 1.6;
  margin-bottom: 30px;
}

.comment-box {
  background: #f9fafb;
  padding: 16px 60px 16px 16px;
  border-radius: 12px;
  margin-bottom: 20px;
  border-left: 4px solid #38bdf8;
  position: relative;
}

.comment-box p {
  margin: 0;
  color: #475569;
}

.comment-box form {
  position: absolute;
  top: 16px;
  right: 16px;
}

.comment-box button {
  background-color: #38bdf8;
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.comment-box button:hover {
  background-color: #0ea5e9;
}

.comment-form {
  margin-top: 40px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.comment-form textarea {
  padding: 12px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  resize: vertical;
}

.comment-form button {
  align-self: flex-end;
  background-color: #38bdf8;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.comment-form button:hover {
  background-color: #0ea5e9;
}

</style>