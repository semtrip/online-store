<?
        session_start();
        require_once 'dbconnect.php';
        
        $user = $_SESSION['user'];

        if($user['admin_lvl'] === null) {
            header('Location: ../index.php');
        } else if(!(int)$user['admin_lvl'] === 2 || !(int)$user['admin_lvl'] === 1) {
            header('Location: ../index.php');
        }
        
        $order_id = $_POST['order_id'];
        $status_order = $_POST['order_status'];

        // $mysql = mysqli_query($connect, "UPDATE `order_user` SET `status`= $status_order WHERE `order_id` = '$order_id'");
        $mysql = mysqli_query($connect, "UPDATE `order_user` SET `status`= '$status_order' WHERE `order_id` = '$order_id'");

        if($mysql) {
            $_SESSION['message'] = [
                "type" => "success",
                "text" => "Статус заказа №".$order_id." обновлен",
            ];
            header('Location: ../admin.php');
        } else {
            $_SESSION['message'] = [
                "type" => "error",
                "text" => "Произошла ошибка",
            ];
            echo 'Ошибка запроса: ' . mysqli_error($connect) . '<br>';
            echo 'Код ошибки: ' . mysqli_errno($connect);
        }
        
        require_once("components/header.php");
        

?>