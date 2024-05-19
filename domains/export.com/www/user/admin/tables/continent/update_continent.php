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
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["continent_id"]))
{
    $continent_id = $link->real_escape_string($_GET["continent_id"]);
    $sql = "SELECT * FROM continent WHERE continent_id = '$continent_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $continent_name = $row["continent_name"];
                $continent_area = $row["continent_area"];
            }
            echo "<h3>Обновление континентов</h3>
                <form method='post'>
                    <input type='hidden' name='continent_id' value='$continent_id' />
                    <p>Название континента:
                    <input type='text' name='continent_name' value='$continent_name' required/></p>
                    <p>Площадь континента:
                    <input type='text' name='continent_area' value='$continent_area' required /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Континент не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["continent_id"]) && isset($_POST["continent_name"]) && isset($_POST["continent_area"])){
    $continent_id = $link->real_escape_string($_POST["continent_id"]);
    $continent_name = $link->real_escape_string($_POST["continent_name"]);
    $continent_area = $link->real_escape_string($_POST["continent_area"]);
    $sql = "UPDATE continent SET continent_name = '$continent_name', continent_area = '$continent_area' WHERE continent_id = '$continent_id'";
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