<?php

// $now is declared in now.php

function searchItems($conn,$type,$key,$filter){
   if($filter == 0){
      return $conn->query("SELECT * FROM items INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id WHERE items.available = 1 AND items.item_type = $type AND items.item_description LIKE '%$key%' ORDER BY items.item_description");
   }else{
       return $conn->query("SELECT * FROM items INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id WHERE items.available = 1 AND items.item_type = $type AND items.item_category = $filter AND items.item_description LIKE '%$key%' ORDER BY items.item_description");
   }


}

function getAllConsumableItems($conn){
   return $conn->query("SELECT * FROM items INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id WHERE items.available = 1 AND items.item_type = 1");

}

function consumableCategories($conn){
    return $conn->query("SELECT * FROM categories WHERE itemtype= 1 AND isAvailable=1 ORDER BY categ_description");
}

function nonConsumableCategories($conn){
    return $conn->query("SELECT * FROM categories WHERE itemtype= 2 AND isAvailable=1 ORDER BY categ_description");
}


function getAllNonConsumableItems($conn){
   return $conn->query("SELECT * FROM items INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id WHERE items.available = 1 AND items.item_type = 2");

}


function getItemDetails($conn,$id){
   return $conn->query("SELECT * FROM items INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id WHERE items.item_id = $id");

}


function getAllRequests($conn,$id){
   // echo date('Y-m-d');
   return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id  WHERE request.requested_by = $id GROUP BY request.request_id ORDER BY request.request_id");
}

function getAllChairRequests($conn,$department,$type){
   if($type == 0){
      return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE user.department = $department AND request.chair_status != 'NULL' GROUP BY request.request_id ORDER BY request.request_id");
   }else{
       return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE user.department = $department AND request.chair_status = '$type' GROUP BY request.request_id ORDER BY request.request_id");
   }
}

function getAllHeadRequests($conn,$department,$type){
   if($type == 0){
      return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE user.department = $department AND request.deptHead_status != 'NULL' GROUP BY request.request_id ORDER BY request.request_id");
   }else{
           return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE user.department = $department AND request.deptHead_status= '$type' GROUP BY request.request_id ORDER BY request.request_id");
   }
}

function getAllDeanRequests($conn,$type){
   if($type == 0){
      return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE  request.dean_status IS NOT NULL GROUP BY request.request_id ORDER BY request.request_id");
   }else{
      return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE  request.dean_status='$type' GROUP BY request.request_id ORDER BY request.request_id");
   }
}
// WHERE request.chair_status = '2' AND request.dean_status != 'NULL'

function getAllCedRequests($conn,$type){
   if($type == 0){
      return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.ced_status != 'NULL' GROUP BY request.request_id ORDER BY request.request_id");

   }else{
       return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.ced_status='$type' GROUP BY request.request_id ORDER BY request.request_id");
   }
}

function getAllSuppliesRequests($conn,$type){
      if($type == 0){
         return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN `role` ON user.role = role.role_id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.supplies_admin_status != 'NULL' GROUP BY request.request_id ORDER BY request.request_id");
      }else{
          return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN `role` ON user.role = role.role_id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.supplies_admin_status = $type GROUP BY request.request_id ORDER BY request.request_id");
      }
}
//backup
// function getAllSuppliesRequests($conn,$type){
//    if($type == 0){
//       return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN `role` ON user.role = role.role_id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.supplies_admin_status != 'NULL' GROUP BY request.request_id ORDER BY request.request_id");
//    }else{
//        return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN `role` ON user.role = role.role_id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.supplies_admin_status = $type GROUP BY request.request_id ORDER BY request.request_id");
//    }
// }


// for release
function getAllForRelease($conn){
   return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN `role` ON user.role = role.role_id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN claim_status ON claim_status.claim_status_id = request.claim_status INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.supplies_admin_status = 2 GROUP BY request.request_id ORDER BY request.request_id");
}

function getAllForReleaseInstructor($conn,$id){
   return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN `role` ON user.role = role.role_id INNER JOIN itemtype ON request.item_type = itemtype.id INNER JOIN list ON list.request_id = request.request_id INNER JOIN claim_status ON claim_status.claim_status_id = request.claim_status INNER JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE request.supplies_admin_status = 2 AND request.requested_by = $id GROUP BY request.request_id ORDER BY request.request_id");
}

