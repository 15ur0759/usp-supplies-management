<?php
 require_once('../../php/dbConnection.php');
 require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');

 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');

include('../../includes/session.checker.php');

  $userInfo = $_SESSION['userInfo'];
  $active = 9;


  $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
    $ago = lastSuppliesRequest($conn);
  $show = false;
  $title = ' <i class="fas fa-share-square me-3"></i>PPMP Requests';

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
      <?php include('../../modals/changeSuppliesStatus.modal.php')?>
       <?php include('../../modals/items.par.modal.php')?>
    <div class="admin-container">
         <?php include('../../includes/suppliesSideNav.php')?>
        <div class="main bg-light">
             <?php include('../../includes/loading.php')?>
              <?php include('../../includes/mainTop.php')?>
            </div>

             <div class="credentials-main-container">
                
                <div class="categories-main-right position-relative">
                   
                          <div class="main-category-header border-bottom ">
                           
                            <div class="main-category-options d-flex align-items-center">
                                <div onclick="loadAll(this)"  class="main-category-type main-category-active"><i class="fas fa-chart-line me-2"></i>All Requests</div>
                                <div onclick="loadRelease(this)"  class="main-category-type "><i class="fas fa-check-double me-2"></i>Approved</div>
                                <div onclick="loadReleased(this)"  class="main-category-type "><i class="fas fa-truck-loading me-2"></i>Released</div>
                                <!-- <div onclick="loadDisapproved(this)"  class="main-category-type "><i class="fas fa-times me-2"></i>DisApproved</div> -->
                                <!-- <div  class="main-category-type "><i class="fas fa-hourglass-half me-2"></i>Pending</div>
                                <div  class="main-category-type "><i class="fas fa-ban me-2"></i>Disapproved</div> -->

                            </div>
                            <!-- <button class="custom-btn custom-btn-blue" data-toggle="modal" data-target="#reqOptions"> <i class="fas fa-plus me-2 "></i>New Request</button> -->
                        </div>
                        <div id="filter" class="form-group px-4" style="padding-top:1em; width:300px;">
                            <!-- <label for="">Filter</label>
                        <select onchange="reloadAll(this.value)" class="form-control">
                            <option value="0" selected>All</option>
                            <option value="2">Approved</option>
                            <option value="3">Disapproved</option> -->
                        </select>
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

    

 const approvePar = (id)=>{
       
        Swal.fire({
            title: 'Please Confirm?',
            text: "Set As Approved?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if(result.isConfirmed){
                $.post('../../ajax/changeParStatus.php',{
                parOwner: id,
                parStatusType: 3
                }).then(res=>{
                    const {success} = JSON.parse(res);
                    console.log(success)
                    if(success){
                        loadAll();
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Request Approved!',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    }

            })

            }
        })
 }
   
 const disApprovePar = (id)=>{
    Swal.fire({
            title: 'Please Confirm?',
            text: "Disapprove this Request?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if(result.isConfirmed){
                $.post('../../ajax/changeParStatus.php',{
                parOwner: id,
                parStatusType: 4
                }).then(res=>{
                    const {success} = JSON.parse(res);
                    console.log(success)
                    if(success){
                        loadAll();
                        Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Request DisApproved!',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    }

            })

            }
        })
 }
   
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

      const setCurrent = (id)=>{
         document.querySelector('#currentRequest').value = id
      }

      const loadRelease = (element)=>{
         element &&  toggleActive(element);
         document.querySelector('#filter').classList.add('d-none')
         $('#requestDisplay').load('../../ajax/par.release.php');
        }

      const loadReleased = (element)=>{
         element &&  toggleActive(element);
         document.querySelector('#filter').classList.add('d-none')
         $('#requestDisplay').load('../../ajax/par.released.php');
        }

      const loadDisapproved = (element)=>{
         element &&  toggleActive(element);
         document.querySelector('#filter').classList.add('d-none')
         $('#requestDisplay').load('../../ajax/par.disapproved.php');
        }

      const loadAll = (element)=>{
         document.querySelector('#filter').classList.remove('d-none')
         element &&  toggleActive(element);
         $('#requestDisplay').load('../../ajax/supplies.par.requests.php?type=0');
        }

      const reloadAll = (type)=>{
        document.querySelector('#filter').classList.remove('d-none')
         $('#requestDisplay').load(`../../ajax/supplies.par.requests.php?type=${type}`);
        }

    loadAll()

 </script>
 <script>
      var setAsReleased = (id)=>{
       
        Swal.fire({
                title: 'Please Confirm?',
                text: "Set this Request as Released?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
                }).then((result) => {
                  if(result.isConfirmed){
                     $.post('../../ajax/updateClaim.php',{
                        requestId: id
                     }).then(res=>{
                        loadRelease();
                        Swal.fire({
                             position: 'center',
                             icon: 'success',
                             title: 'Request Sent!',
                             showConfirmButton: false,
                             timer: 1500
                             })

                     })
                      
                  }
            })
      }
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