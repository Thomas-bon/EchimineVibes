<div id="loginPage">
    <div class="login-container">
        <h2>Créer son compte</h2>
        <form action="?page=register" method="post">
            <input type="text" name="pseudo" placeholder="Pseudo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="password_confirm" placeholder="Confirme mot de passe" required>

            <?php

            if ($_POST) {
                $password = $_POST["password"];
                $confirm_password = $_POST["password_confirm"];

                if ($password !== $confirm_password) {
                    echo "<br> Les mots de passe ne correspondent pas.";

                } else {

                    $pseudo = $_POST["pseudo"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];



                    if (!$connection) {
                        die("Connection BDD impossible");
                    }

                    $queryCheckEmail = "SELECT * FROM blog_user WHERE user_mail = '$email'";
                    $resultCheckEmail = mysqli_query($connection, $queryCheckEmail);

                    if (mysqli_num_rows($resultCheckEmail) > 0) {
                        echo "<br> L'email est déjà utilisé, veuillez en choisir un autre.";
                    } else {

                        $query = "INSERT INTO blog_user (user_mail, user_pseudo, user_mdp, user_role) VALUES ('$email', '$pseudo', '$password', 'user')";

                        if (mysqli_query($connection, $query)) {
                            echo "Inscription réussie !";
                        } else {
                            echo "Erreur lors de l'inscription : " . mysqli_error($connection);
                        }
                    }
                }
            }


            ?>

            <button type="submit">Créer son compte</button>

            <a href="?page=login" id="signInHere">Se connecter ici.</a>
        </form>
    </div>
</div>




<style>
    #signInHere {
        flex-direction: row;
    }

    #loginPage {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-top: 2%;
        width: 100%;
        height: 100%;
    }

    .login-container {
        background: white;
        padding: 10px;
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