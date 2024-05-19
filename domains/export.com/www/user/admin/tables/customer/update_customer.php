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
$db_user = 'admin';
$db_password = 'password';
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
// если запрос GET
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["customer_id"]))
{
    $customer_id = $link->real_escape_string($_GET["customer_id"]);
    $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $country_id = $row["country_id"];
                $customer_company_name = $row["customer_company_name"];
                $customer_email = $row["customer_email"];
            }
            echo "<h3>Обновление покупателей</h3>
                <form method='post'>
                    <input type='hidden' name='customer_id' value='$customer_id' />
                    <p>Страна покупателя:
                    <input type='text' name='country_id' value='$country_id' required/></p>
                    <p>Название компании:
                    <input type='text' name='customer_company_name' value='$customer_company_name' required/></p>
                    <p>Электронная почта покупателя:
                    <input type='text' name='customer_email' value='$customer_email' required /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Покупатель не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["customer_id"]) && isset($_POST["country_id"]) && isset($_POST["customer_company_name"]) && isset($_POST["customer_email"])){
    $customer_id = $link->real_escape_string($_POST["customer_id"]);
    $country_id = $link->real_escape_string($_POST["country_id"]);
    $customer_company_name = $link->real_escape_string($_POST["customer_company_name"]);
    $customer_email = $link->real_escape_string($_POST["customer_email"]);
    $sql = "UPDATE customer SET country_id = '$country_id', customer_company_name = '$customer_company_name', customer_email = '$customer_email' WHERE customer_id = '$customer_id'";
    if($result = $link->query($sql)){
        header("Location: ../../admin.php");
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