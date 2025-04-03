<?php
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("Accès refusé. Vous n'avez pas les droits administrateur.");
}

include("connection_session/connection.php");

if (!$connection) {
    die("Connexion à la BDD impossible");
}

// Ajouter un utilisateur
if (isset($_POST['add_user'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $pseudo = mysqli_real_escape_string($connection, $_POST['pseudo']);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO blog_user (user_mail, user_mdp, user_role, user_pseudo) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $email, $password_hash, $role, $pseudo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "Utilisateur ajouté avec succès.";
}

// Modifier un utilisateur
if (isset($_POST['update_user'])) {
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $pseudo = mysqli_real_escape_string($connection, $_POST['pseudo']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);

    $query = "UPDATE blog_user SET user_mail = '$email', user_role = '$role', user_pseudo = '$pseudo' WHERE id_user = '$user_id'";
    mysqli_query($connection, $query);
    echo "Utilisateur modifié avec succès.";
}

// Supprimer un utilisateur
if (isset($_GET['delete_user'])) {
    $user_id = mysqli_real_escape_string($connection, $_GET['delete_user']);

    $query = "SELECT * FROM blog_user WHERE id_user = '$user_id'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        if (mysqli_query($connection, "DELETE FROM blog_user WHERE id_user = '$user_id'")) {
            echo "✅ Utilisateur supprimé avec succès.";
        } else {
            echo "❌ Erreur : " . mysqli_error($connection);
        }
    } else {
        echo "❌ L'utilisateur n'existe pas.";
    }
}

$users_query = mysqli_query($connection, "SELECT * FROM blog_user");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panneau d'administration</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #1e293b;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            padding: 24px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        }

        h1 {
            text-align: center;
            color: #0f172a;
            font-size: 32px;
            margin-bottom: 30px;
        }

        h2 {
            color: #38bdf8;
            margin-bottom: 16px;
        }

        form {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        input,
        select {
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fff;
        }

        button {
            padding: 12px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-primary {
            background-color: #38bdf8;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0ea5e9;
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
            padding: 10px 18px;
            text-align: center;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: scale(1.03);
        }

        .btn-danger:active {
            transform: scale(0.97);
        }


        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 14px;
            border: 1px solid #e2e8f0;
            /* bordure sur toutes les cellules */
            text-align: left;
        }


        th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-size: 15px;
        }

        td {
            background-color: #ffffff;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .actions form {
            background: none;
            padding: 0;
            box-shadow: none;
        }

        a {
            color: #ef4444;
            font-weight: 600;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .actions {
                flex-direction: column;
            }

            form {
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <div class="container">
            <h1>Panneau d'administration</h1>

            <!-- Formulaire pour ajouter un utilisateur -->
            <h2>Ajouter un utilisateur</h2>
            <form method="POST">
                <input type="text" name="pseudo" placeholder="Nom de l'utilisateur" required>
                <input type="email" name="email" placeholder="Email de l'utilisateur" required>
                <input type="text" name="password" placeholder="Mot de passe" required>
                <select name="role">
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>
                <button class="btn-primary" type="submit" name="add_user">Ajouter l'utilisateur</button>
            </form>

            <!-- Liste des utilisateurs -->
            <h2>Liste des utilisateurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Posts</th>
                        <th>Commentaires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users_query)) :
                        $user_id = $user['id_user'];

                        $post_count_query = mysqli_query($connection, "SELECT COUNT(*) AS total_posts FROM blog_article WHERE id_user = $user_id");
                        $post_count = mysqli_fetch_assoc($post_count_query)['total_posts'];

                        $comment_count_query = mysqli_query($connection, "SELECT COUNT(*) AS total_comments FROM blog_comments WHERE id_user = $user_id");
                        $comment_count = mysqli_fetch_assoc($comment_count_query)['total_comments'];
                    ?>
                        <tr>
                            <td><?= $user_id ?></td>
                            <td><?= $user['user_pseudo'] ?></td>
                            <td><?= $user['user_mail'] ?></td>
                            <td><?= $user['user_role'] ?></td>
                            <td><?= $post_count ?></td>
                            <td><?= $comment_count ?></td>
                            <td class="actions">
                                <form method="POST">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <input type="text" name="pseudo" value="<?= $user['user_pseudo'] ?>" required>
                                    <input type="email" name="email" value="<?= $user['user_mail'] ?>" required>
                                    <select name="role">
                                        <option value="user" <?= $user['user_role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                        <option value="admin" <?= $user['user_role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                    </select>
                                    <button class="btn-primary" type="submit" name="update_user">Mettre à jour</button>
                                </form>
                                <a class="btn-danger" href="?delete_user=<?= $user_id ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php mysqli_close($connection); ?>