<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/par.controller.php');
  require_once('../php/now.php');



if(isset($_POST['parOwner']) && isset($_POST['parStatusType'])){

    $owner = $_POST['parOwner'];
    $status = $_POST['parStatusType'];

    $success = changeParStatus($conn,$owner,$status,$now);

    echo json_encode(['success'=>$success]);
}

 
?>