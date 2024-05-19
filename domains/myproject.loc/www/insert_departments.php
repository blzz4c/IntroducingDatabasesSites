<!DOCTYPE html>
<html>
<head>
    <title>Добавление информации</title>
    <meta charset="utf-8" />
</head>
<body>
<form method='post' name="insert_departments">
    <p>Name:
        <input type='text' name='department_name' value='' /></p>
    <input type='submit' name="insert_departments" value='Добавить'>
</form>
<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'Podyanov';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
//INSERT Departments
if (isset($_POST["insert_departments"])) {
    $department_name = $link->real_escape_string($_POST["department_name"]);
    $sql = "INSERT INTO Departments (Name) VALUES ('$department_name')";
    if($link->query($sql)){
        header("Location: index.php");
    } else{
        echo "Ошибка: " . $link->error;
    }
}
$link->close();
?>
</body>
</html>
