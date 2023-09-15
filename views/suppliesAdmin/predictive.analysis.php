<?php
 require_once('../../php/dbConnection.php');
 require_once('../../controller/supplies.nonConsumable.controller.php');
  require_once('../../controller/notification.controller.php');
 require_once('../../php/sessions.php');

 
$set = false;
$threeYears = 1095;
$oneYear = 365;

 
include('../../includes/session.checker.php');

// $conn->query("DELETE FROM analysis");

$result = analysis($conn);


while($res = $result->fetch_assoc()){
    $id = $res['item_id'];
    $total = 5000 + $res['quantity'];
    // $total = 0;

    $query = $conn->prepare("INSERT INTO analysis (prod_id,an_total) VALUES (?,?)");
    $query->bind_param('ii',$id,$total);

    $query->execute();
    
}

$items = allAnalysis($conn);

function analysis($conn){
  return $conn->query("SELECT * FROM `analysis` RIGHT JOIN items ON analysis.prod_id = items.item_id WHERE analysis.prod_id IS NULL");
}

function allAnalysis($conn){
  return $conn->query("SELECT * FROM `analysis` RIGHT JOIN items ON analysis.prod_id = items.item_id INNER JOIN itemtype ON items.item_type = itemtype.id INNER JOIN suppliers ON items.supplier = suppliers.supplier_id INNER JOIN categories ON items.item_category = categories.cat_id INNER JOIN measurement ON measurement.id = items.measurement");
}

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
$active = 11;
 
$title = '<i class="fas fa-chart-pie me-3"></i>Predictive Analysis';
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
              <!-- <?php include('../../includes/loading.php')?> -->
              <?php include('../../includes/mainTop.php')?>
            </div>

            <div class="main-bottom categories-main">
                <div class="main-section categories-main-section border w-100">
                   
                    <div class="p-5 overflow-auto" id="nonConsumableDisplay">
                     
            <table id="nonConsumableTable" class="table table-bordered">
                <thead>
                    <tr>
                    <th>Item Code</th>
                    <th>Item Type</th>
                    <th>Description</th>
                    <!-- <th>Category</th>
                    <th>Supplier</th> -->
                    <th>Stocks Qty</th>
                    <th>Unit/Measurement</th>
                    <th>Total Released</th>
                    <th>Average Release / Day</th>
                    <th>Available Stock / Day</th>
                    <th>Predictive Stock Needed this Year</th>
                    <th>Remarks</th>

                    </tr>
                </thead>
                <tbody>
                        <?php
                        while($item = $items->fetch_assoc()){
                        ?>
                        <tr>


                        <td><?=$item['item_code']?></td>
                        <td><?=$item['type_description']?></td>
                        <td><?=$item['item_description']?></td>
                        <td ><?=$item['quantity']?></td>
                        <td><?=$item['measure_description']?></td>
                        <td><?=$item['an_total']?></td>
                        <td><?=number_format($item['an_total'] / $threeYears,2)?></td>
                        <td><?=number_format($item['quantity'] / $oneYear,2)?></td>
                        <td><?=number_format(($item['an_total'] / $threeYears) * $oneYear,2)?></td>
                      
                        <td>
                            <?php
                              $average = number_format(($item['an_total'] / $threeYears),2);
                              $predict = $item['quantity'] - $average;

                              if($predict > 0){
                                echo "<div class='p-1 bg-success text-light rounded' style='font-size: .7rem; width:100px;'>+".$predict." on Stocks/Day -Sufficient</div>";
                              }else{
                                echo "<div class='p-1 bg-danger text-light rounded' style='font-size: .7rem; width:100px;'> ".$predict."on Stocks/Day Insufficient</div>";
                              }
                             ?>
                        </td>
                        </tr>
                        <?php
                        }
                        ?>
                </tbody>
            </table>


                    </div>
               </div>
                 
            </div>
             <?php include('../../includes/footer.php')?>
        </div>
    </div>
</body>

<script>
$(document).ready( function () {
    $('#nonConsumableTable').DataTable({order:[[2,'asc']]});
} );

</script>
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

    // loadAllNonConsumables()
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