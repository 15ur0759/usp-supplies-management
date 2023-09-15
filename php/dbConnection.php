
<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "supplies";


$conn = new mysqli($host,$username,$password,$database);

if($conn->connect_error){
    echo $conn->connect_error;
}



    // $username = 'user@suppliesAdmin';
    // $password = md5('password1234');
    // $firstName = 'Mike';
    // $lastName = 'Shinoda';
    // $email = 'mikeshinoda@gmail.com';
    // $query = $conn->prepare("INSERT INTO `user` (username,password,firstName,lastName,email) VALUES(?,?,?,?,?)");
    // $query->bind_param("sssss",$username,$password,$firstName,$lastName,$email);

    // $result = $query->execute() or die();


    // $query = $conn->prepare("SELECT * FROM user WHERE username=?");
    // $query->bind_param('s',$username);

    // $query->execute();
    // $result = $query->get_result();


    // while($row = $result->fetch_assoc()){
    //     echo $row['username'];
    // }