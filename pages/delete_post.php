<?php
// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "C:/wamp64/www/EchimineVibes/connection_session/connection.php"; 

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    die("Erreur : Vous devez être connecté pour supprimer un article.");
}

$user_id = $_SESSION['id_user'];

// Vérifier si l'ID de l'article est présent
if (!isset($_GET['id'])) {
    die("Erreur : Aucun article sélectionné.");
}

$id_article = intval($_GET['id']);

// Vérifier si l'article appartient bien à l'utilisateur connecté
$query = "SELECT id_article FROM blog_article WHERE id_article = ? AND id_user = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "ii", $id_article, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die("Erreur : Vous n'avez pas l'autorisation de supprimer cet article.");
}

// Supprimer l'article
$delete_query = "DELETE FROM blog_article WHERE id_article = ? AND id_user = ?";
$stmt = mysqli_prepare($connection, $delete_query);
mysqli_stmt_bind_param($stmt, "ii", $id_article, $user_id);

if (mysqli_stmt_execute($stmt)) {
    echo "Article supprimé avec succès. <a href='index.php'>Retour à la liste</a>";
} else {
    echo "Erreur lors de la suppression de l'article.";
}
?>
