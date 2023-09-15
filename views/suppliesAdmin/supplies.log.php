<?php
 require_once('../../php/dbConnection.php');
 require_once('../../controller/supplies.consumable.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');


 
include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
$active = 6;

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
   
    <title>Supplies Admin|| Suppliers</title>
</head>

<body>
     <?php include('../../modals/addConsumable.modal.php')?>
     <?php include('../../modals/editConsumable.modal.php')?>
    <div class="admin-container">
          <?php include('../../includes/suppliesSideNav.php')?>
        <div class="main bg-light">
              <?php include('../../includes/loading.php')?>
            <?php include('../../includes/mainTop.php')?>
            </div>

            <div class="main-bottom categories-main">
                <div class="main-section categories-main-section border w-100">
                   <div class="main-section categories-main-section border w-100">
                    <div class=" categories-main-right">
                          <div class="main-category-header border-bottom">
                            <div class="main-category-options d-flex align-items-center">
                                <div onclick="" class="main-category-type main-category-active"><i class="fas fa-book-reader me-2"></i>Activity Logs</div>
                                <!-- <div onclick="" class="main-category-type "><i class="fas fa-reply me-2"></i>Available Items</div>
                                <div onclick="" class="main-category-type "><i class="fas fa-exclamation-triangle me-2"></i>Unavailable Items</div> -->

                            </div>
                           
                        </div>

                        <div id="logsDisplay" class="main-category-table">
                            <!-- load HEre -->
                        </div>
                    </div>

               </div>
               </div>
                 
            </div>
             <?php include('../../includes/footer.php')?>
        </div>
    </div>
</body>
<script>
    const loadLogs = (element)=>{
         $('#logsDisplay').load('../../ajax/logs.table.php');
    }

    loadLogs()

  
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