//add consumable request
$added = false;
if(isset($_POST['userId']) && isset($_POST['role']) && isset($_POST['itemQuantity'])){


    $query = $conn->prepare("INSERT INTO request (requested_by,item_type,item,req_quantity,supplies_admin_status,request_date,is_cancelled) VALUES(?,1,?,?,1,?,0)");
     $query->bind_param('iiis',$_POST['userId'],$_POST['itemId'],$_POST['itemQuantity'],$now);

    $added =  $query->execute();
 
}



//add nonconsumable request
if(isset($_POST['itemNonId']) && isset($_POST['userId']) && isset($_POST['role']) && isset($_POST['itemQuantity'])){

    $query = $conn->prepare("INSERT INTO request (requested_by,item_type,item,req_quantity,chair_status,request_date,is_cancelled) VALUES(?,2,?,?,1,?,0)");
     $query->bind_param('iiis',$_POST['userId'],$_POST['itemNonId'],$_POST['itemQuantity'],$now);

   $added =  $query->execute();
 
}



function revertItems($conn,$id){

   $results = $conn->query("SELECT * FROM list WHERE request_id = '$id'");
   
   while($result = $results->fetch_assoc()){
      $item = $result['item'];
      $qty = $result['item_quantity'];

      $conn->query("UPDATE items SET quantity = quantity + '$qty' WHERE item_id = '$item' ");

   }

}

//chair update status
$updated = false;

if(isset($_POST['currentRequest']) && isset($_POST['chairRemarks']) ){


    $query = $conn->prepare("UPDATE request SET dean_status = NULL, ced_status= NULL,supplies_admin_status= NULL,deducted = 1, chair_status = 3, remarks = ? , chair_response_date= ? WHERE request_id = ?");

    $query->bind_param('ssi',$_POST['chairRemarks'],$now,$_POST['currentRequest']);

    $updated = $query->execute();

    revertItems($conn,$_POST['currentRequest']);
}

//dean update status
if(isset($_POST['currentRequest']) && isset($_POST['deanRemarks']) ){

   $query = $conn->prepare("UPDATE request SET ced_status= NULL,supplies_admin_status= NULL,deducted = 1, dean_status = 3, remarks = ? , dean_response_date= ? WHERE request_id = ?");


    $query->bind_param('ssi',$_POST['deanRemarks'],$now,$_POST['currentRequest']);

    $updated = $query->execute();
    revertItems($conn,$_POST['currentRequest']);
}

//ced update status

if(isset($_POST['currentRequest']) && isset($_POST['cedRemarks']) ){

   $query = $conn->prepare("UPDATE request SET supplies_admin_status= NULL,deducted = 1, ced_status = 3, remarks = ? , ced_response_date= ? WHERE request_id = ?");


    $query->bind_param('ssi',$_POST['cedRemarks'],$now,$_POST['currentRequest']);

    $updated = $query->execute();
   revertItems($conn,$_POST['currentRequest']);
}

//supplies update status
if(isset($_POST['currentRequest']) && isset($_POST['suppliesRemarks']) ){

    $query = $conn->prepare("UPDATE request SET claim_status= NULL,deducted = 1, supplies_admin_status = 3, remarks = ? , supplies_response_date= ? WHERE request_id = ?");
    $query->bind_param('ssi',$_POST['suppliesRemarks'],$now,$_POST['currentRequest']);

    $updated = $query->execute();
     revertItems($conn,$_POST['currentRequest']);

}

//DeptHead update status

if(isset($_POST['currentRequest']) && isset($_POST['deptHeadRemarks']) ){

   $query = $conn->prepare("UPDATE request SET supplies_admin_status= NULL,deducted = 1, deptHead_status = 3, remarks = ? , deptHead_response_date= ? WHERE request_id = ?");


    $query->bind_param('ssi',$_POST['deptHeadRemarks'],$now,$_POST['currentRequest']);

    $updated = $query->execute();
    revertItems($conn,$_POST['currentRequest']);
}

// ============New Version==================

// //add List
// if(isset($_POST['owner']) && isset($_POST['item']) && isset($_POST['itemType']) && isset($_POST['itemQuantity'])){
  

//     $query = $conn->prepare("INSERT INTO list (`owner`,item,item_quantity,item_type) VALUES(?,?,?,?)");
//     $query->bind_param('iiii',$_POST['owner'],$_POST['item'],$_POST['itemQuantity'],$_POST['itemType']);

//     $query->execute();
//     addConsumableQueue();
 
// }
// function addConsumableQueue(){
   
//     return json_encode(array(['success'=>true]));
// }


function getList($conn,$owner,$type){
   return $conn->query("SELECT * FROM list INNER  JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE list.owner = $owner AND list.item_type = $type AND list.request_id IS NULL ORDER BY list.list_id DESC");
}

