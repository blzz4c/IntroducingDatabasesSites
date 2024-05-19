<?php
if(isset($_POST["goods_article"]))
{
    $db_host = 'localhost';
    $db_user = 'product_manager';
    $db_password = 'password';
    $db_name = 'Export';

    $link = new mysqli($db_host, $db_user, $db_password, $db_name);
    if($link->connect_error){
        die("Ошибка: " . $link->connect_error);
    }
    $goods_article = $link->real_escape_string($_POST["goods_article"]);
    $sql = "DELETE FROM goods WHERE goods_article = '$goods_article'";
    if($link->query($sql)){
        header("Location: ../../product_manager.php");
    }
    else{
        echo "Ошибка: " . $link->error;
    }
    $link->close();
}
?>