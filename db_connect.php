<?php
$servername = "localhost"; 
$username= "root";
$password = "";
$dbname= "blog";

$conn = new mysqli($servername,$username,$password,$dbname);

if(!$conn){
    die("Connection failed: " . $conn->connect_error);
}
else{
    // echo "connected";
}

?>