
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="parQty" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Item Distribution</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="parFormQty" method="Post" >
          <div class="modal-body d-flex flex-wrap justify-content-around">
            <input id="parItemQty"  min='0' pattern='[0-9]' step='1' value='0' required type="hidden" class="form-control">
            <div class="form-group">
                <label>January</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>February</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>March</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>April</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>May</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>June</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>July</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>August</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>September</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>October</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>November</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
            <div class="form-group">
                <label>December</label>
                <input min='0' pattern='[0-9]' step='1' value='0' required type="Number" class="form-control distributions">
            </div>
          </div>
          <div class="modal-footer">
            <button id="modalCloser" type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning text-light">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>