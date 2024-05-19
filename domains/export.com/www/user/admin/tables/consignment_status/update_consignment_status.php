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
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["consignment_status_id"]))
{
    $consignment_status_id = $link->real_escape_string($_GET["consignment_status_id"]);
    $sql = "SELECT * FROM consignment_status WHERE consignment_status_id = '$consignment_status_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $status_name = $row["status_name"];
                $status_description = $row["status_description"];
            }
            echo "<h3>Обновление статусов</h3>
                <form method='post'>
                    <input type='hidden' name='consignment_status_id' value='$consignment_status_id' />
                    <p>Название статуса партии:
                    <input type='text' name='status_name' value='$status_name' required/></p>
                    <p>Описание статуса партии:
                    <input type='text' name='status_description' value='$status_description' required /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Статус не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["consignment_status_id"]) && isset($_POST["status_name"]) && isset($_POST["status_description"])){
    $consignment_status_id = $link->real_escape_string($_POST["consignment_status_id"]);
    $status_name = $link->real_escape_string($_POST["status_name"]);
    $status_description = $link->real_escape_string($_POST["status_description"]);
    $sql = "UPDATE consignment_status SET status_name = '$status_name', status_description = '$status_description' WHERE consignment_status_id = '$consignment_status_id'";
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