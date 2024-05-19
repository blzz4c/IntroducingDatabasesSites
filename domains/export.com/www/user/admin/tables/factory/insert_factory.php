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
<form method='post' name="insert_factory">
    <p>Название завода:
        <input type='text' name='factory_name' value='' required/></p>
    <p>Адрес завода:
        <input type='text' name='factory_address' value='' required /></p>
    <input type='submit' name="insert_factory" value='Добавить'>
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

if (isset($_POST["insert_factory"])) {
    $factory_name = $link->real_escape_string($_POST["factory_name"]);
    $factory_address = $link->real_escape_string($_POST["factory_address"]);
    $sql = "INSERT INTO factory (factory_name, factory_address) VALUES ('$factory_name', '$factory_address')";
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
