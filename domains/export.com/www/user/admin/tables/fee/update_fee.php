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
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["fee_id"]))
{
    $fee_id = $link->real_escape_string($_GET["fee_id"]);
    $sql = "SELECT * FROM fee WHERE fee_id = '$fee_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $country_id = $row["country_id"];
                $goods_article = $row["goods_article"];
                $fee = $row["fee"];
            }
            echo "<h3>Обновление пошлин</h3>
                <form method='post'>
                    <input type='hidden' name='fee_id' value='$fee_id' />
                    <p>Страна:
                    <input type='text' name='country_id' value='$country_id' required/></p>
                    <p>Товар:
                    <input type='text' name='goods_article' value='$goods_article' required /></p>
                    <p>Пошлина:
                    <input type='text' name='fee' value='$fee' required /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Пошлина не найдена</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["fee_id"]) && isset($_POST["country_id"]) && isset($_POST["goods_article"]) && isset($_POST["fee"])){
    $fee_id = $link->real_escape_string($_POST["fee_id"]);
    $country_id = $link->real_escape_string($_POST["country_id"]);
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $fee = $link->real_escape_string($_POST["fee"]);
    $sql = "UPDATE fee SET country_id = '$country_id', goods_article = '$goods_article', fee = '$fee' WHERE fee_id = '$fee_id'";
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