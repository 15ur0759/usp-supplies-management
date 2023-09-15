<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$requests = getAllRequests($conn);


function getAllRequests($conn){
    return $conn->query("SELECT * FROM request INNER JOIN user ON user.id = request.requested_by WHERE claim_status = '1' ORDER BY request_id DESC");
}


function getItems($conn,$requestId){
    return $conn->query("SELECT * FROM list INNER JOIN items ON list.item = items.item_id INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id INNER JOIN suppliers ON items.supplier = suppliers.supplier_id WHERE list.request_id = '$requestId'");
}

?>



 <?php include('../includes/header.php')?>
 <link rel="stylesheet" href="../assets/styles/releaseStyle.css?">



<div class="release-report-container shadow">
      <div class="release-header">
      </div>
      <div class="release-header-text text-center mt-5">
       All Released Items Summary
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
            <?php
               while($request = $requests->fetch_assoc()){
            ?>
          <div class="report-main-box mt-5 bg-light">
                <div class="request-box border p-2">
                    <div class="request-box-header  p-2">
                        <div class="requested-by">Requested By: <span class="ms-2 fw-bold"><?=$request['firstName']?> <?=$request['lastName']?></span> </div>
                        <div class="requested-date">Date Requested:<span class="ms-2 fw-bold"><?=$request['request_date']?></span> </div>
                    </div>
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
                               $items = getItems($conn,$request['request_id']);
                               while($item = $items->fetch_assoc()){
                             ?>
                                <tr>
                                    <td><?=$item['item_code']?></td>
                                    <td><?=$item['item_description']?></td>
                                    <td><?=$item['item_quantity']?></td>
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
               <?php
               }
            ?>
          </div>
      </div>
</div>