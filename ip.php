<?php
$servername = "localhost";
$username = "kuldeepchopra";
$password = "D3v!1xgodh";
$dbname = "doomw_tutorial";
$isIpExist = false;
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
}  
else
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "SELECT * FROM `visitor` WHERE `ip` = '$ip'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        $isIpExist = true;
    } 
}
$conn->close();
?>