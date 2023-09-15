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

$requests = getAllParApprovedRequests($conn);

 
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
        <!-- <th>Status Control</th> -->
        <th class="text-center">Show Items</th>
        <th class="text-center">Print</th>
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
             <span class="pending">For Release</span>
        </td>
      
        <!-- <td>
           <button onclick="approvePar(<?=$request['par_owner']?>)" class="btn-sm btn-custom-blue"><i class="fas fa-check me-2"></i>Set As Released</button>
          
        </td> -->
         <td class="text-center">
          <button onclick="loadItems(<?=$request['par_owner']?>)" data-toggle="modal" data-target="#itemsParModal" class="btn-sm btn-primary"><i class="fas fa-list-ol"></i></button>
        </td>
        <td class="text-center">
             <button onclick="sessionSetter(<?=$request['par_owner']?>)"  class="btn-sm btn-success"><i class="far fa-file-pdf"></i></button>
        </td>
     
    </tr>
    <?php
    }
    ?>
</tbody>
</table>

<script>

        var sessionSetter = (id)=>{
       
        $.post('../../ajax/par.session.setter.php',{
            requesterId : id
        }).then(response=>{
            window.open('../../reports/print.ppmp.php', '_blank');
           
        })
     }


     $(document).ready( function () {
        $('#requestTable').DataTable({order:[[0,'desc']]});
    } );
    
</script>