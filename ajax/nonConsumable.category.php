<?php
  require_once('../php/dbConnection.php');
  require_once('../controller/supplies.category.controller.php');

  $categories = getNonConsumableCategories($conn);
?>

<table id="categoryTable" class="table table-striped">
<thead>
    <tr>
        
        <th>Description</th>
        <th>Category Type</th>
        <th>Status</th>
        <th>Controls</th>
        
    </tr>
</thead>
<tbody>
    <?php
    while($row = $categories->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$row['categ_description']?></td>
        <td><?=$row['type_description']?></td>
        
        <td class="text-center"><div class="form-check form-switch">
              <input onchange="updateCategoryStatus(this)" value="<?=$row['cat_id']?>" class="form-check-input" type="checkbox" role="switch"  <?php if($row['isAvailable']){echo 'checked';}?>/>
            </div>
        </td>
            <td>
            <div class="table-controls text-center d-flex justify-content-center">
                <div onclick="updateCategory('<?=$row['cat_id']?>','<?=$row['itemtype']?>','<?=$row['categ_description']?>','<?=$row['isAvailable']?>','3')" class="table-control table-control-edit" data-toggle="modal" data-target="#editCategory">
                    <i class="fas fa-edit"></i>
                </div>
                <div onclick="deleteCategory(<?=$row['cat_id'];?>,3)" class="table-control table-control-delete">
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
        $('#categoryTable').DataTable();
    } );
    
</script>