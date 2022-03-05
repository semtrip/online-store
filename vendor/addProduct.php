<?
    session_start();
    $productName = $_POST['productName'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $sale = $_POST['sale'];
    $sale_date = $_POST['sale_date'];
    $pictures = $_FILES['pictures'];

    $sale = !empty($sale) ? "'$sale'" : "NULL";
    $sale_date = !empty($sale_date) ? "'$sale_date'" : "NULL";

    require_once 'dbconnect.php';

    $user = $_SESSION['user'];
    if($user['admin_lvl'] === null) {
        header('Location: ../index.php');
    } else {
        if((int)$user['admin_lvl'] === 2) {
            function reArrayFiles(&$file_post) {

                $file_ary = array();
                $file_count = count($file_post['name']);
                $file_keys = array_keys($file_post);
            
                for ($i=0; $i<$file_count; $i++) {
                    foreach ($file_keys as $key) {
                        $file_ary[$i][$key] = $file_post[$key][$i];
                    }
                }
            
                return $file_ary;
            }
            $file_ary = reArrayFiles($pictures);
        
            if(!empty($file_ary))
            {    
                foreach($file_ary as $val)
                {
                    $newname = date('YmdHis',time()).mt_rand().'.jpg';
                    move_uploaded_file($val['tmp_name'],'../img/products/'.$newname);
                    $file_name[] = '/img/products/'.$newname;
                }
            }
            $JSON_file_name = json_encode($file_name);
            if($_POST['forAdults']) {
                $forAdults = 1;
            } else {
                $forAdults = 0;
            }
            $sql = "INSERT INTO `products` (`name`, `description`, `category_id`, `price`, `sale`,`sale_date`, `img`, `forAdults`) VALUES ('$productName', '$description', '$category', '$price', $sale, $sale_date, '$JSON_file_name', '$forAdults')";
            mysqli_query($connect, $sql);
            $_SESSION['message'] = [
                "type" => "success",
                "text" => "Товар успешно добавлен",
            ];
            header('Location: ../admin.php');
        } else if($user['admin_lvl'] === 1) {
            header('Location: ../index.php');
        } else {
            header('Location: ../index.php');
        }
    }
?>