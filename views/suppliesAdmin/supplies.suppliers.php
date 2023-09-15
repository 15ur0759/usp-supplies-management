<?php
 require_once('../../php/dbConnection.php');
 require_once('../../php/now.php');
 require_once('../../controller/supplier.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');


 
include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
$active = 5;

$title = '<i class="fas fa-truck me-3"></i>Suppliers';
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
   
    <title>Supplies Admin|| Suppliers</title>
</head>

<body>
     <?php include('../../modals/addSupplier.modal.php')?>
     <?php include('../../modals/suppliers.edit.php')?>
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
                                <div onclick="" class="main-category-type main-category-active"><i class="fas fa-truck me-2"></i>All Suppliers</div>
                                <!-- <div onclick="" class="main-category-type "><i class="fas fa-reply me-2"></i>Available Items</div>
                                <div onclick="" class="main-category-type "><i class="fas fa-exclamation-triangle me-2"></i>Unavailable Items</div> -->

                            </div>
                            <button class="custom-btn custom-btn-blue" data-toggle="modal" data-target="#addSupplier"> <i class="fas fa-plus me-2 "></i>Add New</button>
                        </div>

                        <div id="supplierDisplay" class="main-category-table">
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

    const loadSuppliers = (element)=>{
         $('#supplierDisplay').load('../../ajax/supplier.table.php');
    }

    loadSuppliers()


     // update Status
    const updateSupplierStatus = (element)=>{
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


    let name = '';
    let currentId = 0;
    let currentOwner = 0;
    var supplierName = document.querySelector('#supplierEditDesc');
    

    // edit
     const updateSupplier = (id,currentName,owner)=>{
        name = currentName;
        currentId = id;
        currentOwner = owner;
        supplierName.value = currentName;
    }

     document.querySelector('#supplierEditForm').addEventListener('submit',(e)=>{
            e.preventDefault()
            
            // console.log(editCategId)
            // console.log(editType)
            // console.log(editDesc)
            $.post('',{
               name,
               newName: supplierName.value,
               owner: currentOwner,
               currentId
            }).then(res=>{
               
                  Swal.fire(
                'Success!',
                'Supplier has been Updated.',
                'success'
                    ).then(okay=>{
                     loadSuppliers()
                     document.querySelector('#editModalDismiss').click()
                })
            })
     })

      // delete
    const deleteSupplier = (id,supplier,owner)=>{
    
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
             deleteId: id,
             supplier,
             owner
         }).then((res)=>{
            console.log(res)
             Swal.fire(
            'Deleted!',
            'Supplier has been deleted.',
            'success'
            )
            loadSuppliers()
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
            title: 'Supplier Added',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
 <?php include('../../includes/scripts.php')?>
</html>