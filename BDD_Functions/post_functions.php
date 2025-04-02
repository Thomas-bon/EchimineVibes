<?php

    var_dump($_POST);


if(isset($_POST["title"])) {
    $title = $_POST["title"];
}

if(isset($_POST["content"])) {
    $content = $_POST["content"];
}

if(isset($_POST["status"])) {
    $status = $_POST["status"];
}

if(isset($_POST["image"])) {
    $image = $_POST["image"];
}