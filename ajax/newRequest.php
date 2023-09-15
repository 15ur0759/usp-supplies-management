<!-- style is on request.css -->

<div class="request-form-main">
    <div class="request-form-options">
        <div class="main-category-options d-flex align-items-center">
             <div onclick="loadConsumableForm(this)"  class="form-type form-type-active"><i class="fas fa-box-open me-2"></i>Consumable Items
            </div>
             <div onclick="loadNonConsumableForm(this)"  class="form-type "><i class="fas fa-box me-2"></i>Non-Consumable Items</div>
        </div>
    </div>
    <div id="requestFormLoad" class="request-form-load my-4 mx-2">
         
    </div>
</div>
<script>
    
    var formTypes = document.querySelectorAll('.form-type');
    
    
    var  toggleForm = (element)=>{
        resetForm()
        element.classList.add('form-type-active')
    }

    var  resetForm = ()=>{
        formTypes.forEach(mc=>{
            mc.classList.remove('form-type-active');
        })
    }
      
    var  loadConsumableForm = (element)=>{
         element &&  toggleForm(element);
         $('#requestFormLoad').load('../../ajax/consumableForm.php');
    }

    var  loadNonConsumableForm = (element)=>{
         element &&  toggleForm(element);
         $('#requestFormLoad').load('../../ajax/nonConsumableForm.php');
    }

    loadConsumableForm()
</script>

<!-- script is on parent Component -->