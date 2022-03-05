<?php
    session_start();

    require_once 'dbconnect.php';

    $email = $_POST['email'];
    $password = $_POST['password'];


    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'");
    $result = mysqli_num_rows($check_user);
    if($result > 0) {
        $_SESSION['message'] = [
            "type" => "success",
            "text" => "Вы успешно авторизованы",
        ];
        $_SESSION['isLogin'] = true;

        $user = mysqli_fetch_assoc($check_user);

        $birthday = $user['age'];
        $age = floor( ( time() - strtotime($birthday) ) / (60 * 60 * 24 * 365.25) );

        $_SESSION['user'] = [
            "id" => $user['id'],
            "email" => $user['email'],
            "name" => $user['name'],
            "surname" => $user['surname'],
            "city" => $user['city'],
            "age" => $age,
            "admin_lvl" => $user['admin_lvl']
        ];
        header('Location: ../index.php');
    } else {
        $_SESSION['message'] = [
            "type" => "error",
            "text" => "Неверный email или пароль",
        ];
        header('Location: ../index.php');
    }
?>