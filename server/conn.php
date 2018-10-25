<?php 
$servername = "localhost";
$username = "kuldeepchopra";
$password = "D3v!1xgodh";
$errors = array();
try {
      $conn = new PDO("mysql:host=$servername;dbname=doomw", $username, $password);
		  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		 
    }
catch(PDOException $e)
    {
		  $errors['dberr'] = "Connection failed: " . $e->getMessage();
    }

?>