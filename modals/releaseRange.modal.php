
<!-- Modal -->
<div class="modal fade" id="releaseRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Generate Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  action="" method="Post">
          <input id="deptId" type="hidden" name="deptId">
          <div class="modal-body">
            <div class="form-group">
                <label>From</label>
               <input onChange="setMinimum(this)" id="releaseFrom"   required name="releaseFrom" type="date" class="form-control">
            </div>
            <div class="form-group">
                <label>To</label>
               <input  disabled id="releaseTo"  required name="releaseTo" type="date" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Generate</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
      const now = new Date(Number(Date.now().toString())).toISOString().slice(0,10);
      const rfrom = document.querySelector('#releaseFrom');
      const rto = document.querySelector('#releaseTo');

      rfrom.max = now;
      rto.max = now;

      const setMinimum = (element) =>{
        rto.min = element.value;
        rto.disabled = false;
      }

     

     
</script>