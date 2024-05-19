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

echo "<p>Таблица статусы партий</p>";
$sql = "SELECT * FROM consignment_status";
if ($result = $link->query($sql)) {
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<p>Получено объектов: $rowsCount</p>";
    echo "<table><tr><th>ID статуса партии</th><th>Название статуса партии</th><th>Описание статуса партии</th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["consignment_status_id"] . "</td>";
        echo "<td>" . $row["status_name"] . "</td>";
        echo "<td>" . $row["status_description"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else {
    echo "Ошибка: " . $link->error;
}

// если запрос GET
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["goods_consignment_id"]))
{
    $goods_consignment_id = $link->real_escape_string($_GET["goods_consignment_id"]);
    $sql = "SELECT * FROM goods_consignment WHERE goods_consignment_id = '$goods_consignment_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $goods_article = $row["goods_article"];
                $goods_amount = $row["goods_amount"];
                $consignment_status_id = $row["consignment_status_id"];
            }
            echo "<h3>Обновление партий</h3>
                <form method='post'>
                    <input type='hidden' name='goods_consignment_id' value='$goods_consignment_id' />
                    <p>Артикул товара: (не трогать если перешли с заказов)
                    <input type='text' name='goods_article' value='$goods_article' required/></p>
                    <p>Количество товара:
                    <input type='text' name='goods_amount' value='$goods_amount' required /></p>
                    <p>Статус товара:
                    <input type='text' name='consignment_status_id' value='$consignment_status_id' required /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Партия не найдена</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["goods_consignment_id"]) && isset($_POST["goods_article"]) && isset($_POST["goods_amount"]) && isset($_POST["consignment_status_id"])){
    $goods_consignment_id = $link->real_escape_string($_POST["goods_consignment_id"]);
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $goods_amount = $link->real_escape_string($_POST["goods_amount"]);
    $consignment_status_id = $link->real_escape_string($_POST["consignment_status_id"]);
    $sql = "UPDATE goods_consignment SET goods_article = '$goods_article', goods_amount = '$goods_amount', consignment_status_id = '$consignment_status_id' WHERE goods_consignment_id = '$goods_consignment_id'";
    if($result = $link->query($sql)){
        header("Location: ../../warehouse_worker.php");
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