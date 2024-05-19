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
<form method='post' name="insert_continent">
    <p>Название континента:
        <input type='text' name='continent_name' value='' required/></p>
    <p>Площадь континента:
        <input type='text' name='continent_area' value='' required /></p>
    <input type='submit' name="insert_continent" value='Добавить'>
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

if (isset($_POST["insert_continent"])) {
    $continent_name = $link->real_escape_string($_POST["continent_name"]);
    $continent_area = $link->real_escape_string($_POST["continent_area"]);
    $sql = "INSERT INTO continent (continent_name, continent_area) VALUES ('$continent_name', '$continent_area')";
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
