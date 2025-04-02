<?php
session_start();
include("../connection_session/connection.php");
var_dump($_POST);

$idUser = $_POST["id_user"];
$idArticle = $_POST["idArticle"];
$idCommentaire = $_POST["id_commentaire"];

$sql = "DELETE FROM blog_comments WHERE id_commentaire = $idCommentaire";

if (mysqli_query($connection, $sql)) {
    echo "le commentaire $idCommentaire a été supprimé";
} else {
    echo "Erreur : " . mysqli_error($connection);
}