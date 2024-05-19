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
<form method='post' name="login">
    <p>Введите электронную почту вашей компании:
        <input type='text' name='customer_email' value='' /></p>
    <input type='submit' name="login" value='Подтвердить'>
</form>
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

echo "<p>Вы подключились к MySQL!</p>";

if (isset($_POST["login"])) {
    $customer_email = $link->real_escape_string($_POST["customer_email"]);
    $sql = "SELECT * FROM customer WHERE customer_email = '$customer_email'";
    if ($result = $link->query($sql)) {
        if ($result->num_rows > 0) {
            header("Location: customer_main.php?customer_email=$customer_email");
        }
        else {
            header("Location: tables/customer/insert_customer.php?customer_email=$customer_email");
        }
    }
    $link->query($sql);
    if ($link->query($sql)) {
    } else {
        echo "Ошибка: " . $link->error;
    }
}
?>

</body>
</html>
