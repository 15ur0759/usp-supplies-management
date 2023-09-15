<?php

if(!isset($_SESSION)){
    session_start();

}
$userInfo = $_SESSION['userInfo'];

$updated = false;
$updateFailed = false;

if(isset($_POST['oldPassword']) && isset($_POST['newPassword'])){
    $oldPassword = $_POST['oldPassword'];
    $newPassword = md5($_POST['newPassword']);
    $userId = $userInfo['id'];

    if($userInfo['password'] == md5($oldPassword)){
        $query = $conn->prepare("UPDATE user SET password= ? WHERE id = ?");
        $query->bind_param('si',$newPassword,$userId);
        $okay = $query->execute() or die();

        if($okay){
        $query2 = $conn->prepare("SELECT * FROM user INNER JOIN role ON user.role = role.role_id WHERE user.id=?");
        $query2->bind_param('i',$userId);

        $query2->execute();
        $result = $query2->get_result();

        if($result->num_rows > 0){
            $newInfo = $result->fetch_assoc();
            $_SESSION['userInfo'] = $newInfo;
        }
            $updated = true;
        }else{
            $updateFailed = true;
        }

    }else{
         $updateFailed = true;
    }
}

$infoUpdated = false;
$infoUpdateFailed = false;

if(isset($_POST['firstName']) && isset($_POST['lastName'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userId = $userInfo['id'];

   
        $query = $conn->prepare("UPDATE user SET firstName= ?, lastName= ? WHERE id = ?");
        $query->bind_param('ssi',$firstName,$lastName,$userId);
        $okay = $query->execute() or die();

        if($okay){
        $query2 = $conn->prepare("SELECT * FROM user INNER JOIN role ON user.role = role.role_id WHERE user.id=?");
        $query2->bind_param('i',$userId);

        $query2->execute();
        $result = $query2->get_result();

        if($result->num_rows > 0){
            $newInfo = $result->fetch_assoc();
            $_SESSION['userInfo'] = $newInfo;
        }
            $infoUpdated = true;
        }else{
            $infoUpdateFailed = true;
        }

}