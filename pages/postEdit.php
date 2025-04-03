<?php
include("connection_session/connection.php");

if (!isset($_SESSION['user'])) {
    die("Erreur : Vous devez être connecté pour modifier un post.");
}


$id_user = $_SESSION['user'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id_user'], $_POST['title'], $_POST['content'], $_POST['status'])) {
        $message = "❌ Erreur : Données manquantes.";
    } else {
        $title = $connection->real_escape_string($_POST["title"]);
        $content = $connection->real_escape_string($_POST["content"]);
        $status = (int) $_POST["status"];

        // Insérer l'article
        $sql = "INSERT INTO blog_article (id_user, title, content, status_article) VALUES ('$id_user', '$title', '$content', '$status')";
        if ($connection->query($sql) === TRUE) {
            $article_id = $connection->insert_id;
            $message = "✅ Article ajouté avec succès ! ID : $article_id";

            // Si image présente
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
                $uploadDir = __DIR__ . "/uploads/$id_user/"; // __DIR__ donne le chemin absolu du script

                // Créer le dossier si besoin
                if (!file_exists($uploadDir)) {
                    if (!mkdir($uploadDir, 0777, true)) {
                        $message .= "<br>❌ Erreur : impossible de créer le dossier '$uploadDir'";
                    }
                }

                if (file_exists($uploadDir)) {
                    $imageTmpName = $_FILES["image"]["tmp_name"];
                    $imageExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                    $imageName = $article_id . "." . $imageExtension;
                    $imagePath = "/uploads/$id_user/" . $imageName; // Chemin relatif à stocker en DB
                    $fullPath = $uploadDir . $imageName; // Chemin absolu pour le move

                    $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                    if (!in_array($imageExtension, $validExtensions)) {
                        $message .= "<br>❌ Format de fichier non autorisé.";
                    } elseif (move_uploaded_file($imageTmpName, $fullPath)) {
                        $sqlUpdate = "UPDATE blog_article SET img_article = '$imagePath' WHERE id_article = $article_id";
                        if ($connection->query($sqlUpdate) === TRUE) {
                            $message .= "<br>✅ Image enregistrée.";
                        } else {
                            $message .= "<br>❌ Erreur lors de l'enregistrement de l'image.";
                        }
                    } else {
                        $message .= "<br>❌ Erreur lors du déplacement de l'image.";
                    }
                }
            }
        } else {
            $message = "❌ Erreur lors de l'insertion : " . $connection->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Edit</title>
</head>

<body>

    <h1>Post Edit</h1>

    <?php if (!empty($message)) { echo "<p style='color: red;'>$message</p>"; } ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $id_user; ?>" id="id_user" name="id_user">
        
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required>
        
        <label for="content">Contenu :</label>
        <textarea id="content" name="content" required></textarea>

        <label for="status">Statut :</label>
        <select name="status" id="status">
            <option value="1">Affiché</option>
            <option value="0">Brouillon</option>
        </select>
        
        <label for="image">Image :</label>
        <input type="file" id="image" name="image">

        <button type="submit">Envoyer</button>
    </form>

</body>

</html>
