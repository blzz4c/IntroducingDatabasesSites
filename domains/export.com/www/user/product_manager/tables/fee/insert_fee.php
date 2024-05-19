<!DOCTYPE html>
<html>
<head>
    <title>Добавление информации</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>
<form method='post' name="insert_fee">
    <p>Страна:
        <input type='text' name='country_id' value='' required/></p>
    <p>Товар:
        <input type='text' name='goods_article' value='' required /></p>
    <p>Пошлина:
        <input type='text' name='fee' value='' required /></p>
    <input type='submit' name="insert_fee" value='Добавить'>
</form>
<?php
$db_host = 'localhost';
$db_user = 'admin';
$db_password = 'password';
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

if (isset($_POST["insert_fee"])) {
    $country_id = $link->real_escape_string($_POST["country_id"]);
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $fee = $link->real_escape_string($_POST["fee"]);
    $sql = "INSERT INTO fee (country_id, goods_article, fee) VALUES ('$country_id', '$goods_article', '$fee')";
    if($link->query($sql)){
        header("Location: ../../admin.php");
    } else{
        echo "Ошибка: " . $link->error;
    }
}
$link->close();
?>
</body>
</html>
