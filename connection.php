<?php

$servername = "gobeliparichert.mysql.db";
$username = "gobeliparichert";
$password = "Campusdigital74";
$database = "gobeliparichert";

$connection = mysqli_connect($servername, $username, $password, $database);
$password_input = $_POST["password_input"];
$email_input = $_POST["email_input"];