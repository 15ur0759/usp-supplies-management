<?php
 require_once('../php/dbConnection.php');
  require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];

$requests = getAllRequests($conn,$userInfo['id']);

$totalItems = $requests->num_rows;

 
?>
<table id="requestTable" class="table table-striped">
<thead>
    <tr>
        
        <th>Request Id</th>
        <th>Type</th>
        <th>Dean Status</th>
        <th>Ced Status</th>
        <th>Supplies Admin Status</th>
        <th>Date Requested</th>
        <th>Remarks</th>
        <th class="text-center">Show Items</th>
       
        
    </tr>
</thead>
<tbody>
    <?php
    while($request = $requests->fetch_assoc()){
    ?>
    <tr>
        <td><?=$request['request_id']?></td>
        <td><?=$request['type_description']?></td>
        <td>
             <?php if($request['dean_status'] == 1){?>
                <span class="pending">Pending</span>
            <?php }?>
            <?php if($request['dean_status'] == 2){?>
                <span class="approved">Approved</span>
                <div class="response-date">(<?=$request['dean_response_date']?>)</div>
            <?php }?>
            <?php if($request['dean_status'] == 3){?>
                <span class="disapproved">Disapproved</span>
                <div class="response-date">(<?=$request['dean_response_date']?>)</div>
            <?php }?>
            <?php if($request['dean_status'] == null){?>
                <span class="text-danger fw-bold">--</span>
            <?php }?>
        </td>
        <td>
             <?php if($request['ced_status'] == 1){?>
                <span class="pending">Pending</span>
            <?php }?>
            <?php if($request['ced_status'] == 2){?>
                <span class="approved">Approved</span>
                <div class="response-date">(<?=$request['ced_response_date']?>)</div>
            <?php }?>
            <?php if($request['ced_status'] == 3){?>
                <span class="disapproved">Disapproved</span>
                <div class="response-date">(<?=$request['ced_response_date']?>)</div>
            <?php }?>
            <?php if($request['ced_status'] == null){?>
                <span class="text-danger fw-bold">--</span>
            <?php }?>
        </td>
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
                <span class="text-danger fw-bold">--</span>
            <?php }?>
        </td>
       
        <td><?=$request['request_date']?></td>
        <td><?=$request['remarks']?></td>
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
     var setCurrentId = (id)=>{
        document.querySelector('#currentReq').value = id;
     }


     $(document).ready( function () {
        $('#requestTable').DataTable({order:[[0,'desc']]});
    } );
    
</script>