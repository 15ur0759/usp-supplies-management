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


$requests = getAllChairRequests($conn,$department,$type);

 
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
             <?php if($request['chair_status'] == 1){?>
                <span class="pending">Pending</span>
            <?php }?>
            <?php if($request['chair_status'] == 2){?>
                <span class="approved">Approved</span>
                <div class="response-date">(<?=$request['chair_response_date']?>)</div>
            <?php }?>
            <?php if($request['chair_status'] == 3){?>
                <span class="disapproved">Disapproved</span>
                 <div class="response-date">(<?=$request['chair_response_date']?>)</div>
            <?php }?>
            <?php if($request['chair_status'] == null){?>
                <span class="text-danger">--</span>
            <?php }?>
        </td>
      
        <td>
                    
           <?php if($request['chair_status'] == 1 || $request['chair_status'] == 3){?>
                 <button onclick="approveRequest(<?=$request['request_id']?>)" class="btn-sm btn-primary">Approve</button>
             <?php }?>

            <?php if($request['chair_status'] == 1 || $request['chair_status'] == 2){?>
                <button data-toggle="modal" data-target="#changeStatus" onclick="setCurrent(<?=$request['request_id']?>)" class="btn-sm btn-danger">Disapprove</button>

             <?php }?>

           

          
        </td>
        <td>
          <button onclick="loadItems('<?=$request['request_id']?>')" data-toggle="modal" data-target="#itemsModal" class="btn-sm btn-primary">View Items</button>
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