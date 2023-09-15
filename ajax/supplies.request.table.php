<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');



if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}
$type = $_GET['type'];

$userInfo = $_SESSION['userInfo'];

$requests = getAllSuppliesRequests($conn,$type);

 
?>
<table id="requestTable" class="table table-striped">
<thead>
    <tr>
        <th>Request ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Date Requested</th>
        <th>Status</th>
        <th>Status Control</th>
        <th class="text-center">Show Items</th>
    </tr>
</thead>
<tbody>
    <?php
    while($request = $requests->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$request['request_id']?></td>
        <td><?=$request['firstName']?>, <?=$request['lastName']?></td>
        <td><?=$request['description']?></td>
        <td><?=$request['request_date']?></td>
        <td>
             <?php if($request['supplies_admin_status'] == 1){?>
                <span class="pending">Pending</span>
            <?php }?>
            <?php if($request['supplies_admin_status'] == 2){?>
                <span class="approved">Approved</span>
                  <div class="response-date">(<?=$request['supplies_response_date']?>)</div>
            <?php }?>
            <?php if($request['supplies_admin_status'] == 3){?>
                <span class="disapproved">Disapproved</span>
                  <div class="response-date">(<?=$request['supplies_response_date']?>)</div>
            <?php }?>
            <?php if($request['supplies_admin_status'] == null){?>
                <span class="text-danger">--</span>
            <?php }?>
        </td>
      
        <td>
              <?php if($request['supplies_admin_status'] == 1 || $request['supplies_admin_status'] == 3){?>
                 <button onclick="approveRequest(<?=$request['request_id']?>)" class="btn-sm btn-primary">Approve</button>
             <?php }?>

            <?php if($request['supplies_admin_status'] == 1 || $request['supplies_admin_status'] == 2){?>
                <button data-toggle="modal" data-target="#changeSuppliesStatus" onclick="setCurrent(<?=$request['request_id']?>)" class="btn-sm btn-danger">Disapprove</button>

             <?php }?>

              <!-- <?php if($request['supplies_admin_status'] == 1){?>
                <button data-toggle="modal" data-target="#changeSuppliesStatus" onclick="setCurrent(<?=$request['request_id']?>)" class="btn-sm btn-custom-blue"><i class="fas fa-exchange-alt me-2"></i>Change</button>
             <?php }?> -->
        </td>
         <td class="text-center">
          <button onclick="loadItems('<?=$request['request_id']?>')" data-toggle="modal" data-target="#itemsModal" class="btn-sm btn-primary"><i class="fas fa-list-ol"></i></button>
        </td>
        
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