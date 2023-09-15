<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/request.controller.php');
 require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');


if(isset($_POST['requesterId'])){

   $_SESSION['requesterId'] = $_POST['requesterId'];
}
?>