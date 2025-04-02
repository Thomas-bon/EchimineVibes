<?php
include('../connection_session/connection.php');
session_start();

// // Debugging
// var_dump($_POST); // Pour voir les données envoyées via le formulaire
// var_dump($_FILES); // Pour voir les fichiers envoyés

// Vérification des données reçues
if (!isset($_POST['id_user'], $_POST['title'], $_POST['content'], $_POST['status'])) {
    die("❌ Erreur : Données manquantes.");
}

$id_user = $_POST['id_user']; // ID utilisateur depuis le formulaire
$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];

// Insérer l'article en BDD sans l'image pour récupérer son ID
$sql = "INSERT INTO blog_article (id_user, title, content, status_article) 
        VALUES ('$id_user', '$title', '$content', '$status')";
if ($connection->query($sql) === TRUE) {
    $article_id = $connection->insert_id; // Récupération de l'ID de l'article
    echo "✅ Article inséré avec ID : $article_id <br>";
    header("Location: /EchimineVibes/index.php");

} else {
    die("❌ Erreur lors de l'insertion : " . $connection->error);
}

// Vérifier si une image est envoyée
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    // Répertoire de téléchargement des images, dépendant de l'ID de l'utilisateur
    $uploadDir = "uploads/$id_user/";

    // Vérifier et créer le dossier de l'utilisateur si besoin
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die("❌ Erreur : impossible de créer le dossier '$uploadDir'");
        } else {
            echo "✅ Dossier créé avec succès : $uploadDir <br>";
        }
    }

    // Récupérer l'extension du fichier
    $imageTmpName = $_FILES["image"]["tmp_name"];
    $imageExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $imageName = $article_id . "." . $imageExtension; // Renommer avec l'ID de l'article
    $imagePath = $uploadDir . $imageName;

    // Vérifier si l'image est une image valide (exemple avec les extensions jpg, jpeg, png)
    $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageExtension, $validExtensions)) {
        die("❌ Erreur : L'image doit être au format JPG, JPEG, PNG, ou GIF.");
    }

    // Déplacer l'image dans le dossier
    if (move_uploaded_file($imageTmpName, $imagePath)) {
        echo "✅ Image enregistrée : $imagePath <br>";

        // Mettre à jour l'article avec le chemin de l'image dans la BDD
        $sqlUpdate = "UPDATE blog_article SET img_article = '$imagePath' WHERE id_article = $article_id";
        if ($connection->query($sqlUpdate) === TRUE) {
            echo "✅ Image enregistrée en BDD <br>";
        } else {
            die("❌ Erreur lors de la mise à jour de l'image : " . $connection->error);
        }
    } else {
        die("❌ Erreur lors du déplacement de l'image.");
    }
} else {
    echo "⚠️ Aucune image reçue ou erreur d'upload.";
}

echo "Article ajouté avec succès ! <a href='../index.php'>Retour à la liste</a> <br>";


echo "Utilisateur connecté : " . ($_SESSION['user'] ?? 'Non défini');
?>
