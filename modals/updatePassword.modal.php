
<!-- Modal -->
<div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-key me-2"></i>Update Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="Post">
          <div class="modal-body">
            <div class="form-group">
                <label>Enter Old Password</label>
               <input required name="oldPassword" type="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Enter New Password (8 Characters or More)</label>
               <input id="password1" minlength='8' required name="newPassword" type="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
               <input disabled id="password2" minlength='8' required  type="password" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button disabled id="passwordSave" type="submit" class="btn btn-primary">Save</button>
          </div>

      </form>
    </div>
  </div>
</div>

<script>
      const password1 = document.querySelector('#password1')
      const password2 = document.querySelector('#password2')
      const passwordSave = document.querySelector('#passwordSave')
      
      password1.addEventListener('keyup',(e)=>{
         if(password1.value.length > 7){
            password2.disabled = false;
         }
      })
      password2.addEventListener('keyup',(e)=>{
         passwordSave.disabled = true;
         passwordSave.innerHTML = 'Password Not Matched';
         if(password1.value === password2.value){
            passwordSave.disabled = false;
            passwordSave.innerHTML = 'Okay';
         }
      })

</script>