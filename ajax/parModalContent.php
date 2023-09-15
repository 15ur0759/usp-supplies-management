<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');


 if(isset($_POST['reqId'])){
    $listItems = getAllParItems($conn,$_POST['reqId']);
 
   $complete = 1;
?>
  <table class="table">
      <thead>
           <tr>
              <th>Item</th>
              <th>Quantity</th>
              <th>Available Stocks</th>
           </tr>
      </thead>
       <tbody>
        <?php   while($listItem = $listItems->fetch_assoc()){
             if($listItem['par_quantity'] > $listItem['quantity']){
               $complete = 0;
             }
         ?>
          <input type="hidden" name="" id="parOwner" value="<?=$listItem['par_owner']?>">
          <tr>
             <td>
                <?=$listItem['item_description']?>
             </td>
             <td>
                <?=$listItem['par_quantity']?>
             </td>
             <td>
                <?=$listItem['quantity']?>
             </td>
          </tr>
        <?php  }?>
       </tbody>
  </table>
  <input type="hidden" name="" id="complete" value="<?=$complete?>">
  <input type="hidden" name="" id="parOwner" value="<?=$parOwner?>">
<?php  } ?>