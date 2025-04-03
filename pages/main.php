<?php include("./connection_session/connection.php"); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accueil</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #1e293b;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 24px;
        }

        h1 {
            text-align: center;
            color: #38bdf8;
            font-size: 32px;
            margin-bottom: 30px;
        }

        .nav-links {
            text-align: center;
            margin-bottom: 30px;
        }

        .nav-links a {
            display: inline-block;
            background-color: #38bdf8;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #0ea5e9;
        }

        .article-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 colonnes */
            gap: 24px;
            padding: 10px;
        }


        .article-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            text-decoration: none;
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
</head>

<body>
    <div class="container">
        <h1>Accueil</h1>
        <div class="nav-links">
            <a href="?page=postEdit">Créer un article</a>
            <a href="?page=login">Se connecter</a>
        </div>

        <?php
        $requete = mysqli_query($connection, "SELECT * FROM `blog_article` WHERE status_article = 1 ORDER BY creation_date DESC");
        echo '<div class="article-grid">';
        while ($resultat = mysqli_fetch_array($requete)) {
            $link = '?page=detailPost&id=' . $resultat['id_article'];
            $imagePath = isset($resultat['img_article']) && trim($resultat['img_article']) !== ''
                ? '.' . $resultat['img_article']
                : 'uploads/default.jpg';


            echo '<a class="article-card" href="' . $link . '">';
            echo '  <img src="' . $imagePath . '" alt="Image de l\'article">';
            echo '  <div class="article-card-content">';
            echo '    <h3>' . htmlspecialchars($resultat['title']) . '</h3>';
            echo '    <p>' . substr(strip_tags($resultat['content']), 0, 100) . '...</p>';
            echo '  </div>';
            echo '</a>';
        }
        echo '</div>';
        ?>

    </div>
</body>

</html>