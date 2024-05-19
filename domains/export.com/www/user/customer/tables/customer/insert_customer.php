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
<form method='post' name="insert_customer">
    <p>Введите ID вашей страны:
        <input type="text" name='country_id' value='' required/></p>
    <p>Введите название вашей компании:
        <input type='text' name='customer_company_name' value='' required/></p>
    <input type='submit' name="insert_customer" value='Добавить'>
</form>
<?php
$db_host = 'localhost';
$db_user = 'customer';
$db_password = 'pass123';
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$sql = "SELECT * FROM country";
if ($result = $link->query($sql)) {
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<p>Получено объектов: $rowsCount</p>";
    echo "<table><tr><th>ID страны</th><th>Название страны</th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["country_id"] . "</td>";
        echo "<td>" . $row["country_name"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $result->free();
} else {
    echo "Ошибка: " . $link->error;
}

if (isset($_POST["insert_customer"])) {
    $country_id = $link->real_escape_string($_POST["country_id"]);
    $customer_company_name = $link->real_escape_string($_POST["customer_company_name"]);
    $customer_email = $link->real_escape_string($_GET["customer_email"]);
    $sql = "INSERT INTO customer (country_id, customer_company_name, customer_email) VALUES ('$country_id', '$customer_company_name', '$customer_email')";
    if($link->query($sql)){
        header("Location: ../../customer_main.php");
    } else{
        echo "Ошибка: " . $link->error;
    }
}
$link->close();
?>
</body>
</html>
