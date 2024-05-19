<?php
if(isset($_POST["customer_id"]) && isset($_POST["goods_consignment_id"]))
{
    $db_host = 'localhost';
    $db_user = 'customer';
    $db_password = 'pass123';
    $db_name = 'Export';
    $link = new mysqli($db_host, $db_user, $db_password, $db_name);
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    $goods_consignment_id = $link->real_escape_string($_POST["goods_consignment_id"]);
    $customer_id = $link->real_escape_string($_POST["customer_id"]);

    $sql = "SELECT customer_email FROM customer WHERE customer_id = '$customer_id'";
    if($result = $link->query($sql)){
        if($result->num_rows > 0) {
            foreach ($result as $row) {
                $customer_email = $row["customer_email"];
            }
        }
    }

    $sql = "UPDATE goods_consignment SET goods_consignment.consignment_status_id = '3' WHERE goods_consignment.goods_consignment_id = '$goods_consignment_id'";
    $link->query($sql);

    $sql = "INSERT INTO purchase (goods_consignment_id, customer_id) VALUES ('$goods_consignment_id', '$customer_id')";
    if($link->query($sql)){
        header("Location: ../../customer_main.php?customer_email=$customer_email");
    } else{
        echo "Ошибка: " . $link->error;
    }

    $link->close();
}
?>