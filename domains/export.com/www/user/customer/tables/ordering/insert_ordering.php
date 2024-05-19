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
<form method='post' name="insert_ordering">
    <p>Артикул товара:
        <input type='text' name='goods_article' value='' required/></p>
    <p>Количество товаров:
        <input type='text' name='goods_amount' value='' /></p>
    <input type='submit' name="insert_ordering" value='Заказать'>
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

$customer_id = $link->real_escape_string($_GET["customer_id"]);
$sql = "SELECT customer_email FROM customer WHERE customer_id = '$customer_id'";
if($result = $link->query($sql)){
    if($result->num_rows > 0) {
        foreach ($result as $row) {
            $customer_email = $row["customer_email"];
        }
    }
}

if (isset($_POST["insert_ordering"])) {
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $goods_amount = $link->real_escape_string($_POST["goods_amount"]);
    $sql = "INSERT INTO ordering (ordering_status_id, goods_article, customer_id, goods_amount) VALUES (1, '$goods_article', '$customer_id', '$goods_amount')";
    if($link->query($sql)){
        header("Location: ../../customer_main.php?customer_email=$customer_email");
    } else{
        echo "Ошибка: " . $link->error;
    }
}
$link->close();
?>
</body>
</html>
