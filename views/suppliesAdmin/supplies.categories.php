<?php
 require_once('../../php/dbConnection.php');
 require_once('../../controller/supplies.category.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');


 
include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
$active = 2;

$title = '<i class="fas fa-shapes me-3"></i>Categories';
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
    <?php include('../../modals/addCategory.modal.php')?>
    <?php include('../../modals/editCategory.modal.php')?>

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
                                <div onclick="loadAll(this)" class="main-category-type main-category-active"><i class="fas fa-boxes me-2"></i>All Categories</div>
                                <div onclick="loadConsumables(this)" class="main-category-type "><i class="fas fa-box-open me-2"></i>Consumable</div>
                                <div onclick="loadNonConsumables(this)" class="main-category-type "><i class="fas fa-box me-2"></i>Non-Consumable</div>

                            </div>
                            <button class="custom-btn custom-btn-blue" data-toggle="modal" data-target="#addCategory"> <i class="fas fa-plus me-2 "></i>Add New</button>
                        </div>

                        <div id="categoryDisplay" class="main-category-table">
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
    const mainCategories = document.querySelectorAll('.main-category-type');
    const editForm = document.querySelector('#categoryEditForm');
    const editType = document.querySelector('#categoryEditType');
    const editDesc = document.querySelector('#categoryEditDesc');
    const hideModal = document.querySelector('#editModalDismiss');
   
    let editCategId = 0;
    let reloadType = 0;
   
    const toggleActive = (element)=>{
        resetSelection()
        element.classList.add('main-category-active')
    }

    const resetSelection = ()=>{
        mainCategories.forEach(mc=>{
            mc.classList.remove('main-category-active');
        })
    }
    const loadConsumables = (element)=>{
        element &&  toggleActive(element);
        $('#categoryDisplay').load('../../ajax/consumable.category.php');
    }

    const loadNonConsumables = (element)=>{
        element &&  toggleActive(element);
        $('#categoryDisplay').load('../../ajax/nonConsumable.category.php');
    }

    const loadAll = (element)=>{
         element &&  toggleActive(element);
         $('#categoryDisplay').load('../../ajax/allcategory.table.php');
    }

    loadAll()
   

    // update
    const updateCategory = (id,type,description,isAvailable,rType)=>{
        editCategId = id;
        editType.value = type;
        editDesc.value = description;
       reloadType = rType;
    }

     editForm.addEventListener('submit',(e)=>{
            e.preventDefault()
            hideModal.click()
            // console.log(editCategId)
            // console.log(editType)
            // console.log(editDesc)
            $.post('',{
                editCategId,
                editCategType: editType.value,
                editCategDesc : editDesc.value
            }).then(res=>{
                  Swal.fire(
                'Success!',
                'Category has been Updated.',
                'success'
                    ).then(okay=>{
                        console.log(reloadType)
                        switch(reloadType){
                            case '1' : loadAll()
                            break;
                            case '2' : loadConsumables()
                            break;
                            case '3': loadNonConsumables()
                        }
                })
            })
     })


    // update Status
    const updateCategoryStatus = (element)=>{
         const statusType= element.checked ? 1 : 0 
         const statusId = element.value;
       $.post('',{
          statusId,
          statusType
       }).then(ok=>{
          Swal.fire({
            position: 'top-right',
            icon: 'success',
            title: 'Status Updated',
            showConfirmButton: false,
            timer: 1500
            })
       })
    }


    // delete
    const deleteCategory = (id, type)=>{
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
             deleteId: id
         }).then((res)=>{
             Swal.fire(
            'Deleted!',
            'Category has been deleted.',
            'success'
            ).then(okay=>{
                switch(type){
                    case 1 : loadAll()
                    break;
                    case 2 : loadConsumables()
                    break;
                    case 3: loadNonConsumables()
                }
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
            title: 'Category Added',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
  <?php include('../../includes/scripts.php')?>
</html>