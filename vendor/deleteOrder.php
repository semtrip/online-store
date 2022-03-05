<?php
    session_start();
    require_once 'dbconnect.php';

    if($_POST['order_id']) {
        $user = $_SESSION['user'];
        $user_id = $user['id'];
        $order_id = $_POST['order_id'];
        mysqli_query($connect, "DELETE FROM `order_user` WHERE `user_id` = '$user_id' AND `order_id` = '$order_id'");
        $_SESSION['message'] = [
            "type" => "success",
            "text" => "Заказ удален",
        ];
        header('Location: ../cart.php');
    }
?>