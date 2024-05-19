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
<form method='post' name="insert_consignment_status">
    <p>Название статуса партии:
        <input type='text' name='status_name' value='' required/></p>
    <p>Описание статуса партии:
        <input type='text' name='status_description' value='' required /></p>
    <input type='submit' name="insert_consignment_status" value='Добавить'>
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

if (isset($_POST["insert_consignment_status"])) {
    $status_name = $link->real_escape_string($_POST["status_name"]);
    $status_description = $link->real_escape_string($_POST["status_description"]);
    $sql = "INSERT INTO consignment_status (status_name, status_description) VALUES ('$status_name', '$status_description')";
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
