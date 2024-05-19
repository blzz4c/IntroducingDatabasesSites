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
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["ordering_id"]))
{
    $ordering_id = $link->real_escape_string($_GET["ordering_id"]);
    $sql = "SELECT * FROM ordering WHERE ordering_id = '$ordering_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $ordering_status_id = $row["ordering_status_id"];
            }
            echo "<h3>Обновление статуса</h3>
                <form method='post'>
                    <input type='hidden' name='ordering_id' value='$ordering_id' />
                    <p>Статус
                    <input type='text' name='ordering_status_id' value='$ordering_status_id' required/></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Заказ не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
    $sql = "SELECT * FROM ordering_status";
    if ($result = $link->query($sql)) {
        $rowsCount = $result->num_rows; // количество полученных строк
        echo "<p>Получено объектов: $rowsCount</p>";
        echo "<table><tr><th>ID статуса заказа</th><th>Название статуса заказа</th><th>Описание статуса заказа</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["ordering_status_id"] . "</td>";
            echo "<td>" . $row["status_name"] . "</td>";
            echo "<td>" . $row["status_description"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        $result->free();
    } else {
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["ordering_id"]) && isset($_POST["ordering_status_id"])){
    $ordering_id = $link->real_escape_string($_POST["ordering_id"]);
    $ordering_status_id = $link->real_escape_string($_POST["ordering_status_id"]);
    $sql = "UPDATE ordering SET ordering_status_id = '$ordering_status_id' WHERE ordering_id = '$ordering_id'";
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