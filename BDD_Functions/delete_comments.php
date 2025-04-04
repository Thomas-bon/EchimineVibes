<?php
session_start();
include("../connection_session/connection.php");

$idArticle = (int) $_POST["idArticle"];
$idCommentaire = (int) $_POST["id_commentaire"];
$currentUser = (int) $_SESSION["user"];
$role = $_SESSION["role"];

$sqlCheck = "SELECT id_user FROM blog_comments WHERE id_commentaire = ?";
$stmtCheck = $connection->prepare($sqlCheck);
$stmtCheck->bind_param("i", $idCommentaire);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result->num_rows === 0) {
    echo "Commentaire introuvable.";
    exit;
}

$row = $result->fetch_assoc();
$auteurCommentaire = (int) $row["id_user"];

if ($currentUser === $auteurCommentaire || $role === 'admin') {
    $sqlDelete = "DELETE FROM blog_comments WHERE id_commentaire = ?";
    $stmtDelete = $connection->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $idCommentaire);
    $stmtDelete->execute();

    header("Location: /Blog/index.php?page=detailPost&id=$idArticle");
    exit;
} else {
    header("Location: /Blog/index.php?page=detailPost&id=$idArticle");
    exit;
}
?>
