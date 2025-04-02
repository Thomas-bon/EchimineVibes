<?php

// echo '<h1>test</h1>';

function supprimerEnregistrement($id) {
    // Connexion à la base de données
    include("../connection_session/connection.php");

    $connection = mysqli_connect($servername, $username, $password, $database);

    if (!$connection) {
        die("Connexion échouée : " . mysqli_connect_error());
    }

    // $id = intval($id); // Sécurisation de l'ID

    $sql = "DELETE FROM blog_article WHERE id_article = $id";

    if (mysqli_query($connection, $sql)) {
        echo "Enregistrement ID $id supprimé avec succès.";
    } else {
        echo "Erreur : " . mysqli_error($connection);
    }

    
}

// Vérifie si un ID est présent dans l'URL
if (isset($_GET['id'])) {
    supprimerEnregistrement($_GET['id']);
} else {
    echo "Aucun ID fourni pour la suppression.";
}
