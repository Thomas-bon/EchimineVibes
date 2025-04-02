<?php
// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "C:/wamp64/www/EchimineVibes/connection_session/connection.php"; 

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    die("Erreur : Vous devez être connecté pour modifier un article.");
}

$user_id = $_SESSION['user'];

// Vérifier si l'ID de l'article est présent
if (!isset($_GET['id'])) {
    die("Erreur : Aucun article sélectionné.");
}

$id_article = intval($_GET['id']);

// Récupérer l'article depuis la base de données
$query = "SELECT title, content FROM blog_article WHERE id_article = ? AND id_user = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "ii", $id_article, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$article = mysqli_fetch_assoc($result);

if (!$article) {
    die("Erreur : Article introuvable ou vous n'avez pas l'autorisation de le modifier.");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $content = mysqli_real_escape_string($connection, $_POST['content']);

    $update_query = "UPDATE blog_article SET title = ?, content = ? WHERE id_article = ? AND id_user = ?";
    $stmt = mysqli_prepare($connection, $update_query);
    mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $id_article, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Article mis à jour avec succès. <a href='../index.php'>Retour à la liste</a>";
    } else {
        echo "Erreur lors de la mise à jour de l'article.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
</head>
<body>
    <h2>Modifier l'article</h2>
    <form method="post">
        <label>Titre :</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required><br><br>
        
        <label>Contenu :</label><br>
        <textarea name="content" rows="5" required><?php echo htmlspecialchars($article['content']); ?></textarea><br><br>
        
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
