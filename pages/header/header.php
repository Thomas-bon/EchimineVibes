<header>
    <div>
        <ul>
            <li>
                <a href="index.php">ECHIMINE</a>

            </li>
            <nav>
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        Articles
                    </li>
                </ul>
            </nav>
            <li>
                <i class="fa-regular fa-circle-user"></i>
                
                <?php
                if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
                    echo '<a href="?page=admin_dashboard">Accéder au panneau d\'administration</a>';
                }
                ?>

            </li>
        </ul>
    </div>

</header>