<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


 if(isset($_POST['deleteId'])){
    deleteList($conn,$_POST['deleteId']);
 }

 
?>