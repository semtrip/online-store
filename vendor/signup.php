<?php
    session_start();

    require_once 'dbconnect.php';

    

    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $city = $_POST['city'];
    $age = $_POST['age'];
    
    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email'");
    $result = mysqli_num_rows($check_user);

    if ($result > 0) {
        $_SESSION['message'] = [
            "type" => "error",
            "text" => "Такой пользователь уже существует",
        ];
        header('Location: ../index.php');
    } else {
        mysqli_query($connect, "INSERT INTO `users` (`email`, `password`, `name`, `surname`, `city`, `age`) VALUES ('$email', '$password', '$name', '$surname', '$city', '$age')");
        $_SESSION['message'] = [
            "type" => "success",
            "text" => "Вы успешно зарегистрированы",
        ];
        $_SESSION['isLogin'] = true;
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
    }


?>