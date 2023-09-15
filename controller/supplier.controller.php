<?php
 require_once('log.controller.php');

//add new category
$added = false;

if(isset($_POST['supplierName'])){
    $owner = $_POST['owner'];
    $query = $conn->prepare("INSERT INTO suppliers (supplier_name,date_added,isAvailable) VALUES(?,?,1)");
    $query->bind_param('ss',$_POST['supplierName'],$now);
    $added =  $query->execute() or die();
    
    $text = 'Supplier '.$_POST['supplierName'].' is Added';
    addNewLog($conn,$now,$text,$owner);


}

//status update
if(isset($_POST['statusId']) && isset($_POST['statusType'])){
    $statusId = $_POST['statusId'];
    $statusType = $_POST['statusType'];

    $query = $conn->prepare("UPDATE suppliers SET isAvailable= ? WHERE supplier_id = ?");
    $query->bind_param('ii',$statusType,$statusId);

    $query->execute() or die();

}

//delete
if(isset($_POST['deleteId']) && isset($_POST['supplier'])){
   
    $deleteId = $_POST['deleteId'];
  
    $query = $conn->prepare("DELETE FROM suppliers WHERE supplier_id = ?");
    $query->bind_param('i',$deleteId);

    $query->execute();
  

    $text = 'Supplier '.$_POST['supplier'].' has been Deleted';
    addNewLog($conn,$now,$text,$_POST['owner']);

}

function getAllSuppliers($conn){
  return $conn->query("SELECT * FROM suppliers");
}

//category update
if(isset($_POST['name']) && isset($_POST['newName']) && isset($_POST['owner']) && isset($_POST['currentId'])){
  

    $query = $conn->prepare("UPDATE suppliers SET supplier_name= ? WHERE supplier_id = ?");
    $query->bind_param('si',$_POST['newName'],$_POST['currentId']);

    $query->execute() or die();
//    $text = 'Supplier '.$_POST['name'].' has been Renamed to '.$_POST['newName'];
//    addNewLog($conn,$now,$text,$_POST['owner']);
}

//   name,
//                newName: supplierName.value,
//                owner: currentOwner,
//                currentId