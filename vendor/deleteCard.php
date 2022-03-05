<?php
    session_start();
    require_once 'dbconnect.php';

    if($_POST['product_id']) {
        $user = $_SESSION['user'];
        $user_id = $user['id'];
        $product_id = $_POST['product_id'];
        mysqli_query($connect, "DELETE FROM `cart` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'");
        $_SESSION['message'] = [
            "type" => "success",
            "text" => "Товар удален из корзины",
        ];
        header('Location: ../cart.php');
    }
?>