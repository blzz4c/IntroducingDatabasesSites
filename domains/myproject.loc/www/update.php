<!DOCTYPE html>
<html>
<head>
    <title>Обновление информации</title>
    <meta charset="utf-8" />
</head>
<body>
<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'Podyanov';

$link = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
// если запрос GET
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]))
{
    $employee_id = $link->real_escape_string($_GET["id"]);
    $sql = "SELECT * FROM Table_Podyanov WHERE ID = '$employee_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0){
            foreach($result as $row){
                $employee_surname = $row["Surname"];
                $employee_name = $row["Name"];
                $employee_midname = $row["MidName"];
                $employee_phone = $row["Phone"];
                $employee_salary = $row["Salary"];
                $employee_experience = $row["Experience"];
                $employee_adress = $row["Adress"];
                $employee_department = $row["department_id"];
            }
            echo "<h3>Обновление пользователя</h3>
                <form method='post'>
                    <input type='hidden' name='id' value='$employee_id' />
                    <p>Surname:
                    <input type='text' name='Surname' value='$employee_surname' /></p>
                    <p>Name:
                    <input type='text' name='Name' value='$employee_name' /></p>
                    <p>MidName:
                    <input type='text' name='MidName' value='$employee_midname' /></p>
                    <p>Phone:
                    <input type='text' name='Phone' value='$employee_phone' /></p>
                    <p>Salary:
                    <input type='number' name='Salary' value='$employee_salary' /></p>
                    <p>Experience:
                    <input type='date' name='Experience' value='$employee_experience' /></p>
                    <p>Address:
                    <input type='text' name='Adress' value='$employee_adress' /></p>
                    <p>Department_ID:
                    <input type='text' name='department_id' value='$employee_department' /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Сотрудник не найден</div>";
        }
        $result->free();
    } else{
        echo "Ошибка: " . $link->error;
    }
}
elseif (isset($_POST["id"]) && isset($_POST["Surname"]) && isset($_POST["Name"]) && isset($_POST["MidName"]) && isset($_POST["Phone"]) && isset($_POST["Salary"]) && isset($_POST["Experience"]) && isset($_POST["Adress"]) && isset($_POST["department_id"])) {

    $employee_id = $link->real_escape_string($_POST["id"]);
    $employee_surname = $link->real_escape_string($_POST["Surname"]);
    $employee_name = $link->real_escape_string($_POST["Name"]);
    $employee_midname = $link->real_escape_string($_POST["MidName"]);
    $employee_phone = $link->real_escape_string($_POST["Phone"]);
    $employee_salary = $link->real_escape_string($_POST["Salary"]);
    $employee_experience = $link->real_escape_string($_POST["Experience"]);
    $employee_adress = $link->real_escape_string($_POST["Adress"]);
    $employee_department = $link->real_escape_string($_POST["department_id"]);
    $sql = "UPDATE Table_Podyanov SET Surname = '$employee_surname', Name = '$employee_name', MidName = '$employee_midname', Phone = '$employee_phone', Salary = '$employee_salary', Experience = '$employee_experience', Adress = '$employee_adress', department_id = $employee_department WHERE ID = '$employee_id'";
    if($result = $link->query($sql)){
        header("Location: index.php");
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