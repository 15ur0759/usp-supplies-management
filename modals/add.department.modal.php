<?php

  
$roles = getRoles($conn);
$departments = getDepartments($conn);
  
?>
<!-- Modal -->
<div class="modal fade" id="addDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="Post">
          
          <div class="modal-body">
            <div class="form-group">
              <label for="">Department Type</label>
               <select required name="newDeptType"  class="form-control">
                  <option value="" selected disabled>Select</option>
                  <option value="1">Teaching</option>
                  <option value="2">Non-Teaching</option>
               </select>
            </div>
            <div class="form-group">
                <label>Department Name</label>
               <input  required name="newDepartmentName" type="text" class="form-control">
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

<!-- <script>
     document.querySelector('#dateModified').value =  Date.now().toString()
</script> -->