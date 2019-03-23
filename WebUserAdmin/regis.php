<?php

  include "Connections/dbconfig.php";

  $user = $_POST['user'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $login = 'user';
  $passmd5 = $pass;

  $sql="INSERT INTO `highadmin` (name, email, password, LoginStatus) VALUES (:p1,:p2,:p3,:p4)";
	
	$stm=$con->prepare($sql);
	$stm->bindParam(':p1',$user);
	$stm->bindParam(':p2',$email);
	$stm->bindParam(':p3',$passmd5);
	$stm->bindParam(':p4',$login);


	try{
		$stm->execute();

		echo "<script>alert('สมัครเรียบร้อย');</script>";
		echo "<script>window.location='index.php';</script>";
		echo "<script>window.close();</script>";
		
	} 
	catch (PDOException $e){
		echo $e->getMessage();
	}
	catch(Exception $exc){
		echo $exc->getTraceAsString();
	}

?>