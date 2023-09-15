<?php
 require_once('../../php/dbConnection.php');
  require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
 require_once('../../php/sessions.php');


include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
   
    <title>Non-Teaching || Requests</title>
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
                        <li><a  class=""  href="./nonTeachingNewRequest.php">
                            <span>
                                 <i class="far fa-share-square me-3"></i> New Request
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a  class=""  href="./nonTeaching.request.php">
                            <span>
                                <i class="fas fa-clipboard-list me-3"></i>My Request
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a  class="nav-links-active"  href="./nonTeaching.release.php">
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
                        <li><a href="./nonTeaching.credentials.php"><span><i
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
            <div class="main-top my-shadow">
                <div class="main-bottom-title">
                      <i class="fas fa-truck-loading me-3"></i>For Release
                </div>
                <div class="clock" style="font-weight: bold; letter-spacing: 1px;">
                    <span><i class="fas fa-calendar-alt me-2 text-primary"></i></span>
                    <span id="clock"></span>
                </div>

                <script>
                    var clock = document.querySelector('#clock');
                    setInterval(()=>{
                    const time = 
                    clock.innerText = new Date().toString().slice(0,25);
                    },1000)
                </script>
                <div class="main-top-right">
                    <div class="main-profile">
                        <img src="../../assets/images/admin-icon.jpg" alt="" class="main-profile-img shadow-4">
                        <div class="ms-2">
                           <div class="main-profile-name"><?=$userInfo['firstName'].' '. $userInfo['lastName']?></div>
                            <div class="main-profile-role"><?=$userInfo['description']?></div>

                        </div>
                    </div>
                     <form action="" method="post">
                        <div class="main-profile-logout"><button class="log-out-btn" name="logout" type="submit">Logout<i class="ms-2 fas fa-sign-out-alt"></i></button>
                    </form>
                    </div>
                </div>
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