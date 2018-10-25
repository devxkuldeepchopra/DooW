<?php 
$servername = "localhost";
$username = "ankushas_jiofox";
$password = "Jiofox@123";
//$Response = array();
$errors = array();
try {
      $conn = new PDO("mysql:host=$servername;dbname=ankushas_jiofox", $username, $password);
		  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  $Response['dbcon'] = "Connected successfully"; 
    }
catch(PDOException $e)
    {
		  $errors['dberr'] = "Connection failed: " . $e->getMessage();
    }

?>