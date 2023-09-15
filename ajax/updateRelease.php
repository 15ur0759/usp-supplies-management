<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');



if(isset($_POST['requestId'])){
   $id = $_POST['requestId'];
    
   updateRelease($conn,$id,$now);
   echo $id;
}
 
?>