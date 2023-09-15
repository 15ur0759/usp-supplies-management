<?php
require_once('./php/dbConnection.php');

if(!isset($_SESSION)){
    session_start();
}
 $failed = false;
    
    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
       


        $query = $conn->prepare("SELECT * FROM user INNER JOIN role ON user.role = role.role_id INNER JOIN department ON department.department_id = user.department WHERE user.username=? AND user.password=? AND is_allowed = 1");
        $query->bind_param('ss',$username,$password);

        $query->execute();
        $result = $query->get_result();

        if($result->num_rows > 0){
            $userInfo = $result->fetch_assoc();
            $_SESSION['userInfo'] = $userInfo;
            $_SESSION['timeIn'] = time();
          
            switch($userInfo['role']){
              case 1 :  header('location:./views/admin/admin.php');
              break;
              case 2 :  header('location:./views/suppliesAdmin/dashboard.php');
              break;
              case 3 :  header('location:./views/chairperson/chairperson.request.php');
              break;
              case 4 :  header('location:./views/dean/dean.request.php');
              break;
              case 5 :  header('location:./views/ced/ced.request.php');
              break;
              case 6 :  header('location:./views/instructor/instructorNewRequest.php');
              break;
              case 7 :  header('location:./views/nonTeaching/nonTeachingNewRequest.php');
              break;
              case 8 :  header('location:./views/nonTeachingHead/nonTeachingHead.request.php');
              break;
              default : $failed = true;
            }
        }else{
            $failed = true;
        }
    }
    
    // $admin = "user@admin";
    // $adminPassword = "password1234";

   

    // if($username == $admin && $password == $adminPassword ){
    //   header('location:./views/admin/admin.php');
    // }else{
    //    $failed = true;
    // }