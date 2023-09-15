<?php
 require_once('../../controller/campusAdmin.controller.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <title>Login</title>
</head>

<body>
    <div class="container">
       
        <div class="bg-light mt-5">
            
            <div class="p-4 border shadow rounded overflow-auto" style="height: 700px;">
                <table id="users" class="table display">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>
                        <th scope="col">IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      while($row = $result->fetch_assoc()){

                      
                    ?>
                    <tr>
                        <td><?=$row['id']?></td>
                        <td><?=$row['first_name']?></td>
                        <td><?=$row['last_name']?></td>
                        <td><?=$row['email']?></td>
                        <td><?=$row['gender']?></td>
                        <td><?=$row['ip_address']?></td>
                    </tr>
                    <?php
                      }
                    ?>
                </tbody>
                </table>
            </div>
         
        </div>
    </div>
</body>

<script>
$(document).ready( function () {
    $('#users').DataTable();
} );
</script>
  <?php include_once('../../includes/scripts.php')?>

</html>