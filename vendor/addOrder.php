<?php
    session_start();

    require_once 'dbconnect.php';

    $user = $_SESSION['user'];
    $user_id = $user['id'];

    $adress = $_POST['inputAddress'];
    $adress2 = $_POST['inputAddress2'];
    $city = $_POST['inputCity'];
    $zip = $_POST['inputZip'];
    $order = $_SESSION['order'];
    $total_price = $_POST['total_price'];
    $date = new DateTime();
    $date = $date ->format('Y-m-d H:i');

    $full_adress = 'Город: '. $city . ' Адрес: ' . $adress . ' Адрес 2: ' .$adress2 . ' Почтовый индекс: ' . $zip;

    mysqli_query($connect, "DELETE FROM `cart` WHERE `user_id` = '$user_id'");
    mysqli_query($connect, "INSERT INTO `order_user` (`user_id`, `filling`, `adress`, `total_price`, `date_time`,`status`) VALUES ('$user_id', '$order', '$full_adress', '$total_price', '$date', 'Заказ получен')");

    $_SESSION['message'] = [
        "type" => "success",
        "text" => "Заказ успешно оформлен",
    ];
    unset($_SESSION['order']);
    header('Location: ../cart.php');
?>