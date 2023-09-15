<?php
// require_once('../../php/dbConnection.php');
 


function getAllItemType($conn){
    return $conn->query('SELECT * FROM itemtype');

}

function getCategories($conn){
    return $conn->query('SELECT * FROM categories INNER JOIN itemtype ON categories.itemtype = itemtype.id ORDER BY categories.categ_description');

}

function getConsumableCategories($conn){
    return $conn->query("SELECT * FROM categories INNER JOIN itemtype ON categories.itemtype = itemtype.id  WHERE categories.itemtype='1' ORDER BY categories.categ_description");

}

function getNonConsumableCategories($conn){
    return $conn->query("SELECT * FROM categories INNER JOIN itemtype ON categories.itemtype = itemtype.id  WHERE categories.itemtype='2' ORDER BY categories.categ_description");

}

//add new category
$added = false;

if(isset($_POST['categoryType']) && isset($_POST['categoryDesc'])){
    $query = $conn->prepare("INSERT INTO categories (itemtype,categ_description,isAvailable) VALUES(?,?,1)");
    $query->bind_param('is',$_POST['categoryType'],$_POST['categoryDesc']);

   $added =  $query->execute() or die();

}

//delete
if(isset($_POST['deleteId'])){
    $deleteId = $_POST['deleteId'];

    $query = $conn->prepare("DELETE FROM categories WHERE cat_id = ?");
    $query->bind_param('i',$deleteId);

    $query->execute() or die();

}

//status update
if(isset($_POST['statusId']) && isset($_POST['statusType'])){
    $statusId = $_POST['statusId'];
    $statusType = $_POST['statusType'];

    $query = $conn->prepare("UPDATE categories SET isAvailable= ? WHERE cat_id = ?");
    $query->bind_param('ii',$statusType,$statusId);

    $query->execute() or die();

}


//category update
if(isset($_POST['editCategId']) && isset($_POST['editCategDesc']) && isset($_POST['editCategType'])){
  

    $query = $conn->prepare("UPDATE categories SET itemtype= ? , categ_description= ? WHERE cat_id = ?");
    $query->bind_param('isi',$_POST['editCategType'],$_POST['editCategDesc'],$_POST['editCategId']);

    $query->execute() or die();

}