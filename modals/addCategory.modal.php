<?php
// from supplies category controller
   $types = getAllItemType($conn);
  
?>
<!-- Modal -->
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="Post">
          <div class="modal-body">
            <div class="form-group">
                <label>Select Type</label>
                <select required  name="categoryType" class="form-control">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                      while($type = $types->fetch_assoc()){

                    ?>
                    <option value="<?=$type['id'];?>"><?=$type['type_description'];?></option>
                   <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Description</label>
               <input required name="categoryDesc" type="text" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>

      </form>
    </div>
  </div>
</div>