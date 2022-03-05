<?php
    session_start();
    require_once 'vendor/dbconnect.php';
    if ($_SESSION['user']) {
        $isLogin = true;
    } else {
        $isLogin = false;
    }
   require_once("components/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/main.css">
    <title>Интернет магазин</title>
</head>
<body>
    <div class="sort-block d-flex">
        <form action="index.php" method="post" class="m-0 mr-2">
            <input type="hidden" name="sort" value="name">
            <button class="btn btn-primary" type="submit">Имя по возрастанию</button>
        </form>
        <form action="index.php" method="post" class="m-0 mr-2">
            <input type="hidden" name="sort" value="name DESC">
            <button class="btn btn-primary" type="submit">Имя по убыванию</button>
        </form>
        <form action="index.php" method="post" class="m-0 mr-2">
            <input type="hidden" name="sort" value="price">
            <button class="btn btn-primary" type="submit">Цена по возрастанию</button>
        </form>
        <form action="index.php" method="post" class="m-0 mr-2">
            <input type="hidden" name="sort" value="price DESC">
            <button class="btn btn-primary" type="submit">Цена по убыванию</button>
        </form>
    </div>

<div class="products col-12">
    <div class="row">
    <div class="col-2">
        <div class="list-group" id="list-tab" role="tablist">
            <?php
            $category_query = mysqli_query($connect, "SELECT * FROM `category` ORDER BY id");
            while ($row = mysqli_fetch_assoc($category_query)) {
                $categoryTepm[] = $row;
            }
            $category_id = 0;   
            ?>
            <?foreach($categoryTepm as $category): ?>
            <a class="list-group-item list-group-item-action <? if($category_id === 0) echo 'active';?>" id="list-category<?=$category_id?>-list" data-toggle="list" href="#list-category<?=$category_id?>" role="tab" aria-controls="category<?=$category_id?>"><?=$category['name']?></a>
            <? $category_id++; ?>
            <? endforeach; $category_id = 0; ?>
        </div>
    </div>
    <div class="col-9">
        <div class="tab-content" id="nav-tabContent">
            <?foreach($categoryTepm as $category): ?>
            <div class="tab-pane fade col-9 <? if($category_id === 0) echo 'show active';?>" style="position:absolute;" id="list-category<?=$category_id?>" role="tabpanel" aria-labelledby="list-category<?=$category_id?>-list">
                    <?php 
                        $id = $category['id'];
                        if(!empty($_POST['sort'])) {
                            $products_query = mysqli_query($connect, "SELECT * FROM `products` WHERE `category_id`='$id' ORDER BY ". $_POST['sort']);
                        } else {
                            $products_query = mysqli_query($connect, "SELECT * FROM `products` WHERE `category_id`='$id' ORDER BY id");
                        }
                        
                        $i = 0;
                        $g = 0;
                        $a = 0;
                        while ($row = mysqli_fetch_assoc($products_query)) {
                            $productsTepm[] = $row;
                        }
                        if (empty($productsTepm)) {
                            echo 'В этой категории нет товаров';
                        }
                    ?>
                    <?error_reporting('warning')?>
                    <?foreach($productsTepm as $product): ?>
                        <?
                            $img_array = json_decode($product['img'], true);
                            $i++;
                        ?>
                        <div class="card w-25 position-relative">
                            <?if($product['forAdults']) echo '<span class="position-absolute top-0 right-0 pbadge bg-danger" style="z-index:999; border-radius:50px;">18+</span>'?>
                            <div id="carouselExampleIndicators<?=$i?>" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?foreach($img_array as $img):?>       
                                    <li data-target="#carouselExampleIndicators<?=$i?>" data-slide-to="<?=$g?>"></li>
                                    <? $g++; ?>
                                    <? endforeach; $g = 0?>
                                </ol>
                                <div class="carousel-inner">
                                    <?foreach($img_array as $img):?>      
                                        <div class="carousel-item <? if($a === 0) echo 'active';?>">
                                        <img class="d-block w-100 h-200px" src="<?=$img?>" alt="<?=$a?> слайд">
                                    </div>
                                    <? $a++; ?>
                                    <? endforeach; $a = 0?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators<?=$i?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators<?=$i?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <p class="card-text"><?= $product['description'] ?></p>
                            </div>
                            <div class="card-footer">
                                <? if($product['sale'] && $product['sale_date'] > date('Y-m-d')) {
                                        $price = $product['price']/100 * (100 - $product['sale']); 
                                        echo '
                                        <span class="badge badge-pill badge-info" style="text-decoration: line-through;">$ '.$product['price'].'</span>
                                        <span class="badge rounded-pill bg-warning text-dark">$ '.$price.'</span>
                                        ';
                                    } else {
                                        echo '<span class="badge badge-pill badge-info">$ '.$product['price'].'</span>';
                                    }
                                ?>
                                <form style="display: inline" action="vendor/AddCart.php" method="GET">
                                    <?
                                    if($_SESSION['isLogin']) {
                                        echo '
                                        <input type="hidden" name="product_id" value="'.$product['id'].'">
                                        <input type="hidden" name="forAdults" value="'.$product['forAdults'].'">
                                        ';
                                    } else {
                                        echo '<input type="hidden" name="null" value="false">';
                                    }
                                    ?>
                                    <button type="submit" class="btn btn-success">В корзину</button>
                                </form>
                            </div>
                        </div>
                <? endforeach; $productsTepm = [];?>
            </div>
            <? $category_id++; ?>    
            <? endforeach; $category_id = 0; ?>
        </div>
    </div>
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

