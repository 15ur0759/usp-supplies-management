<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');

 ?>

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
        </div>
            <div class="dashboard-container">
            <div class="dashboard-links">
            <div class="dashboard-link dashboard-link-active">Items Chart</div>
            <div class="dashboard-link">Requests Chart</div>
            </div>
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

    </div>

</div>

<script>
   
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('myChart2');
  const ctx3 = document.getElementById('myChart3');
  const consumables = document.querySelectorAll('.consumables');
  const nonConsumables = document.querySelectorAll('.nonConsumables');
  let consumableArrayLabel = []
  let consumableArrayStocks = []
  let nonConsumableArrayLabel = []
  let nonConsumableArrayStocks = []

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
        label: 'Stocks',
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
         label: '# of Votes',
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
 
</script>