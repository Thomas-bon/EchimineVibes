<?php
session_start();
include("../connection_session/connection.php");
// var_dump($_POST);

$idUser = $_POST["id_user"];
$idArticle = $_POST["idArticle"];
$idCommentaire = $_POST["id_commentaire"];

if ($idUser === $_SESSION["user"] || $_SESSION["role"] === 'admin') {
    $sql = "DELETE FROM blog_comments WHERE id_commentaire = $idCommentaire";

    if (mysqli_query($connection, $sql)) {

        header("Location: /Blog/index.php?page=detailPost&id=$idArticle");


    } else {
        echo "Erreur : " . mysqli_error($connection);
    }
} else {
    echo "vous ne pouvez pas supprimer";
    header("Location: /Blog/index.php?page=detailPost&id=$idArticle");
}