<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/par.controller.php');
  require_once('../php/now.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
    header('location: ../../login.php');
}

if(isset($_POST['parId']) && isset($_POST['parQty'])){

    $parId = $_POST['parId'];
    $qty = $_POST['parQty'];

    $success = editPar($conn,$parId,$qty);

    echo json_encode(['success'=>$success,'id'=>$parId,'qty'=>$qty]);
}






 
?>