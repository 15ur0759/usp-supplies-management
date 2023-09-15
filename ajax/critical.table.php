<?php
  require_once('../php/dbConnection.php');
  require_once('../controller/supplies.nonConsumable.controller.php');

  $limit = getLimit($conn);
  $consumables = allCritical($conn,$limit);
  $counter = $consumables->num_rows;



  function allCritical($conn,$limit){
    return $conn->query("SELECT * FROM items INNER JOIN suppliers ON items.supplier = suppliers.supplier_id INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON items.measurement = measurement.id INNER JOIN itemtype ON itemtype.id = items.item_type WHERE items.quantity < $limit");
  }


  function getLimit($conn){
    $result = $conn->query("SELECT `minimum` FROM critical");

    $limit = $result->fetch_assoc();
    return $limit['minimum'];
  }
?>

<div class="main-category-header border-bottom">
    <div class="">
        <div  class="fw-bold text-danger">Total Critical Items : (<span class="crit-counter"><?=$counter?></span>)</div>
    </div>
    <div class="d-flex">
        <div  class="me-2 bg-light p-2 fw-bold fst-italic">
        Items with lesser than <span class="fw-bold fst-italic text-primary">( <?=$limit?> )</span> stocks will be marked as critical.
        </div>
        <button class="btn-sm btn-dark" data-toggle="modal" data-target="#updateLimit"> <i class="fas fa-cog me-2 "></i>Change</button>
    </div>
</div>

<div  class="main-category-table">
    <table id="nonConsumableTable" class="table table-striped">
    <thead>
        <tr>
            
        
            <th>Item Code</th>
            <th>Item Type</th>
            <th>Description</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Qty</th>
            <th>Unit/Measurement</th>
            <th>Controls</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        while($consumable = $consumables->fetch_assoc()){
        ?>
        <tr>
            
        
            <td><?=$consumable['item_code']?></td>
            <td><?=$consumable['type_description']?></td>
            <td><?=$consumable['item_description']?></td>
            <td><?=$consumable['categ_description']?></td>
            <td><?=$consumable['supplier_name']?></td>
            <td class="fw-bold text-danger" style="font-size: 1.2em"><?=$consumable['quantity']?></td>
            <td><?=$consumable['measure_description']?></td>
            <td class="">
                <div class="table-controls text-center d-flex justify-content-center align-items-center">
                
                    <div onclick="addQuantity(<?=$consumable['item_id']?>)" data-toggle="modal" data-target="#updateQty" class="table-control text-primary" style="font-size: 1.2rem;">
                        <i class="fas fa-plus-square"></i>
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
</div>