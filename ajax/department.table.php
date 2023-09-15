<?php
 echo getcwd();
 require_once('../controller/campusAdmin.controller.php');
 require_once('../php/dbConnection.php');
 require_once('../php/sessions.php');
 
 echo getcwd();


  $departments = getDepartments($conn);

//   while($department = $departments->fetch_assoc()){
//     echo $department['department_name'];
//   }
 
 
?>

<table id="userTable" class="table table-striped">
    <thead>
        <tr>


            <th>Id</th>
            <th>Department Name</th>
            <th class="text-center">Controls</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while($department = $departments->fetch_assoc()){
        ?>
        <tr>

        
            
                <td><?=$department['department_id']?></td>
                <td><?=$department['department_name']?></td>
                <td>
                <div class="table-controls text-center d-flex justify-content-center">
                    <div onclick="" data-toggle="modal" data-target="#editSupplier" class="table-control table-control-edit">
                    <i class="fas fa-edit"></i>
                    </div>
                    <div onclick="deleteDepartment(<?=$department['department_id']?>)" class="table-control table-control-delete">
                    <i class="far fa-trash-alt"></i>
                    </div>
                </div>
                </td>
            
            
            
        
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
$('#userTable').DataTable();
} );

</script>