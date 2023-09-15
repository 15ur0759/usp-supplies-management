<?php
 require_once('../../controller/campusAdmin.controller.php');
 require_once('../../php/dbConnection.php');
 require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');
 
include('../../includes/session.checker.php');

$failed = false;
$saved = false;
  if(isset($_POST['newDepartmentName']) && isset($_POST['newDeptType'])){
     
    $saved =  addDepartment($conn,$_POST['newDepartmentName'],$_POST['newDeptType']);
    if(!$saved){
        $failed = true;
    }
    unset($_POST['newDepartmentName']);
  }

  if(isset($_POST['editDepartmentName']) && isset($_POST['deptId'])){
     
     updateDepartment($conn,$_POST['editDepartmentName'],$_POST['deptId']);
  }


  $userInfo = $_SESSION['userInfo'];

  $active = 2;

  $departments = getDepartments($conn);

//   while($department = $departments->fetch_assoc()){
//     echo $department['department_name'];
//   }
 
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
    <title>Admin</title>
</head>

<body>
    <div class="admin-container">
        <?php include('../../modals/add.department.modal.php')?>
        <?php include('../../modals/edit.department.modal.php')?>

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
                <div class="main-bottom-title"><i class="fas fa-poll me-3"></i>Departments</div>
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
                                <div class="main-category-type main-category-active"><i class="fas fa-poll me-3"></i>Departments</div>
                                

                            </div>
                            <button class="custom-btn custom-btn-blue" data-toggle="modal" data-target="#addDepartment"> <i class="fas fa-plus me-2 "></i>Add New</button>
                        </div>
                        <div class="main-category-table">
                        <table id="userTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Department Name</th>
                                    <th>Classification</th>
                                    <th class="text-center">Controls</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while($department = $departments->fetch_assoc()){
                                ?>
                                <tr>

                                
                                   
                                     <td><?=$department['department_id']?></td>
                                     <td><?=$department['department_name']?></td>
                                     <td>
                                        <?php if($department['dept_type'] == 1){?>
                                            <span class="fst-italic"> Teaching</span>
                                        <?php }else{?>
                                             <span class="fst-italic"> Non-Teaching</span>
                                        <?php }?>
                                     </td>
                                     <td>
                                        <div class="table-controls text-center d-flex justify-content-center">
                                            <div onclick="editDepartment('<?=$department['department_id']?>','<?=$department['department_name']?>')" data-toggle="modal" data-target="#editDepartment" class="table-control table-control-edit">
                                            <i class="fas fa-edit"></i>
                                            </div>
                                            <div onclick="deleteDepartment(<?=$department['department_id']?>)" class="table-control table-control-delete">
                                            <i class="far fa-trash-alt"></i>
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
    const editDepartment = (id,name)=>{
        document.querySelector('#deptId').value = id
        document.querySelector('#editDeptName').value = name
    }

    const deleteDepartment = (id)=>{
    
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
         $.post('../../ajax/deleteDepartment.php',{
             deleteId: id,
         }).then((res)=>{
            console.log(res)
             Swal.fire(
            'Deleted!',
            'Department has been deleted.',
            'success'
            )
          if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            location.reload()
            }
         })
           
        }
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