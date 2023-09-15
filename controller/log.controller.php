<?php

function addNewLog($conn,$now,$text,$owner){
  
   $query = $conn->prepare("INSERT INTO log (log_owner,log_description,log_date) VALUES(?,?,?)");
   $query->bind_param('iss',$owner,$text,$now);

   return $query->execute() or die();
}