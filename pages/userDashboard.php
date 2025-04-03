<?php
// Démarrer la session
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

include ("../connection_session/connection.php");

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
    <script>
        function confirmDelete(articleId) {
            if (confirm("Voulez-vous vraiment supprimer cet article ?")) {
                window.location.href = "./pages/delete_post.php?id=" + articleId;
            }
        }
    </script>
</head>
<body>

<div class="dashboard-wrapper">
  <h2>Mes Articles</h2>
  <ul class="article-list">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <li class="article-item">
        <span><?php echo htmlspecialchars($row['title']); ?></span>
        <button onclick="confirmDelete(<?php echo $row['id_article']; ?>)">Supprimer</button>
      </li>
    <?php } ?>
  </ul>
</div>


</body>
</html>

<style>
.dashboard-wrapper {
  max-width: 800px;
  margin: 40px auto;
  padding: 20px;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
}

.dashboard-wrapper h2 {
  text-align: center;
  font-size: 28px;
  color: #1f2937;
  margin-bottom: 20px;
}

.article-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.article-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f9fafb;
  padding: 16px 20px;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s ease;
}

.article-item:hover {
  transform: translateY(-2px);
}

.article-item span {
  font-size: 18px;
  font-weight: 500;
  color: #1f2937;
}

.article-item button {
  background-color: #ef4444;
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.article-item button:hover {
  background-color: #dc2626;
}


</style>
