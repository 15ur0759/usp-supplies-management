<?php
  require_once('../php/dbConnection.php');
  require_once('../controller/request.controller.php');



  if(isset($_POST['key']) && isset($_POST['type']) && isset($_POST['filter'])){
    $key = $_POST['key'];
    $type = $_POST['type'];
    $filter = $_POST['filter'];

    $searchResult = searchItems($conn,$type,$key,$filter);
 
  

  
  if($searchResult->num_rows > 0){
    while($result = $searchResult->fetch_assoc()){
?>
<li onclick="setSelected('<?=$result['item_id'];?>',this,'<?=$result['quantity'];?>')">
  <?=$result['item_description'];?>
</li>
<?php } }else{ ?>
<li onclick="clearList()" class="no-result">
 No items Found (Clear)
</li>
<?php } }?>