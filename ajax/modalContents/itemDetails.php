<?php
   require_once('../../php/dbConnection.php');
   require_once('../../controller/request.controller.php');
  $count = 0;
  $measurement = '';


   if(isset($_POST['itemId'])){
     $id = $_POST['itemId'];

     $details = getItemDetails($conn,$id);
     $detail = $details->fetch_assoc();
     $count = $detail['quantity'];
     $measurement = $detail['measure_description'];

   }

?>

<div class="item-details p-2 bg-primary text-light rounded shadow" style="font-size:1rem;">
    <input type="hidden" id="itemLimit" value="<?=$count?>">
    <div class="item-quantity">Available Items: <?=$count?></div>
    <div class="item-measurement">Measurement: <?=$measurement?></div>
</div>

