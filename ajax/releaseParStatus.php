<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');



if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

 if(isset($_POST['ownerId'])){

    $owner = $_POST['ownerId'];

    $test = $conn->prepare("UPDATE par SET par_status = 5, par_released_date = ? WHERE par_owner=?");
    $test->bind_param('si',$now,$owner);
    $test->execute();
   
    $result = $conn->query("SELECT * FROM par INNER JOIN items ON items.item_id = par.par_item WHERE par.par_owner = $owner AND par.par_status = 5");

    while($res = $result->fetch_assoc()){
        
        $quantity = $res['par_quantity'];
        $id = $res['par_item'];
        $text = "(".$quantity.") quantity has been released - ".$res['item_description'];
       
        
        $conn->query("UPDATE items SET quantity = quantity - $quantity WHERE item_id = $id ");
        $test2 = $conn->prepare("INSERT INTO `log` (log_owner,log_description,log_date) VALUES (2,?,?)");
        $test2->bind_param('ss',$text,$now);
        var_dump($test2->execute());

    }

    echo json_encode(['success'=> true]);
 }

 
?>