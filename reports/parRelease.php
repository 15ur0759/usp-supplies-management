<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['requestId'])){
  header('location: ../../login.php');
}

$requestId = $_SESSION['requestId'];


$supplies = getSuppliesAdmin($conn);
$requester = getRequester($conn,$requestId);
$quantities = getReleaseItem($conn,$requestId);
$units = getReleaseItem($conn,$requestId);
$items = getReleaseItem($conn,$requestId);
$dates = getReleaseItem($conn,$requestId);





 
?>
 <?php include('../includes/header.php')?>
 <link rel="stylesheet" href="../assets/styles/releaseStyle.css?">



<div class="release-report-container shadow">
      <div class="release-header">
      </div>
      <div class="release-header-text text-center mt-5">
       Property Acknowledgement Receipt
      </div>
     
      <div class="release-main-section">
         <div class="release-details-header">
               <div class="release-details-header-left">
                  <div class="rdh">
                    Entity Name: <span class="entity-name ms-2 text-uppercase"><?=$requester['firstName']?> <?=$requester['lastName']?></span>
                  </div>
                  <div class="rdh">
                      Fund Cluster: <span class="fund-cluster">01-0101001-(<?=rand(100,999);?>)</span>
                  </div>
               </div>
               <div class="release-details-header-right">
                 <div class="rdh text-center">
                      PAR No: <span class="fund-cluster"><?=substr($now,0,7);?>-<?=rand(100,999);?></span>
                  </div>
               </div>
            </div>
          <div class="release-main-box ">
             <div class="main-release-table">
                <div class=" quantity">
                    <div class="table-header">Quantity</div>
                    <?php
                      while($quantity = $quantities->fetch_assoc()){
                    ?>
                     <div class="displays"><?=$quantity['par_quantity'];?></div>
                    <?php }?>
                   
                </div>
                <div class=" unit">
                     <div class="table-header">Unit</div>
                       <?php
                      while($unit = $units->fetch_assoc()){
                    ?>
                     <div class="displays"><?=$unit['measure_description'];?></div>
                    <?php }?>
                </div>
                <div class=" description">
                     <div class="table-header">Description</div>
                     
                       <?php
                      while($item = $items->fetch_assoc()){
                    ?>
                     <div class="displays"><?=$item['item_description'];?></div>
                    <?php }?>
                </div>
                <div class=" date-acquired">
                      <div class="table-header">Date Acquired</div>
                       
                       <?php
                      while($date = $dates->fetch_assoc()){
                    ?>
                     <div class="displays"><?=substr($now,0,10);?></div>
                    <?php }?>
                </div>
             </div>
            <div class="main-box-bottom">
                <div class="main-box-bottom-left">
                    <div class="bottom-details-header">
                        Received by :
                    </div>
                    <div class="bottom-details-main">
                        <div class="details-main">
                            <div class="name"><?=$requester['firstName']?> <?=$requester['lastName']?></div>
                            <div class="sub">Signature Over Printed Name of End User</div>
                            <div class="Position"><?=$requester['description']?> <?=$requester['department_name']?></div>
                            <div class="sub">Position/Office</div>
                            <div class="date"><?=substr($now,0,10);?></div>
                            <div class="sub">Date</div>
                        </div>
                    </div>
                </div>
                <div class="main-box-bottom-right">
                     <div class="bottom-details-header">
                         Issued by :
                    </div>
                      <div class="bottom-details-main">
                         <div class="details-main">
                            <div class="name"><?=$supplies['firstName']?> <?=$supplies['lastName']?></div>
                            <div class="sub">Signature Over Printed Name of Supply and/or Property</div>
                            <div class="Position">Supplies Admin</div>
                            <div class="sub">Position/Office</div>
                            <div class="date"><?=substr($now,0,10);?></div>
                            <div class="sub">Date</div>
                        </div>
                    </div>
                </div>
            </div>
              </div>
          </div>
      </div>
</div>