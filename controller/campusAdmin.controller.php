<?php
require_once('../../php/dbConnection.php');

// if(!isset($_SESSION)){
//     session_start();
// }


function getAllAccounts($conn){
    return $conn->query("SELECT * FROM user INNER JOIN department ON user.department = department.department_id INNER JOIN role ON user.role = role.role_id ORDER BY user.lastName");
}

function getAllHeads($conn){
    return $conn->query("SELECT * FROM user RIGHT JOIN department ON user.department = department.department_id WHERE department.department_id != 5 AND department.department_id != 6 GROUP BY department.department_id");
}

function getHead($conn,$department){
   
    return $conn->query("SELECT * FROM user WHERE department = $department AND (`role` = 3 OR `role` = 8)");
}

function getCurrent($conn,$id){
    return $conn->query("SELECT * FROM user WHERE id = '$id'")->fetch_assoc();
}

function setTemp($conn,$dept,$type){
    return $conn->query("UPDATE user SET `role` = '$type' WHERE department = '$dept'");
}

function setHead($conn,$id,$type){
    return $conn->query("UPDATE user SET `role` = '$type' WHERE id = '$id'");
}


function getDepartments($conn){
    return $conn->query("SELECT * FROM department WHERE dept_type = 1 OR dept_type = 2");
}

function getTeachingDepartments($conn){
    return $conn->query("SELECT * FROM department WHERE dept_type = 1");
}

function getNonTeachingDepartments($conn){
    return $conn->query("SELECT * FROM department WHERE dept_type = 2");
}


function getRoles($conn){
    return $conn->query("SELECT * FROM `role` WHERE role_id = 6 OR role_id = 7");
}

$failed = false;
$saved = false;

if(isset($_POST['newFirstName']) && isset($_POST['newLastName']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['department']) && isset($_POST['role'])){
    
     $department = $_POST['department'];

   
    $password = md5($_POST['password']);

    if(userNameExist($conn,$_POST['username']) > 0){
        $failed = true;
        $saved = false;
    }else{
     

        $query = $conn->prepare("INSERT INTO user (`role`,username,password,firstName,lastName,email,department,is_allowed) VALUES (?,?,?,?,?,?,?,1)");
        $query->bind_param('isssssi',$_POST['role'],$_POST['username'],$password,$_POST['newFirstName'],$_POST['newLastName'],$_POST['email'],$department);

        $saved = $query->execute();
        $failed = false;
    }

}

function userNameExist($conn,$username){
  
    
    $result = $conn->query("SELECT * FROM user WHERE username = '$username'");

    return $result->num_rows;
}


function addDepartment($conn,$name,$type){
    
    if(departmentNameExist($conn,$name) > 0){
        return false;
    }else{
        $query = $conn->prepare("INSERT INTO department (department_name,dept_type) VALUES (?,?)");
        $query->bind_param('si',$name,$type);

        return $query->execute();
    }
}

function updateDepartment($conn,$name,$id){

    if(departmentNameExist($conn,$name) > 0){
        return false;
    }else{
        $query = $conn->prepare("UPDATE department SET department_name = ? WHERE department_id = ?");
        $query->bind_param('si',$name,$id);

        return $query->execute();
    }
}




function departmentNameExist($conn,$name){
    $result = $conn->query("SELECT * FROM department WHERE department_name = '$name'");
   
    return $result->num_rows;
}

function updateAccountStatus($conn,$id,$status){
  
    
    $query = $conn->prepare("UPDATE user SET is_allowed = ? WHERE id = ?");
    $query->bind_param('ii',$status,$id);

    return $query->execute();
}

