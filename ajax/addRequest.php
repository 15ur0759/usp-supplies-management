<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


 if(isset($_POST['itemCount'])){
    
   $count = $_POST['itemCount'];
   $id = $_POST['owner'];
   $type = $_POST['itemType'];
   $role = $_POST['currentRole'];


   $lastId = addRequest($conn,$id,$type,$count,$now,$role);

   if($lastId != 0){
     updateList($conn,$type,$lastId);
     updateAvailableStocks($conn,$lastId);
   }
 }

 
?>