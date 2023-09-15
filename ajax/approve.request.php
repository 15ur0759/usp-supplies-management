<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/request.controller.php');
  require_once('../php/now.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
    header('location: ../../login.php');
}

if(isset($_POST['requestId']) && isset($_POST['requestRole'])){

    $success = false;

    $requestId = $_POST['requestId'];
    $role = $_POST['requestRole'];

    switch($role){
        case 2 : $success = approveSuppliesAdmin($conn,$requestId,$now);
         break;
        case 3 : $success = approveChair($conn,$requestId,$now);
         break;
        case 4 : $success = approveDean($conn,$requestId,$now);
         break;
        case 5 : $success = approveCed($conn,$requestId,$now);
         break;
        case 8 : $success = approveNonTeachingHead($conn,$requestId,$now);
    }
   
    echo json_encode(['success'=>$success]);
}

function checkCurrentRequest($conn,$id){
 
   $result = $conn->query("SELECT * FROM request WHERE request_id = '$id'");
   $details = $result->fetch_assoc();

   return $details['deducted'];

}

function deductItems($conn,$id){
   
   $results = $conn->query("SELECT * FROM list WHERE request_id = '$id'");
   

   while($result = $results->fetch_assoc()){
      $item = $result['item'];
      $qty = $result['item_quantity'];

      $res = $conn->query("UPDATE items SET quantity = quantity - '$qty' WHERE item_id = '$item' ");
       
   }

}

function checkIfComplete($conn,$id){
  
   $complete = true;
   $results = $conn->query("SELECT * FROM list INNER JOIN items ON list.item = items.item_id WHERE list.request_id = '$id'");
   
   while($result = $results->fetch_assoc()){
       if($result['quantity'] < $result['item_quantity']){
            $complete = false;
       }

   }
   return $complete;

}


function approveChair ($conn,$id,$now){

    if(checkCurrentRequest($conn,$id) != NULL){
        if(checkIfComplete($conn,$id)){
            deductItems($conn,$id);
            $query = $conn->prepare("UPDATE request SET remarks = NULL,deducted = NULL, dean_status= 1, chair_status = 2 ,chair_response_date= ? WHERE request_id = ?");
        
            $query->bind_param('si',$now,$id);
            
            return $query->execute();
        }else{
            return false;
        }
    }else{
        $query = $conn->prepare("UPDATE request SET remarks = NULL,deducted = NULL, dean_status= 1, chair_status = 2 ,chair_response_date= ? WHERE request_id = ?");
    
        $query->bind_param('si',$now,$id);
        
        return $query->execute();
    }
}

function approveDean ($conn,$id,$now){

     if(checkCurrentRequest($conn,$id) != NULL){
        if(checkIfComplete($conn,$id)){
            deductItems($conn,$id);

           $query = $conn->prepare("UPDATE request SET remarks = NULL, deducted = NULL,ced_status= 1, dean_status = 2 ,dean_response_date= ? WHERE request_id = ?");

            $query->bind_param('si',$now,$id);
            
            return $query->execute();
        }else{
            return false;
        }
    }else{
       $query = $conn->prepare("UPDATE request SET remarks = NULL, deducted = NULL,ced_status= 1, dean_status = 2 ,dean_response_date= ? WHERE request_id = ?");

        $query->bind_param('si',$now,$id);
    
        return $query->execute();
    }

    
}

function approveCed ($conn,$id,$now){
     if(checkCurrentRequest($conn,$id) != NULL){
        if(checkIfComplete($conn,$id)){
            deductItems($conn,$id);

            $query = $conn->prepare("UPDATE request SET remarks = NULL, deducted = NULL, supplies_admin_status= 1, ced_status = 2 ,ced_response_date= ? WHERE request_id = ?");

            $query->bind_param('si',$now,$id);
            
            return $query->execute();
        }else{
            return false;
        }
    }else{
       $query = $conn->prepare("UPDATE request SET remarks = NULL, deducted = NULL, supplies_admin_status= 1, ced_status = 2 ,ced_response_date= ? WHERE request_id = ?");

    $query->bind_param('si',$now,$id);
    
    return $query->execute();
    }

   
}

function approveSuppliesAdmin ($conn,$id,$now){

     if(checkCurrentRequest($conn,$id) != NULL){
        if(checkIfComplete($conn,$id)){
            deductItems($conn,$id);

            $query = $conn->prepare("UPDATE request SET remarks = NULL,deducted = NULL, claim_status= 1, supplies_admin_status= 2, supplies_response_date= ? WHERE request_id = ?");

            $query->bind_param('si',$now,$id);
            
            return $query->execute();
        }else{
            return false;
        }
    }else{
      $query = $conn->prepare("UPDATE request SET remarks = NULL,deducted = NULL, claim_status= 1, supplies_admin_status= 2, supplies_response_date= ? WHERE request_id = ?");

    $query->bind_param('si',$now,$id);
    
    return $query->execute();
    }
    
 
}

function approveNonTeachingHead ($conn,$id,$now){

     if(checkCurrentRequest($conn,$id) != NULL){
        if(checkIfComplete($conn,$id)){
            deductItems($conn,$id);

              $query = $conn->prepare("UPDATE request SET remarks = NULL,deducted = NULL, supplies_admin_status= 1, deptHead_status = 2 ,deptHead_response_date= ? WHERE request_id = ?");

            $query->bind_param('si',$now,$id);
            
            return $query->execute();
        }else{
            return false;
        }
    }else{
        $query = $conn->prepare("UPDATE request SET remarks = NULL,deducted = NULL, supplies_admin_status= 1, deptHead_status = 2 ,deptHead_response_date= ? WHERE request_id = ?");

        $query->bind_param('si',$now,$id);
        
        return $query->execute();
    }

}


 
?>