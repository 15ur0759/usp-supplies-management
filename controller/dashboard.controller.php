<?php


function allRequests($conn){
   return $conn->query("SELECT (SELECT COUNT(*) FROM request WHERE item_type = 1) AS consumables,(SELECT COUNT(*) FROM request WHERE item_type = 2) AS nonConsumables");

}


function allDepartments($conn){
   return $conn->query("SELECT * FROM department WHERE department_id != 6 AND department_id != 5 ORDER BY department_name");

}

function allItems($conn){
   return $conn->query("SELECT * FROM items ORDER BY item_description");

}

function releaseCounter($conn,$item,$department){
   $result =  $conn->query("SELECT (SELECT COUNT(item_quantity) FROM list INNER JOIN user ON user.id = list.owner WHERE list.item = '$item' AND user.department = $department) AS total")->fetch_assoc();
   return $result['total'];

}

function departmentReleaseCounter($conn, $department){
   $result =  $conn->query("SELECT (SELECT COUNT(*) FROM request INNER JOIN user ON request.requested_by = user.id WHERE user.department = $department) AS total")->fetch_assoc();
   
   return $result['total'];

}

function mostRequested($conn){
   $reqTotalArray = array();
   $reqArray = array();
   $items = $conn->query("SELECT * FROM items");
 
   while($item = $items->fetch_assoc()){
       $id = $item['item_id'];
       
       $result = $conn->query("SELECT (SELECT COUNT(*) FROM list WHERE item = $id) AS total");
       $total = $result->fetch_assoc();
       
       array_push($reqArray,$item['item_description']) ;
       array_push($reqTotalArray,$total['total']) ;
   }

   return [$reqArray,$reqTotalArray];

}