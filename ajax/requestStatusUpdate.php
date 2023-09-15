<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


 //chair update status
$updated = false;

if(isset($_POST['currentRequest']) && isset($_POST['statusType']) ){

   $remLength = strlen( $_POST['remarks']);

    if($_POST['statusType'] == 2){
      $query = $conn->prepare("UPDATE request SET dean_status= 1, chair_status = ? ,chair_response_date= ? WHERE request_id = ?");
    }else{
       $query = $conn->prepare("UPDATE request SET dean_status= NULL, chair_status = ?,chair_response_date= ?  WHERE request_id = ?");

    }

    $query->bind_param('isi',$_POST['statusType'],$now,$_POST['currentRequest']);
    $updated = $query->execute();

    echo json_encode(['updated'=>$updated]);
}

