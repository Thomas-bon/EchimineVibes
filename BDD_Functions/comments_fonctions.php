<?php
include('../connection_session/connection.php');
// Debugging
var_dump($_POST); 

// Récupération des données du formulaire
$idArticle = $_POST['idArticle'];
$content = $_POST['texte'];
$user = $_POST['id_user'];

// Requête SQL pour insérer un commentaire dans la base de données
$sql = "INSERT INTO blog_comments (id_article, id_user, content) 
        VALUES ('$idArticle', '$user', '$content')";

// Exécution de la requête
if ($connection->query($sql) === TRUE) {
    echo "✅ Commentaire ajouté avec succès!";
} else {
    echo "❌ Erreur lors de l'insertion du commentaire : " . $connection->error;
}
?>
