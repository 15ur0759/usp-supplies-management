<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');



if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}


$userInfo = $_SESSION['userInfo'];
$owner = $userInfo['id'];

if(isset($_POST['updateId']) && isset($_POST['updateQty'])){
  

    $id = $_POST['updateId'];

    $result = $conn->query("SELECT * FROM items WHERE item_id = $id");
    $count = $result->fetch_assoc();

    $quantity = $count['quantity'];
    $total = $quantity + $_POST['updateQty'];
    $description = $count['item_description'];
    
    $query = $conn->prepare('UPDATE items SET quantity = ? WHERE item_id= ?');
    $query->bind_param('ii',$total,$id);

    if($query->execute()){

        $logDesc = '('.$_POST['updateQty'].") quantity has been Added to item ".$description;

        $res = $conn->prepare("INSERT INTO `log` (log_owner,log_description,log_date) VALUES (?,?,?)");
        $res->bind_param('iss',$owner,$logDesc,$now);
        $res->execute();
        
        echo json_encode(['success'=>true]);
    }

    $updateQty = $_POST['updateQty'];

    $conn->query("UPDATE analysis SET an_total = an_total + '$updateQty' WHERE prod_id = '$id'");
   

    
}

 
?>