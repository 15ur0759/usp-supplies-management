<?php
 require_once('../php/dbConnection.php');
 require_once('../php/now.php');
 require_once('../controller/request.controller.php');
 require_once('../php/sessions.php');



if(isset($_POST['chosenDeptId'])){
  $chosen = $_POST['chosenDeptId'];

  $lists = $conn->query("SELECT * FROM user WHERE department= '$chosen' AND `role` != 1 ");
}
 

?>
<div class="form-group">
                <label>Accounts</label>
                <input type="hidden" name="currentDept" value="<?=$chosen?>">
                <select required  name="assignMe" class="form-control">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                      while($list = $lists->fetch_assoc()){
                    ?>
                    <option value="<?=$list['id']?>"><?=$list['firstName']?> <?=$list['lastName']?></option>
                   <?php } ?>
        </select>
 </div>

            <button type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
    