<html>
<head>
    <title>Добавление информации</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user/style.css">
</head>
<body>
<form method="post" name = "login">
    <p>Логин:
        <input type='text' name='user_login' placeholder="Введите свой логин" value='' required /></p>
    <p>Пароль:
        <input type='password' name='user_password' placeholder="Введите свой пароль" value='' autocomplete="on" required /></p>
    <input type='submit' name="login" value='Войти'>
</form>
<?php
//Убирает warning
error_reporting(E_ERROR);

$db_host = "localhost";
$db_user = $_POST['user_login'];
$db_password = $_POST['user_password'];
$db_name = 'Export';

if (empty($db_user) || empty($db_password)) {
    echo "Заполните все поля";
} else {
    try {
        $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
        header("Location: user/$db_user/$db_user.php");
    } catch (mysqli_sql_exception $e) {
        echo "<p style='color:red;'>Неверный логин или пароль!</p>";
    }
}
?>
</body>
</html>

