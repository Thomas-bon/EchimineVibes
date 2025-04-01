
<div id="loginPage">
    <div class="login-container">
        <h2>Créer son compte</h2>
        <form action="?page=register" method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="password_confirm" placeholder="Confirme mot de passe" required>

            <?php

            if ($_POST) {
                $password = $_POST["password"];
                $confirm_password = $_POST["password_confirm"];

                if ($password !== $confirm_password) {
                    echo "Les mots de passe ne correspondent pas.";

                } else {

                    $nom = $_POST["nom"];
                    $prenom = $_POST["prenom"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];

                    $connection = mysqli_connect("localhost", "root", "", "ma_super_bdd");

                    if (!$connection) {
                        die("Connection BDD impossible");
                    } else {

                        $query = "INSERT INTO utilisateurs (nom_user, prenom_user, email_user, password_user) VALUES ('$nom', '$prenom', '$email', '$password')";

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
        align-items: center;
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