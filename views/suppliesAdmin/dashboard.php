<?php
 require_once('../../php/dbConnection.php');
 require_once('../../php/now.php');
 require_once('../../controller/credentials.controller.php');
 require_once('../../controller/request.controller.php');
 require_once('../../controller/notification.controller.php');
 require_once('../../controller/dashboard.controller.php');
 require_once('../../php/sessions.php');

 
include('../../includes/session.checker.php');



  $userInfo = $_SESSION['userInfo'];
  $active = 7;

  // chart
  $consumables = getAllConsumableItems($conn);
  $nonConsumables = getAllNonConsumableItems($conn);
  $requests = allRequests($conn)->fetch_assoc();
  $summary = mostRequested($conn);
  $items = $summary[0];
  $totals = $summary[1];
   
  $departments = allDepartments($conn);
  $departs = allDepartments($conn);


  
  // notification
  $notifications = getAllPendingNotifications($conn,$userInfo['role'],$userInfo['department']);
  $ago = lastSuppliesRequest($conn);
  $show = false;
  $title = '<i class="far fa-chart-bar me-3"></i>Dashboard';
  
  if($notifications > 0){
    $show = true;
  }
    $link = './supplies.requests.php?query=1';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../../includes/header.php')?>
    <link rel="stylesheet" href="../../assets/styles/dashboard.css?ne">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Supplies Admin</title>
</head>

<body>
      <?php include('../../modals/changeSuppliesStatus.modal.php')?>
       <?php include('../../modals/items.modal.php')?>
    <div class="admin-container">
         <?php include('../../includes/suppliesSideNav.php')?>

        <div class="main" style="background:white;">
             <!-- <?php include('../../includes/loading.php')?> -->

            <?php include('../../includes/mainTop.php')?>
            </div>

             <div class="credentials-main-contain" id="dashboardDisplay" >
                
                <div class="hidden-section d-none">
                    <?php
                       while($consumable = $consumables->fetch_assoc()){
                           
                    ?>
                        <input class="consumables" type="text" readonly name="<?=$consumable['item_description'];?>" value="<?=$consumable['quantity'];?>">
                    <?php
                       }
                    ?>
                    <?php
                       while($nonConsumable = $nonConsumables->fetch_assoc()){
                           
                    ?>
                        <input class="nonConsumables" type="text" readonly name="<?=$nonConsumable['item_description'];?>" value="<?=$nonConsumable['quantity'];?>">
                    <?php
                       }
                    ?>
                    <?php
                     for($i = 0; $i < sizeof($items); $i++){
                    ?>
                        <input class="totals" type="text" readonly name="<?=$items[$i];?>" value="<?=$totals[$i];?>">
                    <?php
                       }
                    ?>
                <input class="conReq" type="text" readonly name="<?=$requests['consumables'];?>" value="<?=$requests['consumables'];?>">
                <input class="nonReq" type="text" readonly name="<?=$requests['nonConsumables'];?>" value="<?=$requests['nonConsumables'];?>">
                </div>
                <div class="dashboard-container border">
                    <!-- <div class="dashboard-links">
                        <div class="dashboard-link dashboard-link-active">Items Chart</div>
                        <div class="dashboard-link">Requests Chart</div>
                    </div> -->
                    <div class="dashboard-main">
                        <div class="dashboard-box">
                           <div class="dashboard-title">Consumable Items</div>
                            <canvas id="myChart">
      
                            </canvas>
                        </div>
                        <div class="dashboard-box">
                          <div class="dashboard-title">Non Consumable Items</div>
                            <canvas id="myChart2">
      
                            </canvas>
                        </div>
                        <div class="dashboard-box box-full">
                          <div class="dashboard-title">Requested Items</div>
                            <canvas id="myChart4">
      
                            </canvas>
                        </div>
                        <div class="dashboard-box box-full">
                          <div class="dashboard-title">Requests Comparison</div>
                            <canvas id="myChart3">
      
                            </canvas>
                        </div>
                        <div class="department-charts  w-100">
                           <div class="dept-char-title p-2 h6 px-4 bg-primary text-light w-100 ms-2">
                              Departments Request Chart
                           </div>
                        </div>
                        <div class="dashboard-box box-full">
                          <?php
                            while($depart = $departs->fetch_assoc()){

                            
                          ?>
                          <input type="hidden" name="" class="allDeptsValue" value="<?php echo departmentReleaseCounter($conn,$depart['department_id'])?>">
                          <input type="hidden" name="" class="allDeps" value="<?=$depart['department_name'];?>">
                          <?php }?>
                          <div class="dashboard-title">All Department Requests</div>
                            <canvas id="myChart6">

                            </canvas>
                        </div>
                      <?php
                        while($department = $departments->fetch_assoc()){
                      ?>
                        <div class="dashboard-box box-full">
                          <?php 
                          $items = allItems($conn);
                          while($item = $items->fetch_assoc()){
                            
                            ?>
                            <input value="<?=$item['item_description']?>" type="hidden" class="label<?=$department['department_id']?>">
                            
                            <input value="<?=releaseCounter($conn,$item['item_id'],$department['department_id'])?>" type="hidden" class="value<?=$department['department_id']?>">
                          <?php }?>
                          <div class="dashboard-title"><?=$department['department_name']?></div>
                            <canvas id="department<?=$department['department_id']?>">
      
                            </canvas>
                        </div>
                           <script>
                               var colors = ['#FFB100','#FF0032','#F55050','#ADA2FF','#4649FF','#FF7000','#C47AFF','#1D1CE5']
                               var pick = Math.floor(Math.random() * 7);
                               var labels = []
                               var values = [];

                               var department<?=$department['department_id']?> = document.querySelector('#department<?=$department['department_id'];?>');

                               var label<?=$department['department_id']?> = document.querySelectorAll('.label<?=$department['department_id'];?>');

                               var value<?=$department['department_id']?> = document.querySelectorAll('.value<?=$department['department_id'];?>');

                               label<?=$department['department_id']?>.forEach(l=>{
                                 labels.push(l.value.slice(0,10))
                               })

                               value<?=$department['department_id']?>.forEach(v=>{
                                 values.push(v.value)
                               })

                                new Chart(department<?=$department['department_id']?>, {
                                  type: 'bar',
                                  data: {
                                    labels: labels,
                                    datasets: [{
                                      label: 'Items',
                                      data: values,
                                      borderWidth: 1,
                                      backgroundColor: colors[pick]
                                    }]
                                  },
                                  options: {
                                    scales: {
                                      y: {
                                        beginAtZero: true
                                      }
                                    }
                                  }
                                });
                           </script>
                          <?php }?>
                    </div>
               
                </div>
            </div>
           
        </div>
    </div>
