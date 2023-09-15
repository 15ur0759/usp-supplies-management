<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/par.controller.php');
  require_once('../php/now.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
    header('location: ../../login.php');
}

if(isset($_POST['parId']) && isset($_POST['parQty']) && isset($_POST['jan']) && isset($_POST['feb']) && isset($_POST['mar']) && isset($_POST['apr']) && isset($_POST['may']) && isset($_POST['june']) && isset($_POST['july']) && isset($_POST['aug']) && isset($_POST['sep']) && isset($_POST['oct']) && isset($_POST['nov']) && isset($_POST['dec'])){

    $userInfo = $_SESSION['userInfo'];
    $item = $_POST['parId'];
    $owner = $userInfo['id'];
    $qty = $_POST['parQty'];

    $jan = $_POST['jan'];
    $feb = $_POST['feb'];
    $mar = $_POST['mar'];
    $apr = $_POST['apr'];
    $may = $_POST['may'];
    $june = $_POST['june'];
    $jul = $_POST['july'];
    $aug = $_POST['aug'];
    $sep = $_POST['sep'];
    $oct = $_POST['oct'];
    $nov = $_POST['nov'];
    $dec = $_POST['dec'];
    


    $success = addPar($conn,$owner,$item,$qty,$now,$jan,$feb,$mar,$apr,$may,$june,$jul,$aug,$sep,$oct,$nov,$dec);

    echo json_encode(['success'=>$success]);
}






 
?>