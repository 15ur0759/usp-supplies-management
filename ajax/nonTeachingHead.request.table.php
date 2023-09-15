<?php
 require_once('../php/dbConnection.php');
  require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}
$type = $_GET['type'];

$userInfo = $_SESSION['userInfo'];
$department = $userInfo['department_id'];


$requests = getAllHeadRequests($conn,$department,$type);

 
?>
<table id="requestTable" class="table table-striped">
<thead>
    <tr>
        
        <th>Request ID</th>
        <th>Name</th>
         <th>Date Requested</th>
        <th>Status</th>
        <th>Controls</th>
        <th>View</th>
        
    </tr>
</thead>
<tbody>
    <?php
    while($request = $requests->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$request['request_id']?></td>
        <td><?=$request['firstName']?>, <?=$request['lastName']?></td>
        <td><?=$request['request_date']?></td>
        <td>
             <?php if($request['deptHead_status'] == 1){?>
                <span class="pending">Pending</span>
            <?php }?>
            <?php if($request['deptHead_status'] == 2){?>
                <span class="approved">Approved</span>
                <div class="response-date">(<?=$request['deptHead_response_date']?>)</div>
            <?php }?>
            <?php if($request['deptHead_status'] == 3){?>
                <span class="disapproved">Disapproved</span>
                 <div class="response-date">(<?=$request['deptHead_response_date']?>)</div>
            <?php }?>
            <?php if($request['deptHead_status'] == null){?>
                <span class="text-danger">--</span>
            <?php }?>
        </td>
      
        <td>
              <?php if($request['deptHead_status'] == 1 || $request['deptHead_status'] == 3){?>
                 <button onclick="approveRequest(<?=$request['request_id']?>)" class="btn-sm btn-primary">Approve</button>
             <?php }?>

            <?php if($request['deptHead_status'] == 1 || $request['deptHead_status'] == 2){?>
                <button data-toggle="modal" data-target="#changeDeptHeadStatus" onclick="setCurrent(<?=$request['request_id']?>)" class="btn-sm btn-danger">Disapprove</button>

             <?php }?>
              
        </td>
        <td>
          <button onclick="loadItems('<?=$request['request_id']?>')" data-toggle="modal" data-target="#itemsModal" class="btn-sm btn-primary">View Items</button>
        </td>
        
        
        <!-- <td class="text-center"><div class="form-check form-switch">
            
            <input onchange="updateItemStatus(this)" value="<?=$consumable['item_id']?>" class="form-check-input" type="checkbox" role="switch"  <?php if($consumable['available']){echo 'checked';}?>/>
            </div>
           
        </td>
            <td>
            <div class="table-controls text-center d-flex justify-content-center">

                <div onclick="editConsumable('<?=$consumable['item_id']?>','<?=$consumable['item_code']?>','<?=$consumable['item_description']?>','<?=$consumable['item_category']?>','<?=$consumable['measurement']?>','<?=$consumable['quantity']?>')" data-toggle="modal" data-target="#editConsumable" class="table-control table-control-edit">
                    <i class="fas fa-edit"></i>
                </div>
                <div onclick="deleteConsumable(<?=$consumable['item_id'];?>)"  class="table-control table-control-delete">
                    <i class="far fa-trash-alt"></i>
                </div>
            </div>
            </td> -->
    </tr>
    <?php
    }
    ?>
</tbody>
</table>

<script>
     $(document).ready( function () {
        $('#requestTable').DataTable({order:[[0,'desc']]});
    } );
    
</script>