<?php
$servername = "localhost";
$database = "sumb1497_karyawan";
$username = "sumb1497_karyawan";
$password = "Bismillahi01!";
 
// Create connection
 
$conn = mysqli_connect($servername, $username, $password, $database);
 
// Check connection
 
if (!$conn) {
 
    die("Connection failed: " . mysqli_connect_error());
 
}
echo "Connected successfully";
mysqli_close($conn);
?>