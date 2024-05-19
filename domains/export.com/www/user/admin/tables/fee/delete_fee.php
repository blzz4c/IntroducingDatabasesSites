<?php
if(isset($_POST["fee_id"]))
{
    $db_host = 'localhost';
    $db_user = 'admin';
    $db_password = 'password';
    $db_name = 'Export';

    $link = new mysqli($db_host, $db_user, $db_password, $db_name);
    if($link->connect_error){
        die("Ошибка: " . $link->connect_error);
    }
    $fee_id = $link->real_escape_string($_POST["fee_id"]);
    $sql = "DELETE FROM fee WHERE fee_id = '$fee_id'";
    if($link->query($sql)){
        header("Location: ../../admin.php");
    }
    else{
        echo "Ошибка: " . $link->error;
    }
    $link->close();
}
?>