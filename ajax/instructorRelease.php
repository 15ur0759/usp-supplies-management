<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');



if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];
$requests = getAllForReleaseInstructor($conn,$userInfo['id']);

 
?>
<table id="requestTable" class="table table-striped">
<thead>
    <tr>
        
        <th>Request ID</th>
        <th>Date Requested</th>
        <th>Release Status</th>
        <th class="text-center">Print</th>
    </tr>
</thead>
<tbody>
    <?php
    while($request = $requests->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$request['request_id']?></td>
        <td><?=$request['request_date']?></td>
        <td>
             <?php if($request['claim_status'] == 1){?>
                <span class="pending">For Release</span>
            <?php }?>
            <?php if($request['claim_status'] == 2){?>
                <span class="approved">Released</span>
                  <div class="response-date">(<?=$request['supplies_response_date']?>)</div>
            <?php }?>
            <?php if($request['claim_status'] == 3){?>
                <span class="disapproved">Returned</span>
                  <div class="response-date">(<?=$request['supplies_response_date']?>)</div>
            <?php }?>
            <?php if($request['claim_status'] == null){?>
                <span class="text-danger">--</span>
            <?php }?>
        </td>
       
         <td class="text-center">
          <!-- <button  data-toggle="tooltip" data-placement="right" title="Show Items" onclick="loadItems('<?=$request['request_id']?>')" data-toggle="modal" data-target="#itemsModal" class="btn-sm btn-primary"><i class="fas fa-list-ol"></i></button> -->

          <button data-toggle="tooltip" data-placement="right" title="Print PDF" onclick="sessionSetter('<?=$request['request_id']?>')"  class="btn-sm btn-success ms-3"><i class="far fa-file-pdf"></i></button>
        </td>
    </tr>
    <?php
    }
    ?>
</tbody>
</table>

<script>

     var sessionSetter = (id)=>{
       
        $.post('../../ajax/releaseRedirect.php',{
            requestId : id
        }).then(response=>{
            window.open('../../reports/release.php', '_blank');
           
        })
     }
     $(document).ready( function () {
        $('#requestTable').DataTable({order:[[0,'desc']]});
    } );
    
</script>