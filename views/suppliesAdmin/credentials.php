<?php
 require_once('../../php/dbConnection.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');


 
include('../../includes/session.checker.php');

$userInfo = $_SESSION['userInfo'];
$active = 8;

$title = '<i class="fas fa-shapes me-3"></i>Categories';
 $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
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
   
    <title>Supplies Admin || Credentials</title>
</head>

<body>
      <?php include('../../modals/updatePassword.modal.php')?>
    <div class="admin-container">
         <?php include('../../includes/suppliesSideNav.php')?>
        <div class="main bg-light">
           <?php include('../../includes/loading.php')?>
            <?php include('../../includes/mainTop.php')?>
            </div>

            <div class="credentials-main-container">
                  <div class="credentials-svg1">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fcb900" fill-opacity="1" d="M0,96L0,96L40,96L40,32L80,32L80,64L120,64L120,96L160,96L160,192L200,192L200,288L240,288L240,192L280,192L280,128L320,128L320,32L360,32L360,160L400,160L400,128L440,128L440,32L480,32L480,256L520,256L520,288L560,288L560,32L600,32L600,160L640,160L640,64L680,64L680,160L720,160L720,288L760,288L760,288L800,288L800,256L840,256L840,64L880,64L880,32L920,32L920,192L960,192L960,192L1000,192L1000,32L1040,32L1040,256L1080,256L1080,256L1120,256L1120,128L1160,128L1160,96L1200,96L1200,64L1240,64L1240,128L1280,128L1280,32L1320,32L1320,128L1360,128L1360,0L1400,0L1400,64L1440,64L1440,320L1400,320L1400,320L1360,320L1360,320L1320,320L1320,320L1280,320L1280,320L1240,320L1240,320L1200,320L1200,320L1160,320L1160,320L1120,320L1120,320L1080,320L1080,320L1040,320L1040,320L1000,320L1000,320L960,320L960,320L920,320L920,320L880,320L880,320L840,320L840,320L800,320L800,320L760,320L760,320L720,320L720,320L680,320L680,320L640,320L640,320L600,320L600,320L560,320L560,320L520,320L520,320L480,320L480,320L440,320L440,320L400,320L400,320L360,320L360,320L320,320L320,320L280,320L280,320L240,320L240,320L200,320L200,320L160,320L160,320L120,320L120,320L80,320L80,320L40,320L40,320L0,320L0,320Z"></path></svg>
                  </div>
                  <div class="credentials-svg1">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#4848ff" fill-opacity="1" d="M0,192L0,64L80,64L80,192L160,192L160,32L240,32L240,192L320,192L320,128L400,128L400,192L480,192L480,128L560,128L560,64L640,64L640,256L720,256L720,128L800,128L800,96L880,96L880,256L960,256L960,256L1040,256L1040,288L1120,288L1120,32L1200,32L1200,320L1280,320L1280,64L1360,64L1360,64L1440,64L1440,320L1360,320L1360,320L1280,320L1280,320L1200,320L1200,320L1120,320L1120,320L1040,320L1040,320L960,320L960,320L880,320L880,320L800,320L800,320L720,320L720,320L640,320L640,320L560,320L560,320L480,320L480,320L400,320L400,320L320,320L320,320L240,320L240,320L160,320L160,320L80,320L80,320L0,320L0,320Z"></path></svg>
                  </div>
                  <div class="credentials-svg2">
                 <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fcb900" fill-opacity="1" d="M0,96L0,192L65.5,192L65.5,224L130.9,224L130.9,288L196.4,288L196.4,256L261.8,256L261.8,256L327.3,256L327.3,96L392.7,96L392.7,256L458.2,256L458.2,32L523.6,32L523.6,32L589.1,32L589.1,160L654.5,160L654.5,192L720,192L720,160L785.5,160L785.5,256L850.9,256L850.9,224L916.4,224L916.4,256L981.8,256L981.8,224L1047.3,224L1047.3,128L1112.7,128L1112.7,0L1178.2,0L1178.2,32L1243.6,32L1243.6,256L1309.1,256L1309.1,96L1374.5,96L1374.5,288L1440,288L1440,0L1374.5,0L1374.5,0L1309.1,0L1309.1,0L1243.6,0L1243.6,0L1178.2,0L1178.2,0L1112.7,0L1112.7,0L1047.3,0L1047.3,0L981.8,0L981.8,0L916.4,0L916.4,0L850.9,0L850.9,0L785.5,0L785.5,0L720,0L720,0L654.5,0L654.5,0L589.1,0L589.1,0L523.6,0L523.6,0L458.2,0L458.2,0L392.7,0L392.7,0L327.3,0L327.3,0L261.8,0L261.8,0L196.4,0L196.4,0L130.9,0L130.9,0L65.5,0L65.5,0L0,0L0,0Z"></path></svg> -->
                  </div>

                <div class="credentials-main my-shadow">
                
                   <div class="credentials-form-img">
                       <img src="../../assets/images/psu-logo.png" alt="">
                       <div class="credentials-user-type">
                        <?=$userInfo['description']?>
                       </div>
                   </div>
                  <form method="Post">
                     <div class="form-group">
                        <label>Username</label>
                        <input value="<?=$userInfo['username']?>" type="text" class="form-control" readonly>
                     </div>
                     <div class="form-group">
                        <label>First Name</label>
                        <input name="firstName" minlength="2" required value="<?=$userInfo['firstName']?>" type="text" class="form-control">
                     </div>
                     <div class="form-group">
                        <label>Last Name</label>
                        <input name="lastName" minlength="2" required value="<?=$userInfo['lastName']?>" type="text" class="form-control">
                     </div>
                     <div class="form-group">
                       <button type="submit" class="btn-sm btn-block btn-primary border-0">Update</button>
                     </div>
                    
                     <div class="update-password" data-toggle="modal" data-target="#updatePassword"> <span><i class="fas fa-unlock-alt me-2"></i>Update Password</span></div>
                  </form>
                </div>
                  <!-- <div class="credentials-left "></div>
                  <div class="credentials-right bg-primary"></div> -->
            </div>
             <!-- <?php include('../../includes/footer.php')?> -->
        </div>
    </div>
</body>
<?php 
   if($updateFailed){

?>
   <script>  Swal.fire(
            'Error',
            'Unable to update Password',
            'error'
        )</script>
<?php
   $updateFailed = false;
}
?>
  <?php if($updated){ ?>
    <script>
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Password Updated',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
<?php 
   if($infoUpdateFailed){

?>
   <script>  Swal.fire(
            'Error',
            'Unable to updated Information',
            'error'
        )</script>
<?php } ?>
  <?php if($infoUpdated){ ?>
    <script>
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Information Updated',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
 <?php include('../../includes/scripts.php')?>
</html>