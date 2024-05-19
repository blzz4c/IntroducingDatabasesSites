<!DOCTYPE html>
<html>
<head>
    <title>Добавление информации</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
$db_host = "localhost";
$db_user = "customer";
$db_password = "pass123";
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

mysqli_set_charset($link, "utf8");

$customer_email = $_GET["customer_email"];
$sql = "SELECT country_id, customer_id FROM customer WHERE customer_email = '$customer_email'";
if($result = $link->query($sql)){
    if($result->num_rows > 0) {
        foreach ($result as $row) {
            $country_id = $row["country_id"];
            $customer_id = $row["customer_id"];
        }
    }
}
echo '<div class="container">
    <div class="card">
        <h3>Партии товаров</h3>
        <form method="post" name="select_goods_consignment">
            <input type="submit" name="select_goods_consignment" value="Вывести партии товаров" />
        </form>
    </div>
    <div class="card">
        <h3>Мои покупки партий</h3>
        <form method="post" name="select_purchase">
            <input type="submit" name="select_purchase" value="Вывести мои покупки" />
        </form>
    </div>
    <div class="card">
        <h3>Мои заказы</h3>
        <form method="post" name="select_ordering">
            <input type="submit" name="select_ordering" value="Вывести мои заказы" />
        </form>
        <form action="tables/ordering/insert_ordering.php?customer_id=' . $customer_id . '" method="post">
            <input type="submit" value="Сделать заказ">
        </form>
    </div>
    <div class="card">
        <h3>Товары</h3>
        <form method="post" name="select_goods">
            <input type="submit" name="select_goods" value="Вывести список товаров" />
        </form>
    </div>
</div>';
echo "<p>Вы подключились к MySQL!</p>";

if(isset($_POST['select_ordering'])) {
    $sql = "SELECT o.ordering_id,
       os.status_name,
       o.goods_article,
       o.goods_amount,
       (g.goods_price + f.fee)*o.goods_amount AS total_cost,
       o.ordering_date
    FROM ordering o
    JOIN goods g ON o.goods_article = g.goods_article
    JOIN fee f ON o.goods_article = f.goods_article
    JOIN ordering_status os ON o.ordering_status_id = os.ordering_status_id
    WHERE customer_id = '$customer_id'
    AND f.country_id = $country_id";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID заказа</th><th>Статус заказа</th><th>Артикул товара</th><th>Количество товаров</th><th>Стоимость заказа</th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["ordering_id"] . "</td>";
            echo "<td>" . $row["status_name"] . "</td>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_amount"] . "</td>";
            echo "<td>" . $row["total_cost"] . "</td>";
            echo "<td>" . $row["ordering_date"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}

if(isset($_POST['select_goods'])) {
    $sql = "SELECT goods.goods_article, goods_name, goods_lifetime, (goods.goods_price+fee.fee) AS final_price FROM goods
    JOIN fee ON goods.goods_article = fee.goods_article
    WHERE fee.country_id='$country_id'";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Артикул товара</th><th>Название товара</th><th>Срок годности (в днях)</th><th>Цена товара при импорте</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_name"] . "</td>";
            echo "<td>" . $row["goods_lifetime"] . "</td>";
            echo "<td>" . $row["final_price"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}

if(isset($_POST['select_purchase'])) {
    $sql = "SELECT gc.goods_consignment_id, 
       gc.goods_article, 
       gc.goods_production_date, 
       gc.goods_amount,
       gc.ordering_id,
       gs.status_name,
       (g.goods_price + f.fee)*gc.goods_amount AS total_cost,
       p.purchase_date
    FROM purchase p
    JOIN goods_consignment gc ON p.goods_consignment_id = gc.goods_consignment_id
    JOIN goods g ON gc.goods_article = g.goods_article
    JOIN fee f ON gc.goods_article = f.goods_article
    JOIN consignment_status gs ON gc.consignment_status_id = gs.consignment_status_id
    WHERE p.customer_id = '$customer_id'
    AND f.country_id = $country_id";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID партии товаров</th><th>Артикул товара</th><th>Дата изготовления</th><th>Количество товара</th><th>ID заказа</th><th>Статус партии</th><th>Итоговая стоимость партии</th><th>Дата покупки</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_consignment_id"] . "</td>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_production_date"] . "</td>";
            echo "<td>" . $row["goods_amount"] . "</td>";
            echo "<td>" . $row["ordering_id"] . "</td>";
            echo "<td>" . $row["status_name"] . "</td>";
            echo "<td>" . $row["total_cost"] . "</td>";
            echo "<td>" . $row["purchase_date"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}

if(isset($_POST['select_goods_consignment'])) {
    $sql = "SELECT gc.goods_consignment_id, 
       gc.goods_article, 
       gc.goods_production_date, 
       gc.goods_amount,
       gc.ordering_id,
       gs.status_name,
       (g.goods_price + f.fee)*goods_amount AS total_cost
    FROM goods_consignment gc
    JOIN goods g ON gc.goods_article = g.goods_article
    JOIN fee f ON gc.goods_article = f.goods_article
    JOIN consignment_status gs ON gc.consignment_status_id = gs.consignment_status_id
    WHERE gc.ordering_id IS NULL
    AND gc.consignment_status_id=2
    AND f.country_id = $country_id";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        if ($rowsCount == 0) {
            echo "<h1>Все партии товаров скуплены или не готовы к отправке";
        }
        echo "<table><tr><th>ID партии товаров</th><th>Артикул товара</th><th>Дата изготовления</th><th>Количество товаров</th><th>ID заказа</th><th>Статус партии</th><th>Итоговая стоимость партии</th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_consignment_id"] . "</td>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_production_date"] . "</td>";
            echo "<td>" . $row["goods_amount"] . "</td>";
            echo "<td>" . $row["ordering_id"] . "</td>";
            echo "<td>" . $row["status_name"] . "</td>";
            echo "<td>" . $row["total_cost"] . "</td>";
            echo "<td><form action='tables/purchase/insert_purchase.php' method='post'>
                            <input type='hidden' name='customer_id' value=$customer_id />
                            <input type='hidden' name='goods_consignment_id' value='" . $row["goods_consignment_id"] . "' />
                            <input type='submit' value='Купить партию'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
?>
</body>
</html>
