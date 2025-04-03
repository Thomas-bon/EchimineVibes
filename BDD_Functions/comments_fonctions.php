<?php
include('../connection_session/connection.php');

// Récupération des données du formulaire et sécurisation
$idArticle = mysqli_real_escape_string($connection, $_POST['idArticle']);
$content = mysqli_real_escape_string($connection, $_POST['texte']);
$user = mysqli_real_escape_string($connection, $_POST['id_user']);

// Requête SQL sécurisée
$sql = "INSERT INTO blog_comments (id_article, id_user, content) 
        VALUES ('$idArticle', '$user', '$content')";

// Exécution
if ($connection->query($sql) === TRUE) {
    echo "✅ Commentaire ajouté avec succès!";
    header("Location: /Blog/index.php?page=detailPost&id=$idArticle");
    // exit(); <-- à activer si tu veux couper ici
} else {
    echo "❌ Erreur lors de l'insertion du commentaire : " . $connection->error;
}

?>
