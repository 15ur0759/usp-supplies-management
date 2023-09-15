<?php

  
$roles = getRoles($conn);
$departments = getTeachingDepartments($conn);
$nonDepartments = getNonTeachingDepartments($conn);
  
?>
<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="Post">
          
          <div class="modal-body">
             <div class="form-group">
              <input id="dept" type="hidden" name="department" value="6">
                <label>Role</label>
                <select onchange="deptSelector(this)" required  name="role" class="form-control">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                      while($role = $roles->fetch_assoc()){
                    ?>
                    <option value="<?=$role['role_id']?>"><?=$role['description']?></option>
                   <?php } ?>
                </select>
            </div>
            <div id="teachingDept" class="form-group d-none">
                <label>Department</label>
                <select onchange="updateDept(this)"  class="form-control">
                    <option value="1" selected disabled>--Select--</option>
                    <?php
                      while($department = $departments->fetch_assoc()){
                    ?>
                    <option value="<?=$department['department_id']?>"><?=$department['department_name']?></option>
                   <?php } ?>
                </select>
            </div>
            <div id="nonTeachingDept" class="form-group d-none">
                <label>Department</label>
                <select onchange="updateDept(this)" class="form-control">
                    <option value="1" selected disabled>--Select--</option>
                    <?php
                      while($department = $nonDepartments->fetch_assoc()){
                    ?>
                    <option value="<?=$department['department_id']?>"><?=$department['department_name']?></option>
                   <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>First Name</label>
               <input  required name="newFirstName" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label>Last Name</label>
               <input  required name="newLastName" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label>Email</label>
               <input  required name="email" type="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Username</label>
               <input  required name="username" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>Default Password</label>
               <input readonly value="password1234" required name="password" type="text" class="form-control">
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

<script>
   var teaching = document.querySelector('#teachingDept');
   var nonTeaching = document.querySelector('#nonTeachingDept');

   var reset = ()=>{

    teaching.classList.add('d-none')
    nonTeaching.classList.add('d-none')

   }

   var updateDept = (element)=>{
      document.querySelector('#dept').value = element.value
   }

    var deptSelector = (element)=>{
       if(element.value == 6){
         reset()
         teaching.classList.remove('d-none')
       }else{
         reset()
         nonTeaching.classList.remove('d-none')
       }
    }
</script>