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
<form method='post' name="insert_goods">
    <p>Артикул товара:
        <input type='text' name='goods_article' value='' required/></p>
    <p>Название товара:
        <input type='text' name='goods_name' value='' required/></p>
    <p>Срок годности товара (в днях):
        <input type='text' name='goods_lifetime' value=''/></p>
    <p>Цена товара:
        <input type='text' name='goods_price' value='' required /></p>
    <p>Завод-производитель:
        <input type='text' name='factory_id' value='' required /></p>
    <input type='submit' name="insert_goods" value='Добавить'>
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

if (isset($_POST["insert_goods"])) {
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $goods_name = $link->real_escape_string($_POST["goods_name"]);
    $goods_lifetime = $link->real_escape_string($_POST["goods_lifetime"]);
    $goods_price = $link->real_escape_string($_POST["goods_price"]);
    $factory_id = $link->real_escape_string($_POST["factory_id"]);
    $sql = "INSERT INTO goods (goods_article, goods_name, goods_lifetime, goods_price, factory_id) VALUES ('$goods_article', '$goods_name', '$goods_lifetime', '$goods_price', '$factory_id')";
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
