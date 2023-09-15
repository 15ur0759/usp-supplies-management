<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


 if(isset($_POST['reqId'])){
    $listItems = getListItem($conn,$_POST['reqId']);

 
 
 
?>
  <table class="table">
      <thead>
           <tr>
              <th>Item</th>
              <th>Quantity</th>
           </tr>
      </thead>
       <tbody>
        <?php   while($listItem = $listItems->fetch_assoc()){?>
          <tr>
             <td>
                <?=$listItem['item_description']?>
             </td>
             <td>
                <?=$listItem['item_quantity']?>
             </td>
          </tr>
        <?php  }?>
       </tbody>
  </table>
<?php  } ?>