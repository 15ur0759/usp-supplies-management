<?php
// from supplies category controller
  
   $categories = getNonConsumableCategories($conn);
   $measurements = getMeasurements($conn);
   $suppliers = getAllSuppliers($conn);
  
?>
<!-- Modal -->
<div class="modal fade" id="editNonConsumable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Edit Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editNonConsumableForm" action="" method="Post">
          <input id="editDateModified" type="hidden" name="dateModified" >
          <div class="modal-body">
            <div class="form-group">
                <label>Item Code</label>
               <input id="editItemCode" required name="editItemCode" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Item Description</label>
               <input id="editItemDesc" required name="editItemDesc" type="text" class="form-control">
            </div>
           
            <div class="form-group">
                <label>Supplier</label>
                <select id="editSupplier" required  name="editSupplier" class="form-control">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                      while($supplier = $suppliers->fetch_assoc()){

                    ?>
                    <option value="<?=$supplier['supplier_id'];?>"><?=$supplier['supplier_name'];?></option>
                   <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select id="editCategoryType" required  name="editCategoryType" class="form-control">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                      while($category = $categories->fetch_assoc()){

                    ?>
                    <option value="<?=$category['cat_id'];?>"><?=$category['categ_description'];?></option>
                   <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Measurement</label>
                <select id="editMeasurementType" required  name="editMeasurementType" class="form-control">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                      while($measurement = $measurements->fetch_assoc()){

                    ?>
                    <option value="<?=$measurement['id'];?>"><?=$measurement['measure_description'];?></option>
                   <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Quantity</label>
               <input id="editItemQuantity" min='1' pattern='[0-9]' step='1' required name="editItemQuantity" type="number" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button id="hideItemEditModal" type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning">Update</button>
          </div>

      </form>
    </div>
  </div>
</div>

<script>
     document.querySelector('#dateModified').value =  Date.now().toString()
</script>