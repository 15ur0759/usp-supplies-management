<?php
 require_once('../../php/dbConnection.php');
 require_once('../../controller/supplies.nonConsumable.controller.php');
  require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');

 
$set = false;

 
include('../../includes/session.checker.php');

if(isset($_POST['limitQty'])){
   $set = updateLimit($conn,$_POST['limitQty']);
}

$currentLimit = getMinimum($conn);

function getMinimum($conn){
    $result = $conn->query("SELECT `minimum` FROM critical");

    $limit = $result->fetch_assoc();
    return $limit['minimum'];
}

function updateLimit($conn,$newLimit){

    $query = $conn->prepare("UPDATE critical SET minimum = ? ");
    $query->bind_param('i',$newLimit);
    return $query->execute();
}

$userInfo = $_SESSION['userInfo'];
$active = 10;
 
$title = '<i class="fas fa-exclamation-triangle me-3"></i>Critical Stocks';
 $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
   $ago = lastSuppliesRequest($conn);
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
   
    <title>Supplies Admin</title>
</head>

<body>
    
     
      <?php include('../../modals/updateQtyModal.php')?>
      <?php include('../../modals/limit.modal.php')?>
 
    <div class="admin-container">
       
           <?php include('../../includes/suppliesSideNav.php')?>
       
        <div class="main bg-light">
              <?php include('../../includes/loading.php')?>
              <?php include('../../includes/mainTop.php')?>
            </div>

            <div class="main-bottom categories-main">
                <div class="main-section categories-main-section border w-100">
                   
                    <div class=" categories-main-right" id="nonConsumableDisplay">
                     
                    <!--  -->
                    </div>
               </div>
                 
            </div>
             <?php include('../../includes/footer.php')?>
        </div>
    </div>
</body>
<script>

   
    const modalCloser = document.querySelector('#modalCloser');
    const updateItemQty = document.querySelector('#updateItemQty');
    const plusQty = document.querySelector('#plusItemQty');

    let editItemId = 0;
    let currentItem = 0;

    updateItemQty.addEventListener('submit',(e)=>{
        e.preventDefault();

        $.post('../../ajax/updateItemQty.php',{
          updateId : currentItem,
          updateQty : plusQty.value

        }).then(res=>{
           const {success} = JSON.parse(res);
           if(success){
             Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Quantity Updated',
            showConfirmButton: false,
            timer: 1500
            })
            loadAllNonConsumables();
            modalCloser.click()
           }
           
        })
    })

    const addQuantity = (id)=>{
        currentItem = id;
    }

    const loadAllNonConsumables = (element)=>{
        element &&  toggleActive(element);
        $('#nonConsumableDisplay').load('../../ajax/critical.table.php');
    }

    loadAllNonConsumables()
</script>

<?php if($set){ ?>
    <script>
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Limit Updated',
            showConfirmButton: false,
            timer: 1500
})
    </script>
<?php } ?>
 <?php include('../../includes/scripts.php')?>
</html>