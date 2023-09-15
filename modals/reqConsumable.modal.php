<?php
 $items = getAllConsumableItems($conn);
 $measurement;

?>
<!-- Modal -->
<div class="modal fade" id="reqConsumable" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-box-open me-2 text-primary"></i>Request Consumable Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="Post">
        <input type="hidden" name="role" value="<?=$userInfo['role']?>">
        <input type="hidden" name="userId" value="<?=$userInfo['id']?>">
        <input type="hidden" id='reqDate' name="requestDate" >
       
          <div class="modal-body">
            <div class="form-group">
                <label>Select Items</label>
                <select onchange="getConsumableDetails(this)" required  name="itemId" class="form-control">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                      while($item = $items->fetch_assoc()){
                        $measurement = $item['measure_description'];
                    ?>
                    <option onclick="tester(<?=$item['item_description'];?>)" value="<?=$item['item_id'];?>"><?=$item['item_description'];?></option>
                   <?php } ?>
                </select>
            </div>
             <div id="loadDetails">
                      
              </div>
             <div class="form-group">
                <label>Quantity</label>
               <input id="consumableQty" min='1' pattern='[0-9]' step='1' required name="itemQuantity" type="number" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary text-light" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script>

     
  
     document.querySelector('#reqDate').value =  new Date().toString().slice(4,16)
  
     const getConsumableDetails = (element)=>{
        const itemId= element.value;

        $.post('../../ajax/modalContents/itemDetails.php',{
            itemId 
        }).then(res=>{
           document.querySelector('#loadDetails').innerHTML = res;
           document.querySelector('#consumableQty').max = document.querySelector('#itemLimit').value
        })

        
     }
</script>