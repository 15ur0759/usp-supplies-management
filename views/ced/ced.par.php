<?php
 require_once('../../php/dbConnection.php');
  require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');


include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
 
  $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
  $ago =  lastCedRequest($conn);
  $show = false;
  $title = '<i class="fas fa-clipboard-list me-3"></i>PPMP';

   if($notifications > 0){
    $show = true;
  }
  $link = './ced.request.php?type=1';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
   
    <title>Chairperson || Credentials</title>
</head>

<body>
    <?php include('../../modals/parQuantityModal.php')?>
    <?php include('../../modals/editParModal.php')?>
    <div class="admin-container">
        <div class="side-nav">
            <div class="side-nav-header">
                <div class="side-nav-header-img ">

                </div>
                <div class="side-nav-header-text border-bottom">
                    <div class="side-nav-header-text-campus">Urdaneta City Campus</div>
                    <div class="side-nav-header-text-title">Supplies Office</div>
                </div>
               <div class="side-nav-links">
                    <ul>
                        <li><a  class=""  href="./ced.request.php">
                            <span>
                                 <i class="far fa-share-square me-3"></i>Incoming Requests
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a class="nav-links-active"  href="./ced.par.php">
                            <span>
                                 <i class="fas fa-clipboard-list me-3"></i>PPMP
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a  href="./ced.personal.request.php">
                            <span>
                                 <i class="fas fa-external-link-square-alt me-3"></i>Personal Request
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                         <li><a class=""  href="./ced.release.php">
                            <span>
                                 <i class="fas fa-truck-loading me-3"></i>For Release
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="side-nav-links mt-3 border-top">
                    <ul>
                        <li><a href="./ced.credentials.php" ><span><i
                                        class="fas fa-user-cog me-3"></i>Credentials</span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main bg-light">
              <?php include('../../includes/loading.php')?>
             <?php include('../../includes/mainTop.php')?>
            </div>

            <div class="credentials-main-container">
                <div class=" categories-main-right">
                          <div class="main-category-header border-bottom">
                            <div class="main-category-options d-flex align-items-center">
                                <div id="allItem" onclick="toggleActive(this)"  class="main-category-type main-category-active"> <i class="fas fa-check me-1"></i>Requested Items
                               </div>
                                <div onclick="toggleActive(this)"  class="main-category-type "> <i class="fas fa-plus me-1"></i>Add Requested Item
                               </div>
                            </div>
                        </div>

                        <div id="parDisplay" class="main-category-table">
                            <!-- load HEre -->
                        </div>
                    </div>
            </div>
             <?php include('../../includes/footer.php')?>
        </div>
    </div>
</body>
 <?php include('../../includes/par.script.php')?>
 <?php include('../../includes/scripts.php')?>
</html>