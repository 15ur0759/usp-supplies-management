<?php
 require_once('../../controller/campusAdmin.controller.php');
 require_once('../../php/dbConnection.php');
 require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');
 
include('../../includes/session.checker.php');

  if(isset($_POST['assignMe']) && isset($_POST['currentDept'])){
   
    $current = getCurrent($conn,$_POST['assignMe']);
    if($current['role'] == 6 || $current['role'] == 3){

       setTemp($conn,$_POST['currentDept'],6);
       setHead($conn,$_POST['assignMe'],3);
    }else{

         setTemp($conn,$_POST['currentDept'],7);
          setHead($conn,$_POST['assignMe'],8);
    }
   
  }

  $userInfo = $_SESSION['userInfo'];

  $active = 3;

  $departments = getAllHeads($conn);

//   while($department = $departments->fetch_assoc()){
//     echo $department['department_name'];
//   }

function headSetter($conn,$department){
  $result = getHead($conn,$department);
  if($result->num_rows > 0){
    $name = $result->fetch_assoc();
    echo $name['firstName'];
    echo " ";
    echo $name['lastName'];
  }else{
    echo '(None)';
   
  }
}
 
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
    <title>Admin</title>
</head>

<body>
    <div class="admin-container">
       <?php include('../../modals/assign.head.modal.php')?>

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
                <div class="main-bottom-title"><i class="fab fa-black-tie me-3"></i>Department Heads</div>
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
                        <div class="main-category-table">
                        <table id="userTable" class="table table-striped">
                            <thead>
                                <tr>

                    
                                   
                                    <th>Department Name</th>
                                    <th>Department Head</th>
                                    <th>Classification</th>
                                    <th class="text-center">Controls</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($department = $departments->fetch_assoc()){
                                   
                                ?>
                                <tr>
                                     <td><?=$department['department_name']?></td>
                                     <td><?php
                                       headSetter($conn,$department['department_id'])
                                     ?></td>
                                     <td>
                                        <?php if($department['dept_type'] == 1){?>
                                            <span class="fst-italic"> Teaching</span>
                                        <?php }else{?>
                                             <span class="fst-italic"> Non-Teaching</span>
                                        <?php }?>
                                     </td>
                                     <td>
                                        <div class="table-controls text-center d-flex justify-content-center">
                                            <div onclick="chosenDept(<?=$department['department_id']?>)" data-toggle="modal" data-target="#assignHead" class="btn-sm btn-primary" style="cursor: pointer">
                                           <i class="fas fa-exchange-alt"></i> Change/Assign
                                            </div>
                                           
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
                        $('#userTable').DataTable();
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


    const chosenDept = (id)=>{
       $.post('../../ajax/setChosenDept.php',{
        chosenDeptId : id
       }).then(res=>{
        document.querySelector('#loadOptions').innerHTML = res;
       })
    }

</script>
<?php 
   if($failed){

?>
   <script>  Swal.fire(
            'Error',
            'The Department name you Entered Already exist!',
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
            title: 'Department Added',
            showConfirmButton: false,
            timer: 1500
})
    </script>

    <?php }?>
 <?php include('../../includes/scripts.php')?>

</html>