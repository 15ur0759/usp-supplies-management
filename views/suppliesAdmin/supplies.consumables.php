<?php
 require_once('../../php/dbConnection.php');
 require_once('../../controller/supplies.consumable.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');


 
include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
$active = 3;

$title = '<i class="fas fa-box-open me-3"></i>Consumables';
 $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
   $ago = lastSuppliesRequest($conn);
  $show = false;
  
  if($notifications > 0){
    $show = true;
  }
    $link = './supplies.requests.php?query=1';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
   
    <title>Supplies Admin</title>
</head>

<body>
     <?php include('../../modals/addConsumable.modal.php')?>
     <?php include('../../modals/editConsumable.modal.php')?>
        <?php include('../../modals/updateQtyModal.php')?>
    <div class="admin-container">
          <?php include('../../includes/suppliesSideNav.php')?>
        <div class="main bg-light">
              <?php include('../../includes/loading.php')?>
             <?php include('../../includes/mainTop.php')?>
            </div>

            <div class="main-bottom categories-main">
                <div class="main-section categories-main-section border w-100">
                  
                    <div class=" categories-main-right">
                          <div class="main-category-header border-bottom">
                            <div class="main-category-options d-flex align-items-center">
                                <div onclick="" class="main-category-type main-category-active"><i class="fas fa-box-open me-2"></i>All Items</div>
                                <!-- <div onclick="" class="main-category-type "><i class="fas fa-reply me-2"></i>Available Items</div>
                                <div onclick="" class="main-category-type "><i class="fas fa-exclamation-triangle me-2"></i>Unavailable Items</div> -->

                            </div>
                            <button class="custom-btn custom-btn-blue" data-toggle="modal" data-target="#addConsumable"> <i class="fas fa-plus me-2 "></i>Add New</button>
                        </div>

                        <div id="consumableDisplay" class="main-category-table">
                            <!-- load HEre -->
                        </div>
                    </div>
               </div>
                 
            </div>
             <?php include('../../includes/footer.php')?>
        </div>
    </div>
</body>
<script>

    const editConsumableForm = document.querySelector('#editConsumableForm');
    const editDateModified = document.querySelector('#editDateModified');
    const editItemCode = document.querySelector('#editItemCode');
    const editItemDesc = document.querySelector('#editItemDesc');
    const editCategoryType = document.querySelector('#editCategoryType');
    const editMeasurementType = document.querySelector('#editMeasurementType');
    const editSupplier = document.querySelector('#editSupplier');
    const editItemQuantity = document.querySelector('#editItemQuantity');
    const hideItemEditModal = document.querySelector('#hideItemEditModal');

 
    const modalCloser = document.querySelector('#modalCloser');
    const updateItemQty = document.querySelector('#updateItemQty');
    const plusQty = document.querySelector('#plusItemQty');

    let editItemId = 0;
    let currentItem = 0;

    updateItemQty.addEventListener('submit',(e)=>{
        e.preventDefault();

        $.post('../../ajax/updateItemQty.php',{
          updateId : currentItem,
          updateQty : plusQty.value
        }).then(res=>{
           const {success} = JSON.parse(res);
           if(success){
             Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Quantity Updated',
            showConfirmButton: false,
            timer: 1500
            })
            loadAllConsumables();
            modalCloser.click()
           }
           
        })
    })

    const addQuantity = (id)=>{
        currentItem = id;
    }


    const loadAllConsumables = (element)=>{
        element &&  toggleActive(element);
        $('#consumableDisplay').load('../../ajax/supplies.consumable.table.php');
    }

    loadAllConsumables()

      // update
    const editConsumable = (id,code,description,category,measurement,quantity,supplier)=>{
       editDateModified.value = Date.now().toString();
       editItemId = id
       editItemCode.value = code
       editItemDesc.value = description
       editCategoryType.value = category
       editMeasurementType.value = measurement
       editItemQuantity.value = quantity
       editSupplier.value = supplier
   
    }

     editConsumableForm.addEventListener('submit',(e)=>{
            e.preventDefault()
            hideItemEditModal.click()
         
            $.post('',{
                editItemId,
                editDateModified : editDateModified.value,
                editItemCode : editItemCode.value,
                editItemDesc: editItemDesc.value,
                editCategoryType: editCategoryType.value,
                editMeasurementType: editMeasurementType.value,
                editItemQuantity : editItemQuantity.value,
                editSupplier : editSupplier.value
            }).then(res=>{
                console.log(res)
                  Swal.fire(
                'Success!',
                'Item has been Updated.',
                'success'
                    ).then(okay=>{
                       loadAllConsumables()
                })
            })
     })

     // update Status
    const updateItemStatus = (element)=>{
         const itemStatus= element.checked ? 1 : 0 
         const itemId = element.value;
       $.post('',{
          itemId,
          itemStatus
       }).then(ok=>{
          console.log(ok)
          Swal.fire({
            position: 'top-right',
            icon: 'success',
            title: 'Status Updated',
            showConfirmButton: false,
            timer: 1500
            })
       })
    }

      // delete Item
    const deleteConsumable = (id)=>{
       Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
         $.post('',{
             itemDeleteId: id
         }).then((res)=>{
             Swal.fire(
            'Deleted!',
            'Category has been deleted.',
            'success'
            ).then(okay=>{
                loadAllConsumables()
            })
         })
           
        }
    })
    }
</script>

<?php if($added){ ?>
    <script>
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Item Added',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
 <?php include('../../includes/scripts.php')?>
</html>