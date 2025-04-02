<div id="loginPage">
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="?page=login" method="post">
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


                $requeteFindMail = mysqli_query($connection, "SELECT * FROM blog_user WHERE user_mail = '$email_input'");
                $requeteFindPassword = mysqli_query($connection, "SELECT * FROM blog_user WHERE user_mdp = '$password_input'");

                $id_user_query = mysqli_query($connection, "SELECT id_user FROM blog_user WHERE user_mail = '$email_input' AND user_mdp = '$password_input'");
                $id_user = mysqli_fetch_assoc($id_user_query);

                $role_user_query = mysqli_query($connection, "SELECT user_role FROM blog_user WHERE user_mail = '$email_input' AND user_mdp = '$password_input'");
                $role_user = mysqli_fetch_assoc($role_user_query);


                if ($id_user && mysqli_num_rows($requeteFindMail) > 0) {
                    if (mysqli_num_rows($requeteFindPassword) > 0) {

                        $_SESSION["user"] = $id_user["id_user"]; 
                        $_SESSION["role"] = $role_user["user_role"];
                        header("Location: ?");
                        exit();


                    } else {
                        echo "Mot de passe incorrect.";
                    }

                } else {
                    echo "Aucun utilisateur trouvé avec cet email.";
                }

            }

        }




        ?>


        <a href="?page=logout"><button>DECONNECTER</button></a>

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