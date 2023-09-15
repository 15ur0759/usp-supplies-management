<?php
  require_once('../php/dbConnection.php');
   require_once('../php/sessions.php');


if(!isset($_SESSION['userInfo'])){
    header('location: ../../login.php');
}

$userInfo = $_SESSION['userInfo'];
$id =  $userInfo['id'];


  $logs = $conn->query("SELECT * FROM log WHERE log_owner = $id");
?>

<table id="logTable" class="table table-striped">
<thead>
    <tr>
        <th>#</th>
        <th>Activity Description</th>
        <th>Activity Date</th>
       
    </tr>
</thead>
<tbody>
    <?php
    while($log= $logs->fetch_assoc()){
    ?>
    <tr>
        
        <td><?=$log['log_id']?></td>
        <td><?=$log['log_description']?></td>
        <td><?=$log['log_date']?></td>
       
    </tr>
    <?php
    }
    ?>
</tbody>
</table>

<script>
     $(document).ready( function () {
        $('#logTable').DataTable({order:[[0,'desc']]});
    } );
    
</script>