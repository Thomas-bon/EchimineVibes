<?php
// Démarrer la session
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

require_once "C:/wamp64/www/EchimineVibes/connection_session/connection.php"; 

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    echo "T'es bien connecté à l'id : ".$_SESSION['user'];
}else {
    die("Erreur : Vous devez être connecté pour voir vos articles.");

}

$user_id = $_SESSION['user']; // Utiliser la session directement

// Vérifier la connexion
if (!$connection) {
    die("Erreur de connexion à la base de données.");
}

// Récupérer les articles de l'utilisateur
$query = "SELECT id_article, title FROM blog_article WHERE id_user = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Articles</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .article-list { list-style: none; padding: 0; }
        .article-item { display: flex; align-items: center; justify-content: space-between; padding: 10px; border-bottom: 1px solid #ddd; }
        .icons { display: flex; gap: 10px; }
        .icons a { text-decoration: none; font-size: 18px; padding: 5px; border-radius: 5px; }
        .edit { color: blue; }
        .delete { color: red; cursor: pointer; }
    </style>
    <script>
        function confirmDelete(articleId) {
            if (confirm("Voulez-vous vraiment supprimer cet article ?")) {
                window.location.href = "./pages/delete_post.php?id=" + articleId;
            }
        }
    </script>
</head>
<body>

<h2>Mes Articles</h2>
<ul class="article-list">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <li class="article-item">
            <span><?php echo htmlspecialchars($row['title']); ?></span>
            <div class="icons">
                <a href="./pages/edit_post.php?id=<?php echo $row['id_article']; ?>" class="edit">🖊️</a>
                <span class="delete" onclick="confirmDelete(<?php echo $row['id_article']; ?>)">🗑️</span>
            </div>
        </li>
    <?php } ?>
</ul>

</body>
</html>
