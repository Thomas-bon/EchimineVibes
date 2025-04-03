<div id="loginPage">
    <div class="login-container">
        <h2>Connexion</h2>
        <form class="auth-container" action="?page=login" method="post">
            <input type="email" name="email_input" placeholder="Email d'utilisateur" required>
            <input type="password" name="password_input" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
            <a href="?page=register" id="registerHere">S'inscrire ici.</a>
        </form>

        <?php

        if ($_POST) {

            $connection = mysqli_connect($servername, $username, $password, $database);

            $password_input = $_POST["password_input"];
            $email_input = $_POST["email_input"];

            if (!$connection) {
                die("Connection BDD impossible");
            } else {
                // Utilisation d'une requête préparée pour récupérer l'utilisateur
                $requeteFindUser = mysqli_prepare($connection, "SELECT * FROM blog_user WHERE user_mail = ?");
                mysqli_stmt_bind_param($requeteFindUser, "s", $email_input);
                mysqli_stmt_execute($requeteFindUser);
                $result = mysqli_stmt_get_result($requeteFindUser);

                if ($user = mysqli_fetch_assoc($result)) {
                    // Vérification du mot de passe
                    if (password_verify($password_input, $user['user_mdp'])) {
                        $_SESSION["user"] = $user["id_user"];
                        $_SESSION["role"] = $user["user_role"];
                        $_SESSION["user_name"] = $user["user_pseudo"];
                        header("Location: ?");
                        exit();
                    } else {
                        echo "Mot de passe incorrect. <br>";
                        var_dump($password_input);
                        var_dump($user['user_mdp']);

                    }
                } else {
                    echo "Aucun utilisateur trouvé avec cet email.";
                }

                mysqli_stmt_close($requeteFindUser);
            }
        }





        ?>


        <a href="?page=logout"><button class="btn-primary">DECONNECTER</button></a>

    </div>
</div>



<style>
    #signInHere {
        flex-direction: row;
    }

    #loginPage {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .login-container {
        background: white;
        padding: 60px;
        /* Tripler le padding */
        border-radius: 30px;
        /* Tripler le rayon du bord */
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        /* Tripler l'intensité de l'ombre */
        width: 500px;
        /* Tripler la largeur */
        text-align: center;
    }

    .login-container h2 {
        color: #ff7f50;
        font-size: 2rem;
        /* Tripler la taille de la police */
    }

    .login-container input {
        width: 90%;
        padding: 20px;
        /* Tripler le padding */
        margin: 30px 0 0 0;
        /* Tripler les marges */
        border: 3px solid #ccc;
        /* Tripler l'épaisseur de la bordure */
        border-radius: 15px;
        /* Tripler le rayon du bord */
        font-size: 1rem;
        /* Tripler la taille de la police */
    }

    .login-container button {
        width: 100%;
        padding: 20px;
        /* Tripler le padding */
        background-color: #ff7f50;
        border: none;
        color: white;
        border-radius: 15px;
        margin-top: 30px;
        /* Tripler le rayon du bord */
        cursor: pointer;
        font-size: 1.5rem;
        /* Tripler la taille de la police */
    }

    .login-container button:hover {
        background-color: #e67340;
    }
</style>