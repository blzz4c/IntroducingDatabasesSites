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
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["factory_id"]))
{
    $factory_id = $link->real_escape_string($_GET["factory_id"]);
    $sql = "SELECT * FROM factory WHERE factory_id = '$factory_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $factory_name = $row["factory_name"];
                $factory_address = $row["factory_address"];
            }
            echo "<h3>Обновление заводов</h3>
                <form method='post'>
                    <input type='hidden' name='factory_id' value='$factory_id' />
                    <p>Название завода:
                    <input type='text' name='factory_name' value='$factory_name' required/></p>
                    <p>Адрес завода:
                    <input type='text' name='factory_address' value='$factory_address' required /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Завод не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["factory_id"]) && isset($_POST["factory_name"]) && isset($_POST["factory_address"])){
    $factory_id = $link->real_escape_string($_POST["factory_id"]);
    $factory_name = $link->real_escape_string($_POST["factory_name"]);
    $factory_address = $link->real_escape_string($_POST["factory_address"]);
    $sql = "UPDATE factory SET factory_name = '$factory_name', factory_address = '$factory_address' WHERE factory_id = '$factory_id'";
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