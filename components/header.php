<?php

    session_start();

    require_once 'vendor/dbconnect.php';

    if($_SESSION['isLogin']) {
        $isLogin = $_SESSION['isLogin'];
    } else {
        $isLogin =  false;
    }
    $user = $_SESSION['user'];
    $user_id = $user['id'];
    $cart_query = mysqli_query($connect, "SELECT * FROM `cart` WHERE `user_id` = '$user_id'");
    $cart = mysqli_num_rows($cart_query);
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">Интернет магазин</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Главная</a>
                </li>
            </ul>
            </div>
            <form class="d-flex me-5 m-0" action="search.php" method="post">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <div class="m-0 ml-5">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <?php
                        if($isLogin) {
                            echo '
                            <div class="d-flex">';
                            if ($user['admin_lvl'] !== null) {
                                echo '
                                <a href="/admin.php" class="btn btn-warning mr-2 position-relativ">
                                    Админ панель
                                </a>';
                            }
                            echo '                        
                            <a href="/cart.php" class="btn btn-info mr-2 position-relativ">
                                Корзина/Заказы
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                '.$cart.'
                                </span>
                            </a>
                            <form action="vendor/logout.php" method="post" class="m-0">
                            <button  type="submit" class="btn btn-danger">
                                Выйти
                            </button>
                            </form>
                            </div>';

                        } else { echo '                        
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sign">
                                Регистарция/Авторизация
                            </button>';

                        }
                    ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal signIn -->
    <div class="modal fade" id="sign" tabindex="-1" role="dialog" aria-labelledby="signTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signTitle">Авторизация</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="vendor/signin.php" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Введите email" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Пароль</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Введите пароль" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <small>Нет аккаутна?</small>
                    <button class="btn btn-primary" data-dismiss="modal" data-target="#signIn" data-toggle="modal">Регистарция</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal signUp -->
    <div class="modal fade" id="signIn" tabindex="-1" role="dialog" aria-labelledby="signTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signTitle">Регистрация</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="vendor/signup.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword">Пароль</label>
                            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Пароль" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Имя" required>
                    </div>
                    <div class="form-group">
                        <label for="surname">Фамилия</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Фамилия" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Город</label>
                            <input type="text" class="form-control" name="city" id="inputCity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputAge">Дата рождения</label>
                            <input type="date" class="form-control" name="age" id="inputAge" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn_submit_register">Регистрация</button>
                </form>
                </div>
                <div class="modal-footer">
                    <small>Уже есть аккаунт?</small>
                    <button class="btn btn-primary" data-dismiss="modal" data-target="#sign" data-toggle="modal">Войти</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Alerts -->
    <?php 
        if($_SESSION['message']) {
            $message = $_SESSION['message'];
            if($message["type"] === "success") {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                '.$message["text"].'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';

            } else if($message["type"] === "error") {
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                '.$message["text"].'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';

            } else {
                echo '
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                '.$message["text"].'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';
            }
            unset($_SESSION['message']);
        }
    ?>
</header> 
