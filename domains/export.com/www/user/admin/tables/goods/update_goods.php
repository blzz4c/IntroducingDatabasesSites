<!DOCTYPE html>
<html>
<head>
    <title>Обновление информации</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>
<?php
$db_host = 'localhost';
$db_user = 'admin';
$db_password = 'password';
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
// если запрос GET
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["goods_article"]))
{
    $goods_article = $link->real_escape_string($_GET["goods_article"]);
    $sql = "SELECT * FROM goods WHERE goods_article = '$goods_article'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $goods_name = $row["goods_name"];
                $goods_lifetime = $row["goods_lifetime"];
                $goods_price = $row["goods_price"];
                $factory_id = $row["factory_id"];
            }
            echo "<h3>Обновление товаров</h3>
                <form method='post'>
                    <input type='hidden' name='goods_article' value='$goods_article' />
                    <p>Название товара:
                    <input type='text' name='goods_name' value='$goods_name' required/></p>
                    <p>Срок годности товара (в днях):
                    <input type='text' name='goods_lifetime' value='$goods_lifetime' required/></p>
                    <p>Цена товара:
                    <input type='text' name='goods_price' value='$goods_price' required/></p>
                    <p>Завод-производитель
                    <input type='text' name='factory_id' value='$factory_id' required/></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Товар не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["goods_article"]) && isset($_POST["goods_name"]) && isset($_POST["goods_lifetime"]) && isset($_POST["goods_price"]) && isset($_POST["factory_id"])){
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $goods_name = $link->real_escape_string($_POST["goods_name"]);
    $goods_lifetime = $link->real_escape_string($_POST["goods_lifetime"]);
    $goods_price = $link->real_escape_string($_POST["goods_price"]);
    $factory_id = $link->real_escape_string($_POST["factory_id"]);
    if ($goods_lifetime == '')
        $goods_lifetime = null;
    $sql = "UPDATE goods SET goods_name = '$goods_name', goods_lifetime = '$goods_lifetime', goods_price = '$goods_price', factory_id = '$factory_id' WHERE goods_article = '$goods_article'";
    if($result = $link->query($sql)){
        header("Location: ../../admin.php");
    } else{
        echo "Ошибка: " . $link->error;
    }
}
else{
    echo "Некорректные данные";
}
$link->close();
?>
</body>
</html>