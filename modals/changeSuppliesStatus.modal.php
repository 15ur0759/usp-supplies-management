
<!-- Modal -->
<div class="modal fade" id="changeSuppliesStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Change Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="Post" >
        <input type="hidden" name="currentRequest" id="currentRequest">
           <div class="modal-body">
            <div class="form-group">
                <textarea required   class="form-control" placeholder="Remarks" name="suppliesRemarks" id="" cols="30" rows="10"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning text-light">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>