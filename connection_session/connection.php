<?php

$online = true;

if ($online) {

    $servername = "gobeliparichert.mysql.db";
    $username = "gobeliparichert";
    $password = "Campusdigital74";
    $database = "gobeliparichert";
    $connection = mysqli_connect($servername, $username, $password, $database);


} else {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "test_blog"; // METTRE LE NOM DE LA BDD QUE VOUS AVEZ CHOISIS ICI
    $connection = mysqli_connect($servername, $username, $password, $database);


}