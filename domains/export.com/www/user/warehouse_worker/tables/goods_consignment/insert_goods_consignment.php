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
<form method='post' name="insert_goods_consignment">
    <p>Артикул товара:
        <input type='text' name='goods_article' value='' required/></p>
    <p>Количество товаров:
        <input type='text' name='goods_amount' value='' /></p>
    <input type='submit' name="insert_goods_consignment" value='Добавить'>
</form>
<?php
$db_host = 'localhost';
$db_user = 'warehouse_worker';
$db_password = 'password';
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

echo "<p>Таблица товары</p>";
$sql = "SELECT goods_article, goods_name, goods_lifetime, goods_price FROM goods";
if ($result = $link->query($sql)) {
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<p>Получено объектов: $rowsCount</p>";
    echo "<table><tr><th>Артикул товара</th><th>Название товара</th><th>Срок годности (в днях)</th><th>Цена товара</th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["goods_article"] . "</td>";
        echo "<td>" . $row["goods_name"] . "</td>";
        echo "<td>" . $row["goods_lifetime"] . "</td>";
        echo "<td>" . $row["goods_price"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else {
    echo "Ошибка: " . $link->error;
}

if (isset($_POST["insert_goods_consignment"])) {
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $goods_amount = $link->real_escape_string($_POST["goods_amount"]);
    $sql = "INSERT INTO goods_consignment (goods_article, goods_amount) VALUES ('$goods_article', '$goods_amount')";
    if($link->query($sql)){
        header("Location: ../../warehouse_worker.php");
    } else{
        echo "Ошибка: " . $link->error;
    }
}
$link->close();
?>
</body>
</html>
