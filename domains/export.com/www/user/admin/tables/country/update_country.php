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
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["country_id"]))
{
    $country_id = $link->real_escape_string($_GET["country_id"]);
    $sql = "SELECT * FROM country WHERE country_id = '$country_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $country_name = $row["country_name"];
                $country_area = $row["country_area"];
                $continent_id = $row["continent_id"];
            }
            echo "<h3>Обновление стран</h3>
                <form method='post'>
                    <input type='hidden' name='country_id' value='$country_id' />
                    <p>Название страны:
                    <input type='text' name='country_name' value='$country_name' required/></p>
                    <p>Площадь страны:
                    <input type='text' name='country_area' value='$country_area' required /></p>
                    <p>Континент:
                    <input type='text' name='continent_id' value='$continent_id' required /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Страна не найдена</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["country_id"]) && isset($_POST["country_name"]) && isset($_POST["country_area"]) && isset($_POST["continent_id"])){
    $country_id = $link->real_escape_string($_POST["country_id"]);
    $country_name = $link->real_escape_string($_POST["country_name"]);
    $country_area = $link->real_escape_string($_POST["country_area"]);
    $continent_id = $link->real_escape_string($_POST["continent_id"]);
    $sql = "UPDATE country SET country_name = '$country_name', country_area = '$country_area', continent_id = '$continent_id' WHERE country_id = '$country_id'";
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