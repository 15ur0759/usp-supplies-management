<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


 if(isset($_POST['deleteId'])){
    $success = deleteDepartment($conn,$_POST['deleteId']);

    echo json_encode(['success'=>$success]);
 }


 function deleteDepartment($conn,$id){
     $query = $conn->prepare("DELETE FROM department WHERE department_id = ?");
     $query->bind_param('i',$id);

     return $query->execute();
 }
 
?>