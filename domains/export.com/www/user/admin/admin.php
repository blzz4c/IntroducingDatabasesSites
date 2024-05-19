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
        <h3>Таблица factory</h3>
        <form method="post" name="select_factory">
            <input type="submit" name="select_factory" value="Вывести список заводов" />
        </form>
        <form action='tables/factory/insert_factory.php' method='post'>
            <input type='submit' value='Добавить завод'>
        </form>
    </div>

    <div class="card">
        <h3>Таблица goods</h3>
        <form method="post" name="select_goods">
            <input type="submit" name="select_goods" value="Вывести список товаров" />
        </form>
        <form action='tables/goods/insert_goods.php' method='post'>
            <input type='submit' value='Добавить товар'>
        </form>
    </div>

    <div class="card">
        <h3>Таблица goods_consignment</h3>
        <form method="post" name="select_goods_consignment">
            <input type="submit" name="select_goods_consignment" value="Вывести партии товаров" />
        </form>
        <form action='tables/goods_consignment/insert_goods_consignment.php' method='post'>
            <input type='submit' value='Добавить партию товаров'>
        </form>
    </div>

    <div class="card">
        <h3>Таблица consignment_status</h3>
        <form method="post" name="select_consignment_status">
            <input type="submit" name="select_consignment_status" value="Вывести список статусов партий" />
        </form>
        <form action='tables/consignment_status/insert_consignment_status.php' method='post'>
            <input type='submit' value='Добавить статус партии товаров'>
        </form>
    </div>
</div>
<div class ="container">
    <div class="card">
        <h3>Таблица customer</h3>
        <form method="post" name="select_customer">
            <input type="submit" name="select_customer" value="Вывести список покупателей" />
        </form>
        <form action='tables/customer/insert_customer.php' method='post'>
            <input type='submit' value='Добавить покупателя'>
        </form>
    </div>

    <div class="card">
        <h3>Таблица purchase</h3>
        <form method="post" name="select_purchase">
            <input type="submit" name="select_purchase" value="Вывести список покупок" />
        </form>
    </div>

    <div class="card">
        <h3>Таблица ordering</h3>
        <form method="post" name="select_ordering">
            <input type="submit" name="select_ordering" value="Вывести список заказов" />
        </form>
    </div>

    <div class="card">
        <h3>Таблица ordering_status</h3>
        <form method="post" name="select_ordering_status">
            <input type="submit" name="select_ordering_status" value="Вывести список статусов заказов" />
        </form>
        <form action='tables/ordering_status/insert_ordering_status.php' method='post'>
            <input type='submit' value='Добавить статус заказа'>
        </form>
    </div>
</div>
<div class="container">
    <div class="card">
        <h3>Таблица country</h3>
        <form method="post" name="select_country">
            <input type="submit" name="select_country" value="Вывести список стран" />
        </form>
        <form action='tables/country/insert_country.php' method='post'>
            <input type='submit' value='Добавить страну'>
        </form>
    </div>

    <div class="card">
        <h3>Таблица continent</h3>
        <form method="post" name="select_continent">
            <input type="submit" name="select_continent" value="Вывести список континентов" />
        </form>
        <form action='tables/continent/insert_continent.php' method='post'>
            <input type='submit' value='Добавить континент'>
        </form>
    </div>

    <div class="card">
        <h3>Таблица fee</h3>
        <form method="post" name="select_fee">
            <input type="submit" name="select_fee" value="Вывести список пошлин" />
        </form>
        <form action='tables/fee/insert_fee.php' method='post'>
            <input type='submit' value='Добавить пошлину'>
        </form>
    </div>
</div>
<?php
$db_host = "localhost";
$db_user = "admin";
$db_password = "password";
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

mysqli_set_charset($link, "utf8");

