<?php
 require_once('../../php/dbConnection.php');
  require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
  require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');


include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
  
$showPending = 0;

if(isset($_GET['query'])){
 $showPending = 1;
}

  $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
  $ago = lastDeanRequest($conn);
  $show = false;
  $title = ' <i class="far fa-share-square me-3"></i>Incoming Requests';

   if($notifications > 0){
    $show = true;
  }
 $link = './dean.request.php?query=1';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
    <?php include('../../modals/items.modal.php')?>
    <title>Instructor || Credentials</title>
</head>

<body>
   
      <?php include('../../modals/changeDeanStatus.modal.php')?>


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
                        <li><a class="nav-links-active"  href="./dean.request.php">
                            <span>
                                 <i class="far fa-share-square me-3"></i>Incoming Requests
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a class=""  href="./dean.par.php">
                            <span>
                                 <i class="fas fa-clipboard-list me-3"></i>PPMP
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                        <li><a class=""  href="./dean.personal.request.php">
                            <span>
                                 <i class="fas fa-external-link-square-alt me-3"></i>Personal Request
                            </span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </a>
                        </li>
                         <li><a class=""  href="./dean.release.php">
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
                        <li><a href="./dean.credentials.php" ><span><i
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
                                <div  class="main-category-type main-category-active"><i class="fas fa-chart-line me-2"></i>All Requests</div>
                                <!-- <div  class="main-category-type "><i class="fas fa-check-double me-2"></i>Approved</div>
                                <div  class="main-category-type "><i class="fas fa-hourglass-half me-2"></i>Pending</div>
                                <div  class="main-category-type "><i class="fas fa-ban me-2"></i>Disapproved</div> -->

                            </div>
                            <!-- <button class="custom-btn custom-btn-blue" data-toggle="modal" data-target="#reqOptions"> <i class="fas fa-plus me-2 "></i>New Request</button> -->
                        </div>

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

      const approveRequest= (id) =>{
        
         Swal.fire({
            title: 'Confirm?',
            text: "Approve Request!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.post('../../ajax/approve.request.php',{
                    requestId : id,
                    requestRole : 4
                }).then(response=>{
                    console.log(response)
                    const {success} = JSON.parse(response);
                    if(success){
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Status Updated',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    loadAll()
                    }else{
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Insufficient Items!',
                        })
                    }
                })
            }
            })
      }
      
      const setCurrent = (id)=>{
         document.querySelector('#currentRequest').value = id
      }

      const loadAll = ()=>{
         $('#requestDisplay').load('../../ajax/dean.request.php?type=<?=$showPending?>');
    }

    loadAll()


 </script>
   <?php if($updated){ ?>
    <script>
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Status Updated',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
 <?php include('../../includes/scripts.php')?>
</html>