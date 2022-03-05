<?
    session_start();

    require_once 'vendor/dbconnect.php';

    $user = $_SESSION['user'];
    if($user['admin_lvl'] === null) {
        header('Location: ../index.php');
    } else {
        if((int)$user['admin_lvl'] === 2) {
            $admin_status = 'Администратор';
        } else if((int)$user['admin_lvl'] === 1) {
            $admin_status = 'Сборщик заказов';
        } else {
            header('Location: ../index.php');
        }
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
    <title>Админ панель</title>
</head>
<body>
    <?='Ваш админ лвл: '.$admin_status.''?>
    <?if($admin_status === 'Администратор'){?>
    <div class="add-product">
        <h2>Добавить товар</h2>
        <form class="row col-6 row-cols-lg-auto g-3 align-items-center" action="vendor/addProduct.php" method="post" enctype="multipart/form-data">
            <div class="col-12">
            <label for="productName">Имя товара</label>
                <input type="text" class="form-control" name="productName" id="productName" placeholder="Имя товара" aria-label="Имя" required>
            </div>
            <div class="col-12">
                <div class="form-group">
                  <label for="description">Описание</label>
                  <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                </div>
            </div>
            <div class="col-auto">
                <label class="visually-hidden" for="autoSizingSelect">Категория</label>
                <select class="form-select" id="autoSizingSelect" name="category" required>
                <?php
                $category_query = mysqli_query($connect, "SELECT * FROM `category` ORDER BY id");
                while ($row = mysqli_fetch_assoc($category_query)) {
                    $categoryTepm[] = $row;
                }
                $category_id = 1;   
                ?>
                <?foreach($categoryTepm as $category): ?>
                    <option <? if($category_id === 0) { echo 'selected';} else {echo 'value="'.$category_id.'"';}?>><?=$category['name']?></option>
                <? $category_id++; ?>
                <? endforeach; $category_id = 0; ?>
                </select>
            </div>
            <div class="col-12">
                <label for="formFileMultiple" class="form-label">Фото товара 250x250px</label>
                <input class="form-control" type="file" id="formFileMultiple" name="pictures[]" multiple>
            </div>
            <div class="col-12">
                <label for="price">Цена</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="Цена" aria-label="Цена" required>
            </div>
            <div class="col-12 form-row">
                <div class="form-group col-6">
                    <label for="sale">Скидка</label>
                    <input type="number" class="form-control" name="sale" id="sale" placeholder="20">
                </div>
                <div class="form-group col-6">
                    <label for="sale_date">Дата окончания скидки</label>
                    <input type="date" class="form-control" name="sale_date" id="sale_date">
                </div>
            </div>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="forAdults">
                <label class="form-check-label" for="flexCheckDefault">
                   Товар 18+
                </label>
            </div>
            <button type="submit" class="ml-5 btn btn-success">Добавить товар</button>
        </form>
    </div>
    <?}?>
    <div class="order-list">
        <h2>Список заказов</h2>
        <?
        $order_query = mysqli_query($connect, "SELECT * FROM `order_user` ORDER BY `date_time` DESC");
        if(mysqli_num_rows($order_query) > 0) {
        ?>
        <ul class="list-group">
            <?
                while ($row = mysqli_fetch_assoc($order_query)) {

                    $products = json_decode($row['filling']);
                    for ($i=0; $i < count($products); $i++) { 
                        $products_id[] = $products[$i] -> product_id;
                    }
                    $id = implode(",", $products_id);
                    $sql="SELECT * FROM `products` WHERE `id` IN ($id)";
                    $query = mysqli_query($connect, $sql);
                    while ($row2 = mysqli_fetch_assoc($query)){
                        for ($i=0; $i < count($products); $i++) { 
                            if($products[$i] -> product_id === $row2['id']) {
                                $products_temp[] = $row2['name'].' x '. $products[$i] -> quantity;
                            }
                        }
                    }
                    $products_str = implode(",", $products_temp);
                    $products_temp = [];
                    echo '<li class="list-group-item">
                            <span>№'.$row['order_id'].'</span></br>
                            <span>Товары: '.$products_str.' </span></br>
                            <span>Адресс: '.$row['adress'].'</span></br
                            <span>Стоимость: '.$row['total_price'].'</span></br>
                            <span>Дата: '.$row['date_time'].'</span></br>
                    ';
                    $status_array =  [
                        1 => 'Заказ получен',
                        2 => 'Упакован',
                        3 => 'Отгружен',
                        4 => 'Получен'
                    ];
                    ?>
                    <form class="m-0" action="vendor/updateOrder.php" method="post">
                        Статус:
                        <select class="form-select" aria-label="Default select example" id="select-<?=$row['order_id']?>" onchange="OnSelectionChange(this)">
                            <?foreach($status_array as $status):?>       
                                <option <? if($status  === $row['status']) echo 'selected';?> value="<?=$status?>"><?=$status?></option>
                            <? endforeach ?> 
                        </select>
                        <input type="hidden" name="order_id" value="<?=$row['order_id']?>">
                        <input type="hidden" name="order_status" id="status_order-select-<?=$row['order_id']?>">
                        <button type="submit" class="btn btn-success" style="display:none;" id="btn-save-select-<?=$row['order_id']?>">Сохранить</button>
                    </form>
                    <?
                        echo '</li>';
                        echo '</br>';
                    
                }
            } 
            ?>
        </ul>
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
<script>
    function OnSelectionChange (select) {
        let selectedOption = select.options[select.selectedIndex];
        let btn = document.getElementById('btn-save-' + select.id)
        document.getElementById('status_order-'+ select.id).value = selectedOption.value
        btn.style.display = 'inline'
    }
</script> 
</body>
</html>