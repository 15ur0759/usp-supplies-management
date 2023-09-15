<?php
 require_once('../../php/dbConnection.php');
 require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');

 

 
include('../../includes/session.checker.php');

  $userInfo = $_SESSION['userInfo'];
  $active = 12;


  $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
    $ago = lastSuppliesRequest($conn);
  $show = false;
  $title = '<i class="fas fa-file-invoice me-3"></i>Reports';

   if($notifications > 0){
    $show = true;
  }
  $link = './supplies.requests.php?query=1';

$viewRequests = false;
$viewRelease = false;

  if(isset($_POST['rangeFrom']) && isset($_POST['rangeTo'])){
    $_SESSION['reportFrom']= $_POST['rangeFrom'];
    $_SESSION['reportTo']= $_POST['rangeTo'];
    $viewRequests = true;
    $viewRelease = false;
  }
  if(isset($_POST['releaseFrom']) && isset($_POST['releaseTo'])){
    $_SESSION['releaseFrom']= $_POST['releaseFrom'];
    $_SESSION['releaseTo']= $_POST['releaseTo'];
    $viewRelease = true;
    $viewRequests = false;
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
    <link rel="stylesheet" href="../../assets/styles/report.css">
    <title>Supplies Admin</title>
</head>

<body>
    <div class="admin-container">
         
         <?php include('../../modals/reportRange.modal.php')?>
         <?php include('../../modals/releaseRange.modal.php')?>
         <?php include('../../includes/suppliesSideNav.php')?>
        <div class="main bg-light">
             <?php include('../../includes/loading.php')?>
              <?php include('../../includes/mainTop.php')?>
            </div>

             <div class="credentials-main-container">
                
                <div class="categories-main-right position-relative">
                        <div class="main-category-table report-container">
                          <div data-toggle='modal' data-target='#reportRange' onclick="" class="report-card">
                                <div class="report-content">
                                    <i class="far fa-share-square"></i>
                                    <br>
                                    Requests Reports
                                </div>
                          </div>

                          <div data-toggle='modal' data-target='#releaseRange' class="report-card">
                                <div class="report-content">
                                    <i class="fas fa-truck-loading"></i>
                                    <br>
                                    Released Items Reports
                                </div>
                          </div>
                          <div onclick="window.open('../../reports/consumable.reports.php', '_blank');" class="report-card">
                                <div class="report-content">
                                    <i class="fas fa-box"></i>
                                    <br>
                                    Consumable Items
                                </div>
                          </div>
                          <div onclick="window.open('../../reports/non-consumable.reports.php', '_blank');" class="report-card">
                                <div class="report-content">
                                    <i class="fas fa-box"></i>
                                    <br>
                                    Non-Consumable Items
                                </div>
                          </div>
                        </div>
                    </div>
            </div>
             <?php include('../../includes/footer.php')?>
        </div>
    </div>
</body>
<?php
  if($viewRequests){
?>
<script>
    window.open('../../reports/requests.reports.php', '_blank');
</script>
<?php }?>
<?php
  if($viewRelease){
?>
<script>
    window.open('../../reports/released.reports.php', '_blank')
</script>
<?php }?>
 <?php include('../../includes/scripts.php')?>

</html>