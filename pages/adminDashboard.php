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
    $password = password_hash(mysqli_real_escape_string($connection, $_POST['password']), PASSWORD_BCRYPT);  // On hache le mot de passe
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $pseudo = mysqli_real_escape_string($connection, $_POST['pseudo']);
    
    $query = "INSERT INTO blog_user (user_mail, user_mdp, user_role, user_pseudo) VALUES ('$email', '$password', '$role', '$pseudo')";
    mysqli_query($connection, $query);
    echo "Utilisateur ajouté avec succès.";
}

// Modifier un utilisateur
if (isset($_POST['update_user'])) {
    $user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
  
    $pseudo = mysqli_real_escape_string($connection, $_POST['pseudo']);
    
    $query = "UPDATE blog_user SET user_mail = '$email', user_role = '$role', user_pseudo = '$pseudo' WHERE id_user = '$user_id'";
    mysqli_query($connection, $query);
    echo "Utilisateur modifié avec succès.";
}

// Supprimer un utilisateur
if (isset($_GET['delete_user'])) {
    $user_id = mysqli_real_escape_string($connection, $_GET['delete_user']);
    $query = "DELETE FROM blog_user WHERE id_user = '$user_id'";
    mysqli_query($connection, $query);
    echo "Utilisateur supprimé avec succès.";
}

// Récupérer tous les utilisateurs
$users_query = mysqli_query($connection, "SELECT * FROM blog_user");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau d'administration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #ff7f50;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #ff7f50;
            color: white;
            cursor: pointer;
            font-size: 1.1rem;
            border: none;
        }

        button:hover {
            background-color: #e67340;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f8f8f8;
            color: #333;
        }

        td {
            background-color: #fafafa;
        }

        .container a {
            color: #ff7f50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions form {
            margin: 0;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Panneau d'administration</h1>

        <!-- Formulaire pour ajouter un utilisateur -->
        <h2>Ajouter un utilisateur</h2>
        <form action="admin_dashboard.php" method="POST">
            <input type="text" name="pseudo" placeholder="Nom de l'utilisateur" required>
            <input type="email" name="email" placeholder="Email de l'utilisateur" required>
            <input type="text" name="password" placeholder="Mot de passe" required>
            <select name="role">
                <option value="user">Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select>
            <button type="submit" name="add_user">Ajouter l'utilisateur</button>
        </form>

        <h2>Liste des utilisateurs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($users_query)): ?>
                    <tr>
                        <td><?php echo $user['id_user']; ?></td>
                        <td><?php echo $user['user_pseudo']; ?></td>
                        <td><?php echo $user['user_mail']; ?></td>
                        <td><?php echo $user['user_role']; ?></td>
                        <td class="actions">
                            <!-- Formulaire pour modifier un utilisateur -->
                            <form action="admin_dashboard.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo $user['id_user']; ?>">
                                <input type="text" name="pseudo" value="<?php echo $user['user_pseudo']; ?>" required>
                                <input type="email" name="email" value="<?php echo $user['user_mail']; ?>" required>
                                <select name="role">
                                    <option value="user" <?php if ($user['user_role'] === 'user') echo 'selected'; ?>>Utilisateur</option>
                                    <option value="admin" <?php if ($user['user_role'] === 'admin') echo 'selected'; ?>>Administrateur</option>
                                </select>
                                <button type="submit" name="update_user">Mettre à jour</button>
                            </form>
                            
                            <!-- Lien pour supprimer un utilisateur -->
                            <a href="?delete_user=<?php echo $user['id_user']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Fermeture de la connexion à la BDD
mysqli_close($connection);
?>
