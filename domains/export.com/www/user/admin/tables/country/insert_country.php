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
<form method='post' name="insert_country">
    <p>Название страны:
        <input type='text' name='country_name' value='' required/></p>
    <p>Площадь страны:
        <input type='text' name='country_area' value='' required /></p>
    <p>Континент:
        <input type='text' name='continent_id' value='' required /></p>
    <input type='submit' name="insert_country" value='Добавить'>
</form>
<?php
$db_host = 'localhost';
$db_user = 'admin';
$db_password = 'password';
$db_name = 'Export';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

if (isset($_POST["insert_country"])) {
    $country_name = $link->real_escape_string($_POST["country_name"]);
    $country_area = $link->real_escape_string($_POST["country_area"]);
    $continent_id = $link->real_escape_string($_POST["continent_id"]);
    $sql = "INSERT INTO country (country_name, country_area, continent_id) VALUES ('$country_name', '$country_area', '$continent_id')";
    if($link->query($sql)){
        header("Location: ../../admin.php");
    } else{
        echo "Ошибка: " . $link->error;
    }
}
$link->close();
?>
</body>
</html>
