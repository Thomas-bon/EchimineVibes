<?php
    session_start();
    echo $_SESSION['user']; 
    $id_user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Post Edit</h1>
    <form action="..\BDD_Functions\post_functions.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" value= "<?php echo $id_user ?>" id="id_user" name="id_user">
        <label for="title"></label>
            <input type="text" id="title" name="title">
        
        <label for="content"></label>
            <textarea type="text" id="content" name="content"></textarea>

        <label for="status"></label>
            <select name="status" id="status">
                <option value="1">Affiché</option>
                <option value="0">Brouillon</option>
            </select>
        
        <input type="file" id="image" name="image">

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>