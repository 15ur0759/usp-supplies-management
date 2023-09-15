<?php
  require_once('../php/dbConnection.php');
  require_once('../controller/supplies.nonConsumable.controller.php');

  $consumables = getAllNonConsumableItems($conn);
?>

<table id="nonConsumableTable" class="table table-striped">
<thead>
    <tr>
        
        <th>#</th>
        <th>Item Code</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Unit/Measurement</th>
        <th>Category</th>
        <th>Supplier</th>
        <th>Status</th>
        <th>Controls</th>
        
    </tr>
</thead>
<tbody>
    <?php
    while($consumable = $consumables->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$consumable['item_id']?></td>
        <td><?=$consumable['item_code']?></td>
        <td><?=$consumable['item_description']?></td>
        <td><?=$consumable['quantity']?></td>
        <td><?=$consumable['measure_description']?></td>
        <td><?=$consumable['categ_description']?></td>
        <td><?=$consumable['supplier_name']?></td>
        
        <td class="text-center"><div class="form-check form-switch">
            
            <input onchange="updateItemStatus(this)" value="<?=$consumable['item_id']?>" class="form-check-input" type="checkbox" role="switch"  <?php if($consumable['available']){echo 'checked';}?>/>
            </div>
           
        </td>
            <td class="">
            <div class="table-controls text-center d-flex justify-content-center align-items-center">
               
                <div onclick="addQuantity(<?=$consumable['item_id']?>)" data-toggle="modal" data-target="#updateQty" class="table-control text-primary" style="font-size: 1.2rem;">
                    <i class="fas fa-plus-square"></i>
                </div>
                <div onclick="editNonConsumable('<?=$consumable['item_id']?>','<?=$consumable['item_code']?>','<?=$consumable['item_description']?>','<?=$consumable['item_category']?>','<?=$consumable['measurement']?>','<?=$consumable['quantity']?>','<?=$consumable['supplier_id']?>')" data-toggle="modal" data-target="#editNonConsumable" class="table-control table-control-edit">
                    <i class="fas fa-edit"></i>
                </div>
                <div onclick="deleteNonConsumable(<?=$consumable['item_id'];?>)"  class="table-control table-control-delete">
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
        $('#nonConsumableTable').DataTable({order:[[2,'asc']]});
    } );
    
</script>