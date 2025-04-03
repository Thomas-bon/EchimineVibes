<?php
include("connection_session/connection.php");
; // Assure-toi que la connexion est correcte

if (!isset($_SESSION['user'])) {
    die("Erreur : Vous devez être connecté pour modifier un post.");
}

$id_user = $_SESSION['user'];
$message = ""; // Variable pour afficher un message après soumission

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id_user'], $_POST['title'], $_POST['content'], $_POST['status'])) {
        $message = "❌ Erreur : Données manquantes.";
    } else {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $status = $_POST["status"];

        // Insérer l'article sans image
        $sql = "INSERT INTO blog_article (id_user, title, content, status_article) VALUES ('$id_user', '$title', '$content', '$status')";
        if ($connection->query($sql) === TRUE) {
            $article_id = $connection->insert_id; // Récupérer l'ID de l'article
            $message = "✅ Article ajouté avec succès ! ID : $article_id";

            // Vérifier si une image est envoyée
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                $uploadDir = "uploads/$id_user/";

                // Vérifier/créer le dossier utilisateur
                if (!file_exists($uploadDir) && !mkdir($uploadDir, 0777, true)) {
                    $message .= "<br>❌ Erreur : impossible de créer le dossier '$uploadDir'";
                } else {
                    $imageTmpName = $_FILES["image"]["tmp_name"];
                    $imageExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                    $imageName = $article_id . "." . $imageExtension;
                    $imagePath = $uploadDir . $imageName;

                    // Vérifier l'extension de l'image
                    $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    if (!in_array($imageExtension, $validExtensions)) {
                        $message .= "<br>❌ Erreur : L'image doit être au format JPG, JPEG, PNG, ou GIF.";
                    } elseif (move_uploaded_file($imageTmpName, $imagePath)) {
                        // Mettre à jour l'article avec l'image
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
