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

$ordering_id = $link->real_escape_string($_GET["ordering_id"]);

$sql = "SELECT goods_consignment_id, goods_article, goods_production_date, goods_amount, ordering_id, consignment_status.status_name FROM goods_consignment
        INNER JOIN consignment_status ON goods_consignment.consignment_status_id = consignment_status.consignment_status_id
        WHERE ordering_id = '$ordering_id'";
if ($result = $link->query($sql)) {
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<p>Получено объектов: $rowsCount</p>";
    echo "<table><tr><th>ID партии товаров</th><th>Артикул товара</th><th>Дата изготовления</th><th>Количество товаров</th><th>ID заказа</th><th>Статус партии</th><th></th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["goods_consignment_id"] . "</td>";
        echo "<td>" . $row["goods_article"] . "</td>";
        echo "<td>" . $row["goods_production_date"] . "</td>";
        echo "<td>" . $row["goods_amount"] . "</td>";
        echo "<td>" . $row["ordering_id"] . "</td>";
        echo "<td>" . $row["status_name"] . "</td>";
        echo "<td><a href='../../tables/goods_consignment/update_goods_consignment.php?goods_consignment_id=" . $row["goods_consignment_id"] . "'>UPDATE</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else {
    echo "Ошибка: " . $link->error;
}

if (isset($_POST["insert_goods_consignment"])) {
    $sql = "SELECT * FROM ordering WHERE ordering_id = '$ordering_id'";
    if($result = $link->query($sql)) {
        if ($result->num_rows > 0) {
            foreach ($result as $row) {
                $goods_article = $row["goods_article"];
            }
        }
    }
    $goods_amount = $link->real_escape_string($_POST["goods_amount"]);
    $sql = "INSERT INTO goods_consignment (goods_article, goods_amount, ordering_id) VALUES ('$goods_article', '$goods_amount', '$ordering_id')";
    $link->query($sql);
    $sql = "UPDATE ordering SET ordering_status_id=2 WHERE ordering_id = '$ordering_id';";
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
