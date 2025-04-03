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
    <div class="post-edit-container">
        <h1>Post Edit</h1>
        <form action="..\BDD_Functions\post_functions.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $id_user ?>" id="id_user" name="id_user">
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
    </div>
</body>

</html>

<style>
    .post-edit-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 32px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
    }

    .post-edit-container h1 {
        font-size: 28px;
        margin-bottom: 24px;
        color: #1f2937;
        text-align: center;
    }

    .post-edit-container form {
        display: flex;
        flex-direction: column;
    }

    .post-edit-container label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #1f2937;
    }

    .post-edit-container input[type="text"],
    .post-edit-container textarea,
    .post-edit-container select,
    .post-edit-container input[type="file"] {
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #f9fafb;
        transition: border-color 0.3s ease;
    }

    .post-edit-container input:focus,
    .post-edit-container textarea:focus,
    .post-edit-container select:focus {
        border-color: #38bdf8;
        outline: none;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
    }

    .post-edit-container button {
        background-color: #38bdf8;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .post-edit-container button:hover {
        background-color: #0ea5e9;
        transform: scale(1.02);
    }
</style>