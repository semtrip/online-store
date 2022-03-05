<?php
    session_start();
    require_once 'dbconnect.php';

    $user = $_SESSION['user'];
    if($_GET['null']) {
        $_SESSION['message'] = [
            "type" => "error",
            "text" => "Для добавления товара в козину авторизуйтесь",
        ];
        header('Location: ../index.php');
    } else if($_GET['forAdults'] && !(int)$user['age'] <= 18) {
        $_SESSION['message'] = [
            "type" => "error",
            "text" => "Вам меньше 18 лет",
        ];
        header('Location: ../index.php');
    }else {
        $user_id = $user['id'];
        $product_id = $_GET['product_id'];

        $check_product = mysqli_query($connect, "SELECT * FROM `cart` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'");
        $result = mysqli_num_rows($check_product);
        if($result > 0) {
            $cart_temp = mysqli_fetch_assoc($check_product);
            $quantity = $cart_temp['quantity'] + 1;
            mysqli_query($connect, "UPDATE `cart` SET `quantity`= '$quantity' WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'");
        } else {
            mysqli_query($connect, "INSERT INTO `cart` (`user_id`, `product_id`, `quantity`) VALUES ('$user_id', '$product_id', '1')");
        }
        $_SESSION['message'] = [
            "type" => "success",
            "text" => "Товар добавлен в корзину",
        ];
        header('Location: ../index.php');
    }
?>