function getListItem($conn,$reqId){
   return $conn->query("SELECT * FROM list INNER  JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id WHERE list.request_id = $reqId");
}

function deleteList($conn,$id){
   return $conn->query("DELETE FROM list WHERE list_id = $id");
}

//teaching staff
function addRequest($conn,$id,$type,$count,$now,$role){

    if($type == 1 || $role == 3 || $role == 4 || $role == 5 || $role == 8){
         if($role == 3 && $type != 1){
            $query = $conn->prepare("INSERT INTO request (requested_by,item_type,total_item,dean_status,request_date,is_cancelled) VALUES(?,?,?,1,?,0)");
            $query->bind_param('iiis',$id,$type,$count,$now);
         }else if($role == 4 && $type != 1){
             $query = $conn->prepare("INSERT INTO request (requested_by,item_type,total_item,ced_status,request_date,is_cancelled) VALUES(?,?,?,1,?,0)");
            $query->bind_param('iiis',$id,$type,$count,$now);
         }else{
            $query = $conn->prepare("INSERT INTO request (requested_by,item_type,total_item,supplies_admin_status,request_date,is_cancelled) VALUES(?,?,?,1,?,0)");
            $query->bind_param('iiis',$id,$type,$count,$now);

         }
    }else{
      if($role == 6){
         $query = $conn->prepare("INSERT INTO request (requested_by,item_type,total_item,chair_status,request_date,is_cancelled) VALUES(?,?,?,1,?,0)");
         $query->bind_param('iiis',$id,$type,$count,$now);
      }else{
          $query = $conn->prepare("INSERT INTO request (requested_by,item_type,total_item,deptHead_status,request_date,is_cancelled) VALUES(?,?,?,1,?,0)");
         $query->bind_param('iiis',$id,$type,$count,$now);
      }
    }

   if($query->execute()){
      return $conn->insert_id;
   }else{
      return 0;
   };
}

function updateList ($conn,$type,$requestId){

    $query = $conn->prepare("UPDATE list SET request_id= ? WHERE item_type = ? AND request_id IS NULL");
    $query->bind_param('ii',$requestId,$type);

     $query->execute();
}



function releaseDetails ($conn,$reqId){
    return $conn->query("SELECT * FROM request INNER JOIN user ON request.requested_by = user.id INNER JOIN `role` ON user.role = role.role_id INNER JOIN list ON request.request_id = list.request_id INNER  JOIN items ON list.item = items.item_id INNER JOIN measurement ON items.measurement = measurement.id INNER JOIN department ON user.department = department.department_id WHERE request.request_id = $reqId");
}

function getAllUsers ($conn){
   return $conn->query('SELECT * FROM user INNER JOIN `role` ON user.role = role.role_id');
}
// update Stocks Quantity

function claimUpdate($conn,$id){
     $lists = $conn->query("SELECT * FROM list INNER JOIN items ON list.item = items.item_id WHERE list.request_id = $id");

     while($list = $lists->fetch_assoc()){
       print_r($list);
       $qty = $list['quantity'] - $list['item_quantity'];
       $itemId = $list['item_id'];
       
       $conn->query("UPDATE items SET quantity = $qty WHERE item_id= $itemId");
       echo $qty;
     }

     $conn->query(" UPDATE request SET claim_status = 2 WHERE request_id = $id");
}

function updateRelease($conn,$id,$now){
     $lists = $conn->query("SELECT * FROM list INNER JOIN items ON list.item = items.item_id WHERE list.request_id = $id");

     while($list = $lists->fetch_assoc()){
      
       $qty = $list['item_quantity'];
       $itemId = $list['item_id'];
       $text = "(".$qty.") - ".$list['item_description']." has been released";
       
       $query = $conn->prepare("INSERT INTO `log` (log_owner,log_description,log_date) VALUES(2,?,?)");
       $query->bind_param('ss',$text,$now);

       $conn->query("UPDATE analysis SET an_total = an_total + '$qty' WHERE prod_id = '$itemId'");
      //  var_dump($query->execute());
      
     }

     $conn->query(" UPDATE request SET claim_status = 2 WHERE request_id = $id");
}

// update Stocks Quantity

function updateAvailableStocks($conn,$id){

     $lists = $conn->query("SELECT * FROM list INNER JOIN items ON list.item = items.item_id WHERE list.request_id = $id");
     
     while($list = $lists->fetch_assoc()){
       $qty = $list['quantity'] - $list['item_quantity'];
       $itemId = $list['item_id'];
       
       $conn->query("UPDATE items SET quantity = $qty WHERE item_id= $itemId");
       echo $qty;
     }

}