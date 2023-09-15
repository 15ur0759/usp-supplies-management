<?php
 require_once('../php/dbConnection.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];

$lists = getList($conn,$userInfo['id'],2);
$total = $lists->num_rows;
 
?>
<?php if($total > 0){?>
<table  class="table table-striped">
    <input type="hidden" name="" id="itemCounter" value="<?=$total?>">
    <thead>
        <tr>
            
            <th>Item Code</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Available Stocks</th>
            <th class="text-center">Remove</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
          while($list = $lists->fetch_assoc()){
        ?>
        <tr>
            <td><?=$list['item_code'];?></td>
            <td><?=$list['item_description'];?></td>
            <td>
                <?=$list['item_quantity'];?>
                <span>(<?=$list['measure_description'];?>)</span>
            </td>
            <td>
                <?=$list['quantity'];?>
                <span>(<?=$list['measure_description'];?>)</span>
            </td>
            <td class="text-center">
                <span onclick="deleteList('<?=$list['list_id'];?>')" class="text-danger" style="cursor:pointer; font-weight: 500;"><i class="fas fa-trash-alt"></i></span>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>

<div class="text-right">
    <button onclick="submitRequest()" class="btn btn-success">Submit All</button>
</div>
<?php }else{?>
    <div class="p-4 fw-bold text-center">Items Added will display here.</div>
<?php }?>