<?php
	$q = $_GET['q'];
	$valArray = explode(',',$q);
	$conn = new mysqli('IP','username','password','components');
	if($valArray[0]=="new"){
		$result = $conn->query("SELECT * FROM users WHERE username='" . $valArray[1] . "'");
		$row = $result->fetch_assoc();
		if($row){
			echo "no";
		}
		else{
			$pass_hash = hash('sha512', $valArray[2]);
			$conn->query("INSERT INTO users (username, password) VALUES ('" . $valArray[1] . "','" . $pass_hash . "')");
			echo "created";
		}
	}
	else{
	$result = $conn->query("SELECT * FROM users WHERE username='" . $valArray[0] . "'");
		$row = $result->fetch_assoc();
		if($row){
			$realPass = $row['password'];
		if(hash('sha512', $valArray[1])==$realPass){
			echo "correct";
		}
		else{echo "no";}
		}
	}
	$conn->close();
?>
