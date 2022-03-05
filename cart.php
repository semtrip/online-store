<?php
    session_start();

    require_once 'vendor/dbconnect.php';

    if(!$_SESSION['isLogin']) {
        header('Location: ../index.php');
    } else {
        $user = $_SESSION['user'];
        $user_id = $user['id'];
        $user_city = $user['city'];
        
        $user = $_SESSION['user'];
        $user_id = $user['id'];
        $cart_query = mysqli_query($connect, "SELECT * FROM `cart` WHERE `user_id` = '$user_id'");
        if(mysqli_num_rows($cart_query) > 0) {
            while ($row = mysqli_fetch_assoc($cart_query)) {
                $products_id[] = $row['product_id'];
                $products[] = $row;
            }
            $id = implode(",", $products_id);
            $sql="SELECT * FROM `products` WHERE `id` IN ($id)";
            $query = mysqli_query($connect, $sql);
        }
        $total_price = 0;
    }
    $order_query = mysqli_query($connect, "SELECT * FROM `order_user` WHERE `user_id` = '$user_id'");

    require_once("components/header.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/main.css">
    <title>Корзина</title>
</head>
<body>
    <?
    if(mysqli_num_rows($cart_query) > 0) {;
        ?>
    
    <div class="cart col-12 d-flex">
        <div class="col-4">
            <ul class="list-group">
                <?
                    while ($row = mysqli_fetch_assoc($query)){
                        for ($i=0; $i < count($products); $i++) { 
                            if($products[$i]['product_id'] === $row['id']) {
                                $count = $products[$i]['quantity'];
                                if($count > 1) {
                                    $total_price = $total_price + ($row['price'] * $count);
                                }
                                
                            }
                        }
                        if($row['sale'] && $row['sale_date'] > date('Y-m-d')) {
                            $price = $row['price']/100 * (100 - $row['sale']);
                         } else {
                             $price = $row['price'];
                         }
                        $total_price = $total_price + $price;
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                        '.$row['name'].' x '.$count.'
                        <div class="block d-flex align-items-center">
                            <span class="badge rounded-pill bg-info text-dark d-flex align-items-center mr-2">$'.$price.'</span>
                            <form action="vendor/deleteCard.php" method="post" class="m-0">
                                <input type="hidden" name="product_id" value="'.$row['id'].'">
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </div>
                        </li>';
                    }
                ?>
            </ul>
            <span>Итоговая стоимость: $<?=$total_price?></span>
        </div>
        <div class="order_block col-6">
            <form class="row g-3" action="vendor/addOrder.php" method="post">
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Адрес</label>
                    <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="Проспект Ленина" required>
                </div>
                <div class="col-12">
                    <label for="inputAddress2" class="form-label">Адрес 2</label>
                    <input type="text" class="form-control" id="inputAddress2" name="inputAddress2" placeholder="Квартира" required>
                </div>
                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Город</label>
                    <input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="Брянск" value="<?=$user_city?>" required>
                </div>
                <div class="col-md-2">
                    <label for="inputZip" class="form-label">Индекс</label>
                    <input type="text" class="form-control" id="inputZip" name="inputZip" required>
                </div>
                <div class="col-12 mt-2">
                    <?
                    $out = array_values($products);
                    $_SESSION['order'] = json_encode($out);
                    echo '<input type="hidden" name="total_price" value="'.$total_price.'">';
                    ?>
                    <button type="submit" class="btn btn-success">Оформить заказ</button>
                </div>
            </form>
        </div>
    </div>
    <?
    }
    ?>
    <div class="order">
        <h1>История заказов</h1>
        <div class="col-4">
            <ul class="list-group">
                <?  
                    if(mysqli_num_rows($order_query) > 0) {
                        while ($row = mysqli_fetch_assoc($order_query)){
                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                            Номер заказа: '.$row['order_id'].'
                            <div class="block d-flex align-items-center">
                                <span class="badge rounded-pill bg-info text-dark d-flex align-items-center mr-2">$'.$row['total_price'].'</span>
                                <span class="badge rounded-pill bg-warning text-dark d-flex align-items-center mr-2">'.$row['status'].'</span>
                                ';
                                if($row['status'] === 'Заказ получен') {
                                    echo '
                                    <form action="vendor/deleteOrder.php" method="post" class="m-0">
                                        <input type="hidden" name="order_id" value="'.$row['order_id'].'">
                                        <button type="submit" class="btn btn-danger">Удалить</button>
                                    </form>
                                    ';
                                }
                                echo '
                            </div>
                            </li>';
                        }
                    } else {
                        echo '<h5>У вас нет заказов</h5>';
                    }
                ?>
            </ul>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    if($(".alert")) {
        setTimeout(() => {
            $(".alert").alert('close')
        }, 5000);
    }
</script>
</body>
</html>