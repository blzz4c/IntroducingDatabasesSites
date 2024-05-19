<!DOCTYPE html>
<html>
<head>
    <title>База данных: Экспорт</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class ="container">
    <div class="card">
        <h3>Покупатели</h3>
        <form method="post" name="select_customer">
            <input type="submit" name="select_customer" value="Вывести список покупателей" />
        </form>
    </div>

    <div class="card">
        <h3>Таблица покупки партий</h3>
        <form method="post" name="select_purchase">
            <input type="submit" name="select_purchase" value="Вывести список покупок" />
        </form>
    </div>

    <div class="card">
        <h3>Заказы</h3>
        <form method="post" name="select_ordering">
            <input type="submit" name="select_ordering" value="Вывести список заказов" />
        </form>
    </div>

    <div class="card">
        <h3>Партии товаров</h3>
        <form method="post" name="select_goods_consignment">
            <input type="submit" name="select_goods_consignment" value="Вывести партии товаров" />
        </form>
        <form action='tables/goods_consignment/insert_goods_consignment.php' method='post'>
            <input type='submit' value='Добавить партию товаров'>
        </form>
    </div>
</div>
<?php
$db_host = "localhost";
$db_user = "warehouse_worker";
$db_password = "password";
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

mysqli_set_charset($link, "utf8");

echo "<p>Вы подключились к MySQL!</p>";
if(isset($_POST['select_customer'])) {
    $sql = "SELECT customer_id, country_name, customer_company_name, customer_email FROM customer
    INNER JOIN country ON customer.country_id=country.country_id";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID покупателя</th><th>Страна покупателя</th><th>Название компании</th><th>Электронная почта покупателя</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["customer_id"] . "</td>";
            echo "<td>" . $row["country_name"] . "</td>";
            echo "<td>" . $row["customer_company_name"] . "</td>";
            echo "<td>" . $row["customer_email"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}

if(isset($_POST['select_purchase'])) {
    $sql = "SELECT goods_consignment_id, customer_email, purchase_date FROM purchase
    INNER JOIN customer ON purchase.customer_id = customer.customer_id";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID партии товаров</th><th>Электронная почта покупателя</th><th>Дата покупки</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_consignment_id"] . "</td>";
            echo "<td>" . $row["customer_email"] . "</td>";
            echo "<td>" . $row["purchase_date"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
if(isset($_POST['select_ordering'])) {
    $sql = "SELECT ordering_id, ordering_status.status_name, goods_article, customer_email, goods_amount, ordering_date FROM ordering
    INNER JOIN ordering_status ON ordering.ordering_status_id=ordering_status.ordering_status_id
    INNER JOIN customer ON ordering.customer_id = customer.customer_id
    ORDER BY ordering.ordering_status_id ASC";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID заказа</th><th>Статус заказа</th><th>Артикул товара</th><th>Электронная почта покупателя</th><th>Количество товара</th><th>Дата заказа</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["ordering_id"] . "</td>";
            echo "<td>" . $row["status_name"] . "</td>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["customer_email"] . "</td>";
            echo "<td>" . $row["goods_amount"] . "</td>";
            echo "<td>" . $row["ordering_date"] . "</td>";
            echo "<td><a href='tables/ordering/update_ordering.php?ordering_id=" . $row["ordering_id"] . "'>Обновить статус</a></td>";
            echo "<td><a href='tables/ordering/insert_ordering.php?ordering_id=" . $row["ordering_id"] . "'>Партии товаров</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
if(isset($_POST['select_goods_consignment'])) {
    $sql = "SELECT goods_consignment_id, goods_article, goods_production_date, goods_amount, ordering_id, consignment_status.status_name FROM goods_consignment 
    INNER JOIN consignment_status ON goods_consignment.consignment_status_id=consignment_status.consignment_status_id
    ORDER BY goods_consignment.consignment_status_id ASC";
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
            echo "<td><a href='tables/goods_consignment/update_goods_consignment.php?goods_consignment_id=" . $row["goods_consignment_id"] . "'>UPDATE</a></td>";
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
