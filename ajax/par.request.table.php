<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];
$department = $userInfo['department_id'];
$owner = $userInfo['id'];


$items = getAllAddedPar($conn,$owner);

$addedCount = getAllAddedPar($conn,$owner)->num_rows;
$result = getAllSentPar($conn,$owner);
$count = $result->num_rows;
$date = $result->fetch_assoc();


?>
<div class="par-table-header mb-4">
    <?php if($count == 0 && $addedCount > 0){?>
        <button onclick="submitParRequest(<?=$userInfo['id']?>)" class="btn btn-primary"><i class="fas fa-location-arrow me-1"></i>Submit Par</button>
     <?php }if($count > 0){?>
        <div class="par-status p-2 fst-italic  text-success" style="font-size: 1rem;">
            <i class="fas fa-check me-2"></i>
            This Request Has Been Sent to the Supplies Admin.
        </div>
        <div class="mt-3">
            <button onclick="sessionSetter(<?=$userInfo['id']?>)" class="btn-sm btn-success"><i class="fas fa-print me-2"></i>Print Request</button>
        </div>
    <?php }?>
</div>
<table id="requestTable" class="table table-bordered border over-flow-hidden">
<thead>
    <tr>
        <th>Item Code</th>
        <th>Description</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Jan</th>
        <th>Feb</th>
        <th>Mar</th>
        <th>Apr</th>
        <th>May</th>
        <th>June</th>
        <th>Jul</th>
        <th>Aug</th>
        <th>Sep</th>
        <th>Oct</th>
        <th>Nov</th>
        <th>Dec</th>
        <th>Date Added</th>
          <?php if($count == 0){?>
            <th>Controls</th>
          <?php }else{?>
             <th>Date Sent</th>
          <?php }?>
        
    </tr>
</thead>
<tbody>
    <?php
    while($item = $items->fetch_assoc()){
       
    ?>
    <tr>
        
        <td><?=$item['item_code']?></td>
        <td><?=$item['item_description']?></td>
         <td><?=$item['categ_description']?></td>
        <td>
                <?=$item['par_quantity'];?>
                <span>(<?=$item['measure_description'];?>)</span>
            </td>
       
        <td> <?=$item['jan'];?></td>
        <td> <?=$item['feb'];?></td>
        <td> <?=$item['mar'];?></td>
        <td> <?=$item['apr'];?></td>
        <td> <?=$item['may'];?></td>
        <td> <?=$item['june'];?></td>
        <td> <?=$item['july'];?></td>
        <td> <?=$item['aug'];?></td>
        <td> <?=$item['sep'];?></td>
        <td> <?=$item['oct'];?></td>
        <td> <?=$item['nov'];?></td>
        <td> <?=$item['decem'];?></td>
        <td><?=$item['par_added_date']?></td>
         <?php if($count == 0){?>
            <td class="text-center">
                <!-- <span onclick="editPar('<?=$item['par_id'];?>','<?=$item['par_quantity'];?>')" data-toggle="modal" data-target="#parEditQty" class="text-warning me-2" style="cursor:pointer; font-weight: 500;"><i class="fas fa-edit"></i></span> -->
                   <span onclick="deletePar('<?=$item['par_id'];?>')" class="text-danger" style="cursor:pointer; font-weight: 500;"><i class="fas fa-trash-alt"></i></span>
               </td>
         <?php }else{?>
            <td><?=$date['par_date_sent']?></td>
         <?php }?>
        
    </tr>
    <?php
    }
    ?>
</tbody>
</table>

<script>

      var sessionSetter = (id)=>{
       
        $.post('../../ajax/par.session.setter.php',{
            requesterId : id
        }).then(response=>{
            window.open('../../reports/print.ppmp.php', '_blank');
           
        })
     }


     $(document).ready( function () {
        $('#requestTable').DataTable({order:[[1,'asc']]});
    } );
    
</script>
