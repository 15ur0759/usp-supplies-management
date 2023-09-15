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
   $ago = lastChairRequest($conn,$userInfo['department']);
  $show = false;
  $title = '<i class="fas fa-truck-loading me-3"></i>For Release';

   if($notifications > 0){
    $show = true;
  }
   $link = './chairperson.request.php?query=1';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
   
    <title>Instructor || Requests</title>
</head>

<body>
      <?php include('../../modals/reqOptions.modal.php')?>
      <?php include('../../modals/reqConsumable.modal.php')?>
      <?php include('../../modals/reqNonConsumable.modal.php')?>
      <?php include('../../modals/items.modal.php')?>


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
                        <li><a class=""  href="./chairperson.request.php">
                            <span>
                                 <i class="far fa-share-square me-3"></i>Incoming Requests
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a class=""  href="./chairperson.par.php">
                            <span>
                                 <i class="fas fa-clipboard-list me-3"></i>PPMP
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a class=""  href="./chair.personal.request.php">
                            <span>
                                 <i class="fas fa-external-link-square-alt me-3"></i>Personal Request
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                         <li><a class="nav-links-active"  href="./chair.release.php">
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
                        <li><a href="./chairperson.credentials.php"><span><i
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
                         

                        <div id="requestDisplay" class="main-category-table">
                            <!-- load HEre -->

                        </div>
                    </div>
            </div>
             <?php include('../../includes/footer.php')?>
        </div>
    </div>
</body>
 <script>
     const mainCategories = document.querySelectorAll('.main-category-type');

      const toggleActive = (element)=>{
        resetSelection()
        element.classList.add('main-category-active')
    }

    const resetSelection = ()=>{
        mainCategories.forEach(mc=>{
            mc.classList.remove('main-category-active');
        })
    }
      const loadAll = (element)=>{
         element &&  toggleActive(element);
         $('#requestDisplay').load('../../ajax/request.table.php');
    }

     const loadRelease = (element)=>{
         element &&  toggleActive(element);
         $('#requestDisplay').load('../../ajax/instructorRelease.php');
        }

      const loadRequestForm = (element)=>{
         element &&  toggleActive(element);
         $('#requestDisplay').load('../../ajax/newRequest.php');
    }

    loadRelease()

    // request-form-script
   


 </script>
   <?php if($added){ ?>
    <script>
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Request Submitted',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
 <?php include('../../includes/scripts.php')?>
</html>