<?php
// from supplies category controller

  
?>
<!-- Modal -->
<div class="modal fade" id="itemsParModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 
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
            <button id="closeMe" type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button onclick="showComplete()" type="button" class="btn btn-primary text-light">Set As Released</button>
          </div>
    </div>
  </div>
</div>

<script>
    var showComplete = ()=>{

       if(document.querySelector('#complete').value > 0){
        Swal.fire({
            title: 'Please Confirm?',
            text: "Release this items?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if(result.isConfirmed){
               const ownerId = document.querySelector('#parOwner').value;
             
                $.post('../../ajax/releaseParStatus.php',{
                 ownerId 
                }).then(res=>{
                  console.log(res)
                     const {success} = JSON.parse(res);
                    if(success){
                        loadRelease()
                        document.querySelector('#closeMe').click()
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Request Set As Released!',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    }

            })

            }
        })
       }else{
        Swal.fire({
          icon: 'error',
          title: 'Cannot Release',
          text: 'Some items are insufficient!',
          
        })
       }
    }
    var loadItems = (id)=>{
        $.post('../../ajax/parModalContent.php',{
        reqId : id
        }).then(res=>{
           document.querySelector('#displayUl').innerHTML = res
        })
    }
   
</script>