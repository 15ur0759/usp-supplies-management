<?php
 require_once('log.controller.php');

function currentDate(){
date_default_timezone_set('Asia/Manila');

return date('Y-m-d h:i:s');

}

$now = currentDate();

function getAllItemType($conn){

   return $conn->query('SELECT * FROM itemtype ORDER BY item_description');

}

function getAllSuppliers($conn){

   return $conn->query('SELECT * FROM suppliers WHERE isAvailable=1 ORDER BY supplier_name');

}


function getNonConsumableCategories($conn){
   return $conn->query('SELECT * FROM categories WHERE itemtype=2 AND isAvailable=1 ORDER BY categ_description');

}

function getMeasurements($conn){
   return $conn->query('SELECT * FROM measurement ORDER BY measure_description');

}

function getAllNonConsumableItems($conn){

   return $conn->query("SELECT * FROM items INNER JOIN suppliers ON items.supplier = suppliers.supplier_id INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id WHERE items.item_type = 2");

}

//add item

$added = false;

if(isset($_POST['itemCode']) && isset($_POST['itemDesc']) && isset($_POST['categoryType']) && isset($_POST['supplier']) && isset($_POST['measurementType']) && isset($_POST['itemQuantity'])){

     $query = $conn->prepare("INSERT INTO items (item_code,item_description,item_category,measurement,supplier,quantity,date_modified,available,item_type) VALUES(?,?,?,?,?,?,?,1,2)");
     $query->bind_param('ssiiiis',$_POST['itemCode'],$_POST['itemDesc'],$_POST['categoryType'],$_POST['measurementType'],$_POST['supplier'],$_POST['itemQuantity'],$_POST['dateModified']);

     $added =  $query->execute();

    $text = ''.$_POST['itemDesc'].' - Non Consumable Item has been Added';
    addNewLog($conn,$now,$text,$_POST['owner']);
  
}

//item status update
if(isset($_POST['itemId']) && isset($_POST['itemStatus'])){
    $itemId = $_POST['itemId'];
    $itemStatus = $_POST['itemStatus'];

    echo $itemId;
    echo $itemStatus;

    $query = $conn->prepare("UPDATE items SET available= ? WHERE item_id = ?");
    $query->bind_param('ii',$itemStatus,$itemId);
    $query->execute() or die();

}


//item update
if(isset($_POST['editItemId']) && isset($_POST['editDateModified']) && isset($_POST['editItemCode']) && isset($_POST['editItemDesc']) && isset($_POST['editCategoryType']) && isset($_POST['editSupplier']) && isset($_POST['editMeasurementType'])&& isset($_POST['editItemQuantity'])){

    $query = $conn->prepare("UPDATE items SET item_code= ? , item_description= ? , item_category= ? , supplier= ?, measurement= ? , quantity= ? , date_modified= ? WHERE item_id = ?");

    $query->bind_param('ssiiiisi',$_POST['editItemCode'],$_POST['editItemDesc'],$_POST['editCategoryType'],$_POST['editSupplier'],$_POST['editMeasurementType'],$_POST['editItemQuantity'],$_POST['editDateModified'],$_POST['editItemId']);

    $query->execute();

}

//delete item

if(isset($_POST['itemDeleteId'])){
    $deleteId = $_POST['itemDeleteId'];

    $query = $conn->prepare("DELETE FROM items WHERE item_id = ?");
    $query->bind_param('i',$deleteId);

    $query->execute() or die();
}