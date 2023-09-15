<?php
  require_once('../php/dbConnection.php');
  require_once('../controller/supplier.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
    header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];

  $suppliers = getAllSuppliers($conn);
?>

<table id="supplierTable" class="table table-striped">
<thead>
    <tr>
        <th>Supplier Id</th>
        <th>Supplier Name</th>
        <th class="text-center">Status</th>
        <th>Date Added</th>
        <th class="text-center">Controls</th>
        
    </tr>
</thead>
<tbody>
    <?php
    while($supplier= $suppliers->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$supplier['supplier_id']?></td>
        <td><?=$supplier['supplier_name']?></td>
        <td class="text-center"><div class="form-check form-switch">
            <input onchange="updateSupplierStatus(this)" value="<?=$supplier['supplier_id']?>" class="form-check-input" type="checkbox" role="switch"  <?php if($supplier['isAvailable']){echo 'checked';}?>/>
            </div>
        </td>
        <td><?=$supplier['date_added']?></td>
        <td>
        <div class="table-controls text-center d-flex justify-content-center">
            <div onclick="updateSupplier('<?=$supplier['supplier_id']?>','<?=$supplier['supplier_name']?>','<?=$userInfo['id']?>')" data-toggle="modal" data-target="#editSupplier" class="table-control table-control-edit">
                <i class="fas fa-edit"></i>
            </div>
            <div onclick="deleteSupplier('<?=$supplier['supplier_id']?>','<?=$supplier['supplier_name']?>','<?=$userInfo['id']?>')" class="table-control table-control-delete">
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
        $('#supplierTable').DataTable({order:[[0,'desc']]});
    } );
    
</script>