</body>
<script>
   
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('myChart2');
  const ctx3 = document.getElementById('myChart3');
  const ctx4 = document.getElementById('myChart4');
  const ctx6 = document.getElementById('myChart6');
  const consumables = document.querySelectorAll('.consumables');
  const nonConsumables = document.querySelectorAll('.nonConsumables');
  const totals = document.querySelectorAll('.totals');
  const conReq = document.querySelector('.conReq');
  const nonReq = document.querySelector('.nonReq');

  let consumableArrayLabel = []
  let consumableArrayStocks = []
  let nonConsumableArrayLabel = []
  let nonConsumableArrayStocks = []
  let itemLabels = [];
  let itemCount = [];
  let comparisonArray = [conReq.value,nonReq.value];

  totals.forEach(total=>{
     itemLabels.push(total.name.slice(0,10))
     itemCount.push(total.value)
  })


  setTimeout(()=>{
      consumables.forEach(consumable=>{
         
         consumableArrayLabel.push(consumable.name);
         consumableArrayStocks.push(consumable.value)
      })
       new Chart(ctx, {
    type: 'pie',
    data: {
      labels: consumableArrayLabel,
      datasets: [{
        label: 'Item Stocks',
        data: consumableArrayStocks,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });


  },1000)
  nonConsumables.forEach(consumable=>{
      
     nonConsumableArrayLabel.push(consumable.name);
     nonConsumableArrayStocks.push(consumable.value)
   })
 
  
   new Chart(ctx2, {
     type: 'pie',
     data: {
       labels:nonConsumableArrayLabel,
       datasets: [{
         label: 'Item Stocks',
         data:nonConsumableArrayStocks,
         borderWidth: 1
       }]
     },
     options: {
       scales: {
         y: {
           beginAtZero: true
         }
       }
     }
   });



  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ['Consumable Items','Non-Consumable Items'],
      datasets: [{
        label: 'Request Comparison  ',
        data: comparisonArray,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  new Chart(ctx4, {
    type: 'line',
    data: {
      labels: itemLabels,
      datasets: [{
        label: 'Requested Items ',
        data: itemCount,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  let deptLabel = []
  let deptValue = []

  document.querySelectorAll('.allDeptsValue').forEach(deps=>{
     deptValue.push(deps.value)
  })
  document.querySelectorAll('.allDeps').forEach(deps=>{
     deptLabel.push(deps.value)
  })

   new Chart(ctx6, {
    type: 'bar',
    data: {
      labels: deptLabel,
      datasets: [{
        label: 'Departments ',
        data: deptValue,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>



 <?php include('../../includes/scripts.php')?>

</html>