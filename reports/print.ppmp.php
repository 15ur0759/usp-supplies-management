<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['requesterId'])){
  header('location: ../../login.php');
}

$requesterId = $_SESSION['requesterId'];

$supplies = getSuppliesAdmin($conn);
$requester = getRequester($conn,$requesterId); 

$items = getAllAddedPar($conn,$requesterId);
?>
 <?php include('../includes/header.php')?>
 <link rel="stylesheet" href="../assets/styles/releaseStyle.css?new">



<div id="printable" class="release-report-container ppmp-container shadow">
     <div class="release-header">
      </div>
      <div class="ppmp-header mt-4">
        PANGASINAN STATE UNIVERSITY
      </div>
      <div class="release-header-text text-center ppmp-header-text mt-2">
       PROJECT PROCUREMENT MANAGEMENT PLAN 2023
      </div>
     
      <div class="release-main-section ppmp-main-section">
         <!-- <div class="release-details-header">
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
            </div> -->
          <div class="release-main-box  border-0">
             <div class="main-release-table">
              <div class="ppmp-table">
               <table id="requestTable" class="table table-bordered border over-flow-hidden"  style="font-size: .7rem;">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Measurement</th>
                        <th>Quantity</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>May</th>
                        <th>June</th>
                        <th>Jul</th>
                        <th>Aug</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($item = $items->fetch_assoc()){
                      
                    ?>
                    <tr>
                        
                        <td><?=$item['item_code']?></td>
                        <td><?=$item['item_description']?></td>
                        <td><?=$item['categ_description']?></td>
                        <td><?=$item['measure_description'];?></td>
                        <td>
                                <?=$item['par_quantity'];?>
                              
                            </td>
                      
                        <td> <?=$item['jan'];?></td>
                        <td> <?=$item['feb'];?></td>
                        <td> <?=$item['mar'];?></td>
                        <td> <?=$item['apr'];?></td>
                        <td> <?=$item['may'];?></td>
                        <td> <?=$item['june'];?></td>
                        <td> <?=$item['july'];?></td>
                        <td> <?=$item['aug'];?></td>
                        <td> <?=$item['sep'];?></td>
                        <td> <?=$item['oct'];?></td>
                        <td> <?=$item['nov'];?></td>
                        <td> <?=$item['decem'];?></td>
                      
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                </table>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
     var savePdf = () =>{
        var table = document.querySelector('#printable');

       
        var opt = {
        margin:       0,
        filename:     'ppmp.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 5 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(table).save();
     }
     savePdf()
    //  window.print()
</script>