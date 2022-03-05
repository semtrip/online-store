<?php
    session_start();
    require_once 'vendor/dbconnect.php';

    if(empty($_POST['search'])) {
        header('Location: ../index.php');
    } else {
        $inputSearch = $_POST['search']; 
        $mysql = mysqli_query($connect, "SELECT * FROM `products` WHERE `name` LIKE '%" . $inputSearch .  "%' OR `description` LIKE '%" . $inputSearch ."%'");
    }
    require_once("components/header.php");

    $i = 0;
    $g = 0;
    $a = 0;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/main.css">
    <title>Поиск</title>
</head>
<body>
    <div class="search-block">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade col-12 show active" style="position:absolute;" id="list-category<?=$category_id?>" role="tabpanel" aria-labelledby="list-category<?=$category_id?>-list">
            
                <?while($product = mysqli_fetch_assoc($mysql)){?>
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
                <?}?>
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