<?php
 require_once('../php/dbConnection.php');
  require_once('../controller/par.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];


$owner = $userInfo['id'];

$items = getAllUnAddedPar($conn,$owner);
$result = getAllSentPar($conn,$owner);
$count = $result->num_rows;

function isAdded($conn,$owner,$id){
  return exist($conn,$owner,$id) > 0;
}


 
?>
<?php if($count == 0){?>


<table id="requestTable" class="table table-bordered">
<thead>
    <tr>
        
        <th>Item Code</th>
        <th>Description</th>
        <th>Measurement</th>
         <th>Category</th>
         <th>Type</th>
        <th>Supplier</th>
       
        <th>Controls</th>
        
    </tr>
</thead>
<tbody>
    <?php
    while($item = $items->fetch_assoc()){
        if(!isAdded($conn,$owner,$item['item_id'])){
    ?>
    <tr>
        
        <td><?=$item['item_code']?></td>
        <td><?=$item['item_description']?></td>
        <td>(<?=$item['measure_description']?>)</td>
        <td><?=$item['categ_description']?></td>
        <td><?=$item['type_description']?></td>
        <td><?=$item['supplier_name']?></td>
       
         <td class="text-center">
                <button onclick="setParId('<?=$item['item_id'];?>')" data-toggle="modal" data-target="#parQty" class="btn-sm btn-primary" style="cursor:pointer; font-weight: 500;"><i class="fas fa-plus"></i>Add</button>
            </td>
        
    </tr>
    <?php
        }
    }
    ?>
</tbody>
</table>

<script>
     $(document).ready( function () {
        $('#requestTable').DataTable({order:[[1,'asc']]});
    } );
    
</script>
<?php }else{?>
     <div class="par-status p-2 text-center text-primary border-bottom" style="font-size: 1rem;">
            <i class="fas fa-info me-2"></i>
            You Already Have an On Going Request.
        </div>
<?php }?>