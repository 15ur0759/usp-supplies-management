<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/par.controller.php');
  require_once('../php/now.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
    header('location: ../../login.php');
}

if(isset($_POST['submitParId'])){

    
    $owner = $_POST['submitParId'];

    $success = submitPar($conn,$owner,$now);

    echo json_encode(['success'=>$success]);
}






 
?>