echo "<p>Вы подключились к MySQL!</p>";
//factory
if(isset($_POST['select_factory'])) {
    $sql = "SELECT * FROM factory";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID завода</th><th>Название</th><th>Адрес</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["factory_id"] . "</td>";
            echo "<td>" . $row["factory_name"] . "</td>";
            echo "<td>" . $row["factory_address"] . "</td>";
            echo "<td><a href='tables/factory/update_factory.php?factory_id=" . $row["factory_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/factory/delete_factory.php' method='post'>
                            <input type='hidden' name='factory_id' value='" . $row["factory_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//goods
if(isset($_POST['select_goods'])) {
    $sql = "SELECT * FROM goods";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Артикул товара</th><th>Название товара</th><th>Срок годности (в днях)</th><th>Цена товара</th><th>Завод-производитель</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_name"] . "</td>";
            echo "<td>" . $row["goods_lifetime"] . "</td>";
            echo "<td>" . $row["goods_price"] . "</td>";
            echo "<td>" . $row["factory_id"] . "</td>";
            echo "<td><a href='tables/goods/update_goods.php?goods_article=" . $row["goods_article"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/goods/delete_goods.php' method='post'>
                            <input type='hidden' name='goods_article' value='" . $row["goods_article"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//goods_consignment
if(isset($_POST['select_goods_consignment'])) {
    $sql = "SELECT * FROM goods_consignment";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID партии товаров</th><th>Артикул товара</th><th>Дата изготовления</th><th>Количество товаров</th><th>ID заказа</th><th>Статус партии</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_consignment_id"] . "</td>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_production_date"] . "</td>";
            echo "<td>" . $row["goods_amount"] . "</td>";
            echo "<td>" . $row["ordering_id"] . "</td>";
            echo "<td>" . $row["consignment_status_id"] . "</td>";
            echo "<td><a href='tables/goods_consignment/update_goods_consignment.php?goods_consignment_id=" . $row["goods_consignment_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/goods_consignment/delete_goods_consignment.php' method='post'>
                            <input type='hidden' name='goods_consignment_id' value='" . $row["goods_consignment_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//consignment_status
if(isset($_POST['select_consignment_status'])) {
    $sql = "SELECT * FROM consignment_status";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID статуса партии</th><th>Название статуса партии</th><th>Описание статуса партии</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["consignment_status_id"] . "</td>";
            echo "<td>" . $row["status_name"] . "</td>";
            echo "<td>" . $row["status_description"] . "</td>";
            echo "<td><a href='tables/consignment_status/update_consignment_status.php?consignment_status_id=" . $row["consignment_status_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/consignment_status/delete_consignment_status.php' method='post'>
                            <input type='hidden' name='consignment_status_id' value='" . $row["consignment_status_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//customer
if(isset($_POST['select_customer'])) {
    $sql = "SELECT * FROM customer";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID покупателя</th><th>Страна покупателя</th><th>Название компании</th><th>Электронная почта покупателя</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["customer_id"] . "</td>";
            echo "<td>" . $row["country_id"] . "</td>";
            echo "<td>" . $row["customer_company_name"] . "</td>";
            echo "<td>" . $row["customer_email"] . "</td>";
            echo "<td><a href='tables/customer/update_customer.php?customer_id=" . $row["customer_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/customer/delete_customer.php' method='post'>
                            <input type='hidden' name='customer_id' value='" . $row["customer_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//purchase
if(isset($_POST['select_purchase'])) {
    $sql = "SELECT * FROM purchase";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID партии товаров</th><th>ID покупателя</th><th>Дата покупки</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_consignment_id"] . "</td>";
            echo "<td>" . $row["customer_id"] . "</td>";
            echo "<td>" . $row["purchase_date"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//ordering
if(isset($_POST['select_ordering'])) {
    $sql = "SELECT * FROM ordering";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID заказа</th><th>Статус заказа</th><th>Артикул товара</th><th>Покупатель</th><th>Количество товара</th><th>Дата заказа</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["ordering_id"] . "</td>";
            echo "<td>" . $row["ordering_status_id"] . "</td>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["customer_id"] . "</td>";
            echo "<td>" . $row["goods_amount"] . "</td>";
            echo "<td>" . $row["ordering_date"] . "</td>";
            echo "<td><a href='tables/ordering/update_ordering.php?ordering_id=" . $row["ordering_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/ordering/delete_ordering.php' method='post'>
                            <input type='hidden' name='ordering_id' value='" . $row["ordering_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//continent
if(isset($_POST['select_continent'])) {
    $sql = "SELECT * FROM continent";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID континента</th><th>Название континента</th><th>Площадь континента</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["continent_id"] . "</td>";
            echo "<td>" . $row["continent_name"] . "</td>";
            echo "<td>" . $row["continent_area"] . "</td>";
            echo "<td><a href='tables/continent/update_continent.php?continent_id=" . $row["continent_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/continent/delete_continent.php' method='post'>
                            <input type='hidden' name='continent_id' value='" . $row["continent_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//country
if(isset($_POST['select_country'])) {
    $sql = "SELECT * FROM country";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID страны</th><th>Название страны</th><th>Площадь страны</th><th>Континент</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["country_id"] . "</td>";
            echo "<td>" . $row["country_name"] . "</td>";
            echo "<td>" . $row["country_area"] . "</td>";
            echo "<td>" . $row["continent_id"] . "</td>";
            echo "<td><a href='tables/country/update_country.php?country_id=" . $row["country_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/country/delete_country.php' method='post'>
                            <input type='hidden' name='country_id' value='" . $row["country_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//ordering_status
if(isset($_POST['select_ordering_status'])) {
    $sql = "SELECT * FROM ordering_status";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID статуса заказа</th><th>Название статуса заказа</th><th>Описание статуса заказа</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["ordering_status_id"] . "</td>";
            echo "<td>" . $row["status_name"] . "</td>";
            echo "<td>" . $row["status_description"] . "</td>";
            echo "<td><a href='tables/ordering_status/update_ordering_status.php?ordering_status_id=" . $row["ordering_status_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/ordering_status/delete_ordering_status.php' method='post'>
                            <input type='hidden' name='ordering_status_id' value='" . $row["ordering_status_id"] . "' />
                            <input type='submit' value='DELETE'>
                    </form></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
//fee
if(isset($_POST['select_fee'])) {
    $sql = "SELECT * FROM fee";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID пошлины</th><th>ID страны</th><th>Артикул товара</th><th>Пошлина</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["fee_id"] . "</td>";
            echo "<td>" . $row["country_id"] . "</td>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["fee"] . "</td>";
            echo "<td><a href='tables/fee/update_fee.php?fee_id=" . $row["fee_id"] . "'>UPDATE</a></td>";
            echo "<td><form action='tables/fee/delete_fee.php' method='post'>
                            <input type='hidden' name='fee_id' value='" . $row["fee_id"] . "' />
                            <input type='submit' value='DELETE'>
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
