<?php
session_start();
include("../connection_session/connection.php");

// Vérifier si les paramètres sont passés en GET
if (!isset($_GET['id_commentaire']) || !isset($_GET['idArticle'])) {
    echo "ID du commentaire ou de l'article non fourni.";
    exit;
}

$idCommentaire = $_GET['id_commentaire']; // ID du commentaire à modifier
$idArticle = $_GET['idArticle']; // ID de l'article associé

// Récupérer le commentaire à modifier
$requete = mysqli_query($connection, "SELECT * FROM blog_comments WHERE id_commentaire = $idCommentaire");
$commentaire = mysqli_fetch_array($requete);

if (!$commentaire) {
    echo "Commentaire introuvable.";
    exit;
}

?>

<h2>Modifier votre commentaire</h2>
<!-- Formulaire de modification du commentaire -->
<form method="POST"
    action="edit_comment.php?id_commentaire=<?php echo $idCommentaire; ?>&idArticle=<?php echo $idArticle; ?>">
    <label for="new_content">Modifier votre commentaire :</label>
    <textarea name="new_content" id="new_content"
        required><?php echo htmlspecialchars($commentaire['content']); ?></textarea>

    <button type="submit">Enregistrer</button>
</form>

<?php
// Traitement de la mise à jour du commentaire en POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newContent = $_POST['new_content']; // Le contenu du commentaire

    // Mise à jour du commentaire dans la base de données
    $requeteUpdate = "UPDATE blog_comments SET content = '$newContent' WHERE id_commentaire = $idCommentaire";
    $result = mysqli_query($connection, $requeteUpdate);

    if ($result) {
        // Redirection vers l'article après mise à jour
        header("Location: /EchimineVibes/index.php?page=detailPost&id=" . $idArticle);
        exit;
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>