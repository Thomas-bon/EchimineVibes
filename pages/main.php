<?php
include("./connection_session/connection.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    color: #343a40;
}

.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #007bff;
    text-align: center;
}

/* nav {
    text-align: center;
    margin-bottom: 20px;
} */

nav a {
    text-decoration: none;
    color: #007bff;
    margin: 0 15px;
    font-size: 18px;
    font-weight: bold;
}

nav a:hover {
    color: #0056b3;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
    display: inline-block;
    margin: 10px 0;
    transition: background-color 0.3s ease;
}

button a {
    color: white;
    text-decoration: none;
}

button:hover {
    background-color: #0056b3;
}

.article-list {
    list-style: none;
    padding: 0;
}

.article-list li {
    background: #ffffff;
    margin: 15px 0;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.article-list li:hover {
    transform: scale(1.02);
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.article-list a {
    text-decoration: none;
    color: #007bff;
    font-size: 22px;
    font-weight: bold;
    display: block;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
}

.article-list a:hover {
    color: white;
    background-color: #007bff;
    text-decoration: underline;
    transform: translateY(-2px);
}



    </style>
</head>

<body>
    <h1>home page</h1>
    <a href="?page=postEdit">postEdit</a>
    <button> <a href="?page=login">LOGIN PAGE</a></button>
    <?php

        if (!$connection) { //Si la connexion n'a pas été effectué
            die("Connection impossible");
        } else {
            $requete = mysqli_query($connection, "SELECT * FROM `blog_article`WHERE status_article = 1");
            echo "<div>";
            while($resultat=mysqli_fetch_array($requete)) {
                $link='?page=detailPost&id='.$resultat['id_article'];
                echo '<div>'.'<a href="'.$link.'"'.'<h1>'.$resultat['title'].'</h1>'.'</a>'.'</div>'.'<br>';
                }
            echo "</div>";
            }

    ?>
</body>

</html>