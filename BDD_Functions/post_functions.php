<?php
include('../connection.php');

var_dump($_POST);


    $id_user = 1;
    $title = $_POST["title"];
    $content = $_POST["content"];
    $status = $_POST["status"];
    $image = $_POST["image"];
    
    // Requête SQL
    $sql = "INSERT INTO blog_article (id_user, title, content, status_article) 
            VALUES ('$id_user','$title', '$content', '$status')";
    
    $connection->query($sql);
    echo "c'est bon";