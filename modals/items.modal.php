<?php
// from supplies category controller
  
  
?>
<!-- Modal -->
<div class="modal fade" id="itemsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
   
          <div id="modalTableDisplay" class="modal-body">
            <input type="hidden" id="currentReq">
                <div id="displayUl">

                </div>
           
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
          </div>
    </div>
  </div>
</div>

<script>
    var loadItems = (id)=>{
        $.post('../../ajax/itemsModalContent.php',{
        reqId : id
        }).then(res=>{
           document.querySelector('#displayUl').innerHTML = res
        })
    }
   
</script>