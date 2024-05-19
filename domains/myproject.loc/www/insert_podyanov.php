<!DOCTYPE html>
<html>
<head>
    <title>Добавление информации</title>
    <meta charset="utf-8" />
</head>
<body>
<form method='post'>
    <p>Surname:
        <input type='text' name='Surname' value='' /></p>
    <p>Name:
        <input type='text' name='Name' value='' /></p>
    <p>MidName:
        <input type='text' name='MidName' value='' /></p>
    <p>Phone:
        <input type='text' name='Phone' value='' /></p>
    <p>Salary:
        <input type='number' name='Salary' value='' /></p>
    <p>Experience:
        <input type='date' name='Experience' value='' /></p>
    <p>Address:
        <input type='text' name='Adress' value='' /></p>
    <input type='submit' name="insert_podyanov" value='Добавить'>
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

//INSERT Table_Podyanov
if (isset($_POST["insert_podyanov"])) {
    $employee_surname = $link->real_escape_string($_POST["Surname"]);
    $employee_name = $link->real_escape_string($_POST["Name"]);
    $employee_midname = $link->real_escape_string($_POST["MidName"]);
    $employee_phone = $link->real_escape_string($_POST["Phone"]);
    $employee_salary = $link->real_escape_string($_POST["Salary"]);
    $employee_experience = $link->real_escape_string($_POST["Experience"]);
    $employee_adress = $link->real_escape_string($_POST["Adress"]);
    $sql = "INSERT INTO Table_Podyanov (Surname, Name, MidName, Phone, Salary, Experience, Adress) VALUES ('$employee_surname','$employee_name','$employee_midname','$employee_phone',$employee_salary,'$employee_experience','$employee_adress')";
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

