<header>
    <div id="allHeader">
        <ul>
            <li id="icon">
                <a href="index.php">ECHIMINE</a>
            </li>
            <nav>
                <ul id="nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        Articles
                    </li>
                </ul>
            </nav>
            <div id="profile">
                <?php
                // Affichage du nom de l'utilisateur et du rôle
                if (isset($_SESSION["user"])) {
                    $user_pseudo = $_SESSION["user_name"]; // Remplacez par la récupération du nom de l'utilisateur depuis la base de données
                    if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
                        echo "<span >$user_pseudo  ADMIN</span>";
                    } else {
                        echo "<span >$user_pseudo  ECHIMIEN</span>";

                    }
                }
                ?>

                <?php
                if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
                    echo '<a href="?page=admin_dashboard">Accéder au panneau d\'administration</a>';
                } elseif (isset($_SESSION["role"]) && $_SESSION["role"] === "user") {
                    echo '<a href="?page=user_dashboard">Accéder au panneau d\'utilisateur</a>';
                }
                ?>

            </div>

        </ul>

    </div>
</header>

<style>
    #allHeader {
        display: flex;
        justify-content: center;
        align-items: center;

        position: relative;
    }

    #profile {
        display: flex;
        flex-direction: column;
    }

    #icon {
        position: absolute;

        left: 10%;
    }

    #profile {
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        right: 5%;
        width: 20%;
        /* display: none; */
    }
</style>