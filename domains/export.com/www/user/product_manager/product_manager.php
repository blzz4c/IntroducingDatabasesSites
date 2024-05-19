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
<div class="container">

    <div class="card">
        <h3>Заводы</h3>
        <form method="post" name="select_factory">
            <input type="submit" name="select_factory" value="Вывести список заводов" />
        </form>
    </div>

    <div class="card">
        <h3>Товары</h3>
        <form method="post" name="select_goods">
            <input type="submit" name="select_goods" value="Вывести список товаров" />
        </form>
        <form action='tables/goods/insert_goods.php' method='post'>
            <input type='submit' value='Добавить товар'>
        </form>
    </div>

    <div class="card">
        <h3>Страны</h3>
        <form method="post" name="select_country">
            <input type="submit" name="select_country" value="Вывести список стран" />
        </form>
    </div>

    <div class="card">
        <h3>Континенты</h3>
        <form method="post" name="select_continent">
            <input type="submit" name="select_continent" value="Вывести список континентов" />
        </form>
    </div>
</div>
<div class="container">
    <div class="card">
        <h3>Пошлины</h3>
        <form method="post" name="select_fee">
            <input type="submit" name="select_fee" value="Вывести список пошлин" />
        </form>
        <form action='tables/fee/insert_fee.php' method='post'>
            <input type='submit' value='Добавить пошлину'>
        </form>
    </div>
    <div class="card">
        <h3>Расчет выгоды</h3>
        <form method="post" name="select_profit">
            <input type="text" name="custom_price" value="" />
            <p>Cписок товаров и стран, когда прибыль предприятия при экспорте будет > N
            <input type="submit" name="select_profit" value="Вывести" /></p>
        </form>
    </div>
</div>
<?php
$db_host = "localhost";
$db_user = "product_manager";
$db_password = "password";
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

mysqli_set_charset($link, "utf8");

echo "<p>Вы подключились к MySQL!</p>";

if(isset($_POST['select_profit'])) {
    $custom_price=$link->real_escape_string($_POST['custom_price']);
    $sql = "SELECT goods.goods_article, goods_name, goods_lifetime, country.country_name, (goods.goods_price+fee.fee) AS final_price FROM goods
    JOIN fee ON goods.goods_article = fee.goods_article
    JOIN country ON fee.country_id = country.country_id
    WHERE (goods.goods_price-fee.fee) > $custom_price";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Артикул товара</th><th>Название товара</th><th>Срок годности товара</th><th>Название страны</th><th>Стоимость вместе с пошлиной</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_name"] . "</td>";
            echo "<td>" . $row["goods_lifetime"] . "</td>";
            echo "<td>" . $row["country_name"] . "</td>";
            echo "<td>" . $row["final_price"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}

if(isset($_POST['select_factory'])) {
    $sql = "SELECT * FROM factory";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID завода</th><th>Название</th><th>Адрес</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["factory_id"] . "</td>";
            echo "<td>" . $row["factory_name"] . "</td>";
            echo "<td>" . $row["factory_address"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}

if(isset($_POST['select_goods'])) {
    $sql = "SELECT goods_article, goods_name, goods_lifetime, goods_price, factory_name FROM goods
    INNER JOIN factory ON goods.factory_id=factory.factory_id";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Артикул товара</th><th>Название товара</th><th>Срок годности (в днях)</th><th>Цена товара</th><th>Завод-производитель</th><th>Пошлины</th><th></th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["goods_article"] . "</td>";
            echo "<td>" . $row["goods_name"] . "</td>";
            echo "<td>" . $row["goods_lifetime"] . "</td>";
            echo "<td>" . $row["goods_price"] . "</td>";
            echo "<td>" . $row["factory_name"] . "</td>";
            echo "<td><form method='post' name='select_fee'>
                        <input type='hidden' name='select_fee_goods_article' value='" . $row["goods_article"] . "' />
                        <input type='submit' value='Смотреть пошлины' />
                      </form></td>";
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
if(isset($_POST['select_fee_goods_article'])) {
    $goods_article = $link->real_escape_string($_POST["select_fee_goods_article"]);
    $sql = "SELECT fee_id, country_name, goods_name, fee FROM fee
            INNER JOIN country ON fee.country_id=country.country_id
            INNER JOIN goods ON fee.goods_article=goods.goods_article
            WHERE goods.goods_article='$goods_article';";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>Страна</th><th>Товар</th><th>Пошлина</th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["country_name"] . "</td>";
            echo "<td>" . $row["goods_name"] . "</td>";
            echo "<td>" . $row["fee"] . "</td>";
            echo "<td><a href='tables/fee/update_fee.php?fee_id=" . $row["fee_id"] . "'>UPDATE</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
if(isset($_POST['select_country'])) {
    $sql = "SELECT country_id, country_name, country_area, continent_name FROM country INNER JOIN continent ON country.continent_id=continent.continent_id";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID страны</th><th>Название страны</th><th>Площадь страны</th><th>Континент</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["country_id"] . "</td>";
            echo "<td>" . $row["country_name"] . "</td>";
            echo "<td>" . $row["country_area"] . "</td>";
            echo "<td>" . $row["continent_name"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}

if(isset($_POST['select_continent'])) {
    $sql = "SELECT * FROM continent";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID континента</th><th>Название континента</th><th>Площадь континента</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["continent_id"] . "</td>";
            echo "<td>" . $row["continent_name"] . "</td>";
            echo "<td>" . $row["continent_area"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
if(isset($_POST['select_fee'])) {
    $sql = "SELECT fee_id, country_name, goods_name, fee FROM fee
            INNER JOIN country ON fee.country_id=country.country_id
            INNER JOIN goods ON fee.goods_article=goods.goods_article;";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID пошлины</th><th>Страна</th><th>Товар</th><th>Пошлина</th><th></th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["fee_id"] . "</td>";
            echo "<td>" . $row["country_name"] . "</td>";
            echo "<td>" . $row["goods_name"] . "</td>";
            echo "<td>" . $row["fee"] . "</td>";
            echo "<td><a href='tables/fee/update_fee.php?fee_id=" . $row["fee_id"] . "'>UPDATE</a></td>";
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
