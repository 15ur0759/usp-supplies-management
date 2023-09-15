<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');



if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];

$requests = getAllParDisApprovedRequests($conn);

 
?>
<table id="requestTable" class="table table-striped">
<thead>
    <tr>
        <th>PAR ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Department</th>
        <th>Date Requested</th>
        <th>Status</th>
        <th>Date Disapproved</th>
        <th class="text-center">Show Items</th>
    </tr>
</thead>
<tbody>
    <?php
    while($request = $requests->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$request['par_id']?></td>
        <td><?=$request['firstName']?>, <?=$request['lastName']?></td>
        <td><?=$request['description']?></td>
        <td><?=$request['department_name']?></td>
        <td><?=$request['par_date_sent']?></td>
        <td>
             <span class="disapproved">Disapproved</span>
        </td>
      
        <td>
          <?=$request['supplies_response']?>
        </td>
         <td class="text-center">
          <button onclick="loadItems(<?=$request['par_owner']?>)" data-toggle="modal" data-target="#itemsParModal" class="btn-sm btn-primary"><i class="fas fa-list-ol"></i></button>
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