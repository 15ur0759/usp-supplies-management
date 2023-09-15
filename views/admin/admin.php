<?php
 require_once('../../controller/campusAdmin.controller.php');
 require_once('../../php/dbConnection.php');
 require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');
include('../../includes/session.checker.php');


  if(isset($_POST['accountId']) && isset($_POST['accountStatus'])){
     echo updateAccountStatus($conn,$_POST['accountId'],$_POST['accountStatus']);
  }


  $userInfo = $_SESSION['userInfo'];

  $active = 1;

  $users = getAllAccounts($conn);
  
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
    <title>Admin</title>
</head>

<body>
    <div class="admin-container">
        <?php include('../../modals/add.user.modal.php')?>
        <div class="side-nav">
            <div class="side-nav-header">
                <div class="side-nav-header-img ">

                </div>
                <div class="side-nav-header-text border-bottom">
                    <div class="side-nav-header-text-campus">Urdaneta City Campus</div>
                    <div class="side-nav-header-text-title">Supplies Office</div>
                </div>
                <?php include('../../includes/adminSideNav.php')?>
                <div class="side-nav-links mt-3 border-top">
                    <ul>
                        <li><a href="./admin.credentials.php"><span><i
                                        class="fas fa-user-cog me-3"></i>Account Credentials</span>
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
                <div class="main-bottom-title"><i class="fas fa-users me-3"></i>Accounts</div>
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
         <div class="main-bottom categories-main">
                <div class="main-section categories-main-section border w-100">
                    <div class=" categories-main-right">
                         <div class="main-category-header border-bottom">
                            <div class="main-category-options d-flex align-items-center">
                                <div class="main-category-type main-category-active"><i class="fas fa-users me-3"></i>Accounts</div>
                                

                            </div>
                            <button class="custom-btn custom-btn-blue" data-toggle="modal" data-target="#addUser"> <i class="fas fa-plus me-2 "></i>Add New</button>
                        </div>
                        <div class="main-category-table">
                        <table id="userTable" class="table table-striped">
                            <thead>
                                <tr>

                                    <!-- <th>#</th> -->
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($user = $users->fetch_assoc()){
                                ?>
                                <tr>

                                
                                    <td><?=$user['lastName']?>, <?=$user['firstName']?></td>
                                     <td><?=$user['department_name']?></td>
                                     <td><?=$user['description']?></td>
                                     <td><?=$user['username']?></td>
                                     <td><?=$user['email']?></td>
                                    <td class="text-center"><div class="form-check form-switch">
                                    <input onchange="changeStatus(this)" name="<?=$user['role']?>" value="<?=$user['id']?>" class="form-check-input" type="checkbox" role="switch"  <?php if($user['is_allowed']){echo 'checked';}?>/>
                                    </div>
                                </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <script>
                        $(document).ready( function () {
                        $('#userTable').DataTable({order:[[2,'asc']]});
                        } );

                        </script>
                        </div>
                    </div>

               </div>
                 
            </div>
             <?php include('../../includes/footer.php')?>
    </div>
</body>

<script>
    
    const changeStatus = (element)=>{
         if(element.name == 1){
            Swal.fire(
            'Error',
            'Cannot Update Satus!',
            'error'
            )
            location.reload()
         }else{
            let status = 0;
            element.checked && (status = 1);
            console.log(status)
            $.post('',{
                accountId : element.value,
                accountStatus : status
            }).then(res=>{
                  console.log(res)
                  Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Status Updated',
            showConfirmButton: false,
            timer: 1500
            })
            })
         }
    }
</script>
<?php 
   if($failed){

?>
   <script>  Swal.fire(
            'Error',
            'The Username you Entered Already exist!',
            'error'
        )</script>
<?php
   $failed = false;
}
 

?>
<?php if($saved){ ?>
    <script>
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'User Added',
            showConfirmButton: false,
            timer: 1500
})
    </script>

    <?php }?>
 <?php include('../../includes/scripts.php')?>

</html>