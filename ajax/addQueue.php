<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


//add List
if(isset($_POST['owner']) && isset($_POST['item']) && isset($_POST['itemType']) && isset($_POST['itemQuantity'])){
    $owner = $_POST['owner'];
    $item = $_POST['item'];
  
    $queueQty =  getQueueQty($conn,$owner,$item);

    $stock =  stockCount($conn,$item);
    $newQty = $queueQty + $_POST['itemQuantity'];

    if($newQty <= $stock){
        if($queueQty > 0){
            $query = $conn->prepare("UPDATE list SET item_quantity = ? WHERE `owner`= ? AND item= ?");
            $query->bind_param('iii',$newQty,$owner,$item);
            $query->execute();
        }else{
            $query = $conn->prepare("INSERT INTO list (`owner`,item,item_quantity,item_type) VALUES(?,?,?,?)");
            $query->bind_param('iiii',$_POST['owner'],$_POST['item'],$_POST['itemQuantity'],$_POST['itemType']);
        
            $query->execute();
        }
        echo json_encode(['added'=>true]);
    }else{
         echo json_encode(['added'=>false]);
    }

 
}

function getQueueQty($conn,$owner,$item){

    $query = $conn->query("SELECT item_quantity FROM list WHERE `owner`=$owner AND item= $item AND request_id IS NULL");
    $result = $query->fetch_assoc();
    
    if($result != null){
        return $result['item_quantity'];
    }
    return 0;
}

function stockCount($conn,$item){
   
    $query = $conn->query("SELECT quantity FROM items WHERE item_id = $item");
    $result = $query->fetch_assoc();

    return $result['quantity'];
}



?>