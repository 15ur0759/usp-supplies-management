
<!-- Modal -->
<div class="modal fade" id="updateLimit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Change Minimum Stocks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  method="Post" >
          <div class="modal-body">
            <div class="form-group">
                <label>Enter Minimum</label>
               <input value="<?=$currentLimit?>" required name="limitQty"  min='1' pattern='[0-9]' step='1' placeholder="Qty" type="Number" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button  type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning text-light">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>