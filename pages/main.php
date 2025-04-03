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

        nav {
            text-align: center;
            margin-bottom: 20px;
        }

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
    <a href=".\pages\postEdit.php">postEdit</a>
    <button> <a href="?page=login">LOGIN PAGE</a></button>
    <?php

    if (!$connection) { //Si la connexion n'a pas été effectué
        die("Connection impossible");
    } else {
        $requete = mysqli_query($connection, "SELECT * FROM `blog_article`WHERE status_article = 1");
        echo '<div class="article-grid">';
        while ($resultat = mysqli_fetch_array($requete)) {
            $link = '?page=detailPost&id=' . $resultat['id_article'];
            // $imagePath = '/EchimineVibes/BDD_Functions/uploads/' . $resultat['id_user'] . '/' . $resultat['img_article'];
            $imagePath = '/EchimineVibes/BDD_Functions/'. $resultat['img_article'];
            echo '<a class="article-card" href="' . $link . '">';
            echo '  <img src="' . $imagePath . '" alt="Image de l\'article">';
            echo '  <div class="article-card-content">';
            echo '    <h3>' . htmlspecialchars($resultat['title']) . '</h3>';
            echo '    <p>' . substr(strip_tags($resultat['content']), 0, 100) . '...</p>';
            echo '  </div>';
            echo '</a>';
        }
        echo '</div>';
    }

    ?>
</body>

</html>

<style>
    .article-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 24px;
  padding: 20px;
}

.article-card {
  text-decoration: none;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease, box-shadow 0.3s ease;
}

.article-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
}

.article-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

.article-card-content {
  padding: 16px;
}

.article-card h3 {
  font-size: 20px;
  color: #1f2937;
  margin-bottom: 10px;
}

.article-card p {
  color: #475569;
  font-size: 15px;
  line-height: 1.5;
}

</style>