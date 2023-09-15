<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['requestId'])){
  header('location: ../../login.php');
}

$requestId = $_SESSION['requestId'];

$details = releaseDetails($conn,$requestId);
$rows = releaseDetails($conn,$requestId);
$users = getAllUsers($conn)->fetch_all();

$detail = $details->fetch_assoc();

 
?>
 <?php include('../includes/header.php')?>

<style>
    .release-report-container{
        min-height: 100vh;
        width: 80%;
        margin: 0 auto;
    }
    .release-header{
        margin: 1em 0;
        height: 150px;
       background: url('../assets/images/logo.png');
       background-size: contain;
       background-position: center;
       background-repeat: no-repeat;
       
    }
    .release-header-text{
        font-size: 1.5em;
        font-weight: 600;
    }
    .release-main-section{
        padding: 2em 5em;
        margin-top: 2em;
    }
    .release-main-box{
        min-height: 800px;
        position: relative;
    }
    .release-wrap{
        position:absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        min-height: 100px;
        display: block;
      
    }
    .release-details{
       
        min-height: 100px;
        padding: 1em;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .person-details{
        height: 50px;
        min-width: 300px;
        margin:.5em;
        margin-bottom: 4em;
        display: flex;
        justify-content: start;
        align-items: center;
    }
    .item-display{
        min-height: 200px;
        padding: 2em;
    }
</style>

<div class="release-report-container shadow">
      <div class="release-header">
      </div>
      <div class="release-header-text text-center">
         URDANETA CAMPUS - SUPPLIES OFFICE
      </div>
     
      <div class="release-main-section">
          <div class="release-main-box ">
            <div class="item-display">
               <table class="table table-bordered">
                   <thead>
                       <tr>
                          <th>Item</th>
                          <th>Quantity</th>
                       </tr>
                   </thead>
                   <tbody>
                     <?php while($row = $rows->fetch_assoc()){?>
                       <tr>
                          <td> <?=$row['item_description']?></td>
                          <td>  <?=$row['item_quantity']?>
                        (<?=$row['measure_description']?>)
                    </td>
                       </tr>
                         <?php }?>
                   </tbody>
               </table>
            </div>
            <div class="release-wrap">
            <div class="release-details border-bottom mb-3 d-block">
                 <div class="release-approved h6  fw-bold ps-4 ">
                Requested By:
            </div>
            
                <div class="person-details justify-content-start mt-4">
                    
                        <div class="person-detail">
                            <div class="p-1 border-bottom text-center" style="min-width: 150px;">
                                <?=$detail['firstName']?>
                                <?=$detail['lastName']?>
                                
                            </div>
                            <div class="mt-1 fw-bold text-center" style="min-width: 150px;">
                                <?=$detail['description']?>
                                 <div class="fw-normal">
                                    (<?=$detail['request_date']?>)
                                </div>
                            </div>
                          
                        </div>
                   
                </div>
            </div>
            <div class="release-approved h6  fw-bold px-5">
                Approved By:
            </div>
            <div class="release-details ">
              
               <?php if($detail['item_type'] == 2){?>
                <div class="person-details">
                    
                        <div class="person-detail">
                            <div class="p-1 border-bottom text-center" style="min-width: 150px;">
                                <?=$users[2][4]?>
                                <?=$users[2][5]?>
                            </div>
                            <div class="mt-1 fw-bold text-center" style="min-width: 150px;">
                                <?=$users[2][8]?> 
                                <div class="fw-normal">
                                    (<?=$detail['chair_response_date']?>)
                                </div>
                            </div>
                          
                        </div>
                   
                </div>
                <div class="person-details">
                    
                        <div class="person-detail">
                            <div class="p-1 border-bottom text-center" style="min-width: 150px;">
                                <?=$users[3][4]?>
                                <?=$users[3][5]?>
                            </div>
                            <div class="mt-1 fw-bold text-center" style="min-width: 150px;">
                                <?=$users[3][8]?>
                                 <div class="fw-normal">
                                    (<?=$detail['dean_response_date']?>)
                                </div>
                            </div>
                          
                        </div>
                   
                </div>
                <div class="person-details">
                    
                        <div class="person-detail">
                            <div class="p-1 border-bottom text-center" style="min-width: 150px;">
                                <?=$users[4][4]?>
                                <?=$users[4][5]?>
                            </div>
                            <div class="mt-1 fw-bold text-center" style="min-width: 150px;">
                                <?=$users[4][8]?>
                                 <div class="fw-normal">
                                    (<?=$detail['ced_response_date']?>)
                                </div>
                            </div>
                          
                        </div>
                   
                </div>
                  <?php }?>
                 <div class="person-details">
                    
                        <div class="person-detail">
                            <div class="p-1 border-bottom text-center" style="min-width: 150px;">
                                <?=$users[1][4]?>
                                <?=$users[1][5]?>
                            </div>
                            <div class="mt-1 fw-bold text-center" style="min-width: 150px;">
                                <?=$users[1][8]?>
                                 <div class="fw-normal">
                                    (<?=$detail['supplies_response_date']?>)
                                </div>
                            </div>
                          
                        </div>
                   
                </div>
               
            </div>
              </div>
          </div>
      </div>
</div>