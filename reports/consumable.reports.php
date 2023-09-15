<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}



function getItems($conn){
    return $conn->query("SELECT * FROM items INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id INNER JOIN suppliers ON items.supplier = suppliers.supplier_id WHERE items.item_type='1'");
}

?>



 <?php include('../includes/header.php')?>
 <link rel="stylesheet" href="../assets/styles/releaseStyle.css?">



<div class="release-report-container shadow">
      <div class="release-header">
      </div>
      <div class="release-header-text text-center mt-5">
       All Consumable Items Report Summary
      </div>
      <div class="release-main-section">
         <div class="release-details-header">
               <div class="release-details-header-left">
                  <div class="rdh">
                    Date: <?=$now?>
                  </div>
                  <div class="rdh">
                     Campus: PSU Urdaneta City Campus
                  </div>
               </div>
            </div>
          <div class="report-main-box mt-5 bg-light">
                <div class="request-box border p-2">
                    <div class="request-box-table mt-5">
                        <table id="consumableTable" class="table table-bordered">
                        <thead>
                            <tr>
                                
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Unit/Measurement</th>
                                <th>Category</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                               $items = getItems($conn);
                               while($item = $items->fetch_assoc()){
                             ?>
                                <tr>
                                    <td><?=$item['item_code']?></td>
                                    <td><?=$item['item_description']?></td>
                                    <td><?=$item['quantity']?></td>
                                    <td><?=$item['measure_description']?></td>
                                    <td><?=$item['categ_description']?></td>
                                    <td><?=$item['supplier_name']?></td>
                                </tr>

                                <?php } ?>
                        
                        </tbody>
                        </table>
                    </div>
                </div>
              </div>
          </div>
      </div>
</div>