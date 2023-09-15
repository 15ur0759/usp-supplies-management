<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
    header('location: ../../login.php');
}


if(!isset($_SESSION['reportFrom']) && !isset($_SESSION['reportTo'])){
    header('location: ../../login.php');
}

$from = $_SESSION['reportFrom']." 00:00:00";
$to = $_SESSION['reportTo']." 23:59:59";


$departments = getAllDepartments($conn);


function getAllDepartments($conn){
    return $conn->query("SELECT * FROM department WHERE department_id != '6' AND department_id != '5' ORDER BY department_name");
}


function getAllRequests($conn,$dept,$from,$to){
    return $conn->query("SELECT * FROM request INNER JOIN user ON user.id = request.requested_by WHERE user.department = '$dept' AND request.request_date >= '$from' AND request.request_date <= '$to' GROUP BY user.id ORDER BY request_id");
}


function getItems($conn,$requestId){
    return $conn->query("SELECT * FROM list INNER JOIN items ON list.item = items.item_id INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id INNER JOIN suppliers ON items.supplier = suppliers.supplier_id WHERE list.request_id = '$requestId'");
}

function getPersonRequest($conn,$from,$to,$user){
  
   return $conn->query("SELECT * FROM request INNER JOIN user ON user.id = request.requested_by WHERE request.request_date >= '$from' AND request.request_date <= '$to'AND user.id = '$user' ORDER BY request_id");
}


?>



 <?php include('../includes/header.php')?>
 <link rel="stylesheet" href="../assets/styles/releaseStyle.css?ne">



<div class="release-report-container shadow">
      <div class="release-header">
      </div>
      <div class="release-header-text text-center mt-5">
       All Requests Report Summary
      </div>
     
      <div class="release-main-section">
         <div class="release-details-header">
               <div class="release-details-header-left">
                  <div class="d-flex">
                    <div class="rdh me-2">
                     From:
                    </div>
                    <span class="fst-italic"><?=$_SESSION['reportFrom'];?></span>
                  </div>
                  <div class="d-flex">
                    <div class="rdh me-2">
                     To:
                    </div>
                    <span class="fst-italic"><?=$_SESSION['reportTo'];?></span>
                  </div>
                  <div class="d-flex">
                    <div class="rdh me-2">
                     Date Printed:
                    </div>
                    <span class="fst-italic"><?=$now;?></span>
                  </div>
                  <div class="d-flex">
                    <div class="rdh me-2">
                     Campus:
                    </div>
                    <span class="fst-italic">Urdaneta CIty</span>
                  </div>
               </div>
            </div>
            <?php
               while($department = $departments->fetch_assoc()){

               
            ?>
            
            <div class="department-container border mt-5 p-2">
               
              <div class="departments-header  h6 fw-bold bg-dark p-2 text-light"><?=$department['department_name']?></div>
            <?php
               $requests = getAllRequests($conn,$department['department_id'],$from,$to);
               if($requests->num_rows < 1){
             ?>
             <div class="p-4 fst-italic">No Requests Found..</div>
            <?php
                }else{
                   $current = '';
                    while($request = $requests->fetch_assoc()){
            ?>
          <div class="report-main-box mt-5 ">
                <div class="request-box border p-2 bg-light">
                    <div class="request-box-header p-2 bg-primary text-light h6">
                        <div class="requested-by">Name: <span class="ms-2 fw-bold"><?=$request['firstName']?> <?=$request['lastName']?></span> </div>
                          </div>
                           <div class="request-box-table custom-grid fw-bold">
                  

                      <div class="first">Date</div>
                      <div class="second">Item Code</div>
                      <div class="third">Description</div>
                      <div class="fourth">Qty</div>
                      <div class="sixth">Measurement</div>
                     
                 

                    </div>
                        <?php
                         $current = 'current';
                         $persons = getPersonRequest($conn,$from,$to,$request['id']);
                       
                         while($person = $persons->fetch_assoc()){
                            $same = true;
                           if(!strcmp($current,substr($person['request_date'],0,10))){
                               $current = substr($person['request_date'],0,10);
                               $same = false;
                               
                           }
                        ?>
                  
                    <!-- <div class="requested-date mt-5">Date Requested:<span class="ms-2 fw-bold"><?=substr($person['request_date'],0,10)?></span> </div> -->
                    
                    <?php
                         
                          $items = getItems($conn,$person['request_id']);

                          while($item = $items->fetch_assoc()){
                             $same = true;
                            if($current != substr($person['request_date'],0,10)){
                                $current = substr($person['request_date'],0,10);
                                
                                $same = false;
                            }
                        ?>
                    <div class="request-box-table custom-grid">
                  

                      <div class="first">
                          <?php
                           if(!$same){
                            echo substr($person['request_date'],0,10);
                           }
                          ?>
                      </div>
                      <div class="second"><?=$item['item_code']?></div>
                      <div class="third"><?=$item['item_description']?></div>
                      <div class="fourth"><?=$item['item_quantity']?></div>
                      <div class="sixth"><?=$item['measure_description']?></div>
                     
                 

                    </div>
                     <?php } ?>
                      <?php } ?>
                </div>
              </div>
               <?php
               } }
            ?>
               </div>
               <?php } ?>
          </div>
      </div>
</div>
