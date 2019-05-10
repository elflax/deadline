<?php
	session_start();
	if($_GET['type'] == 1){
		unset($_SESSION["id"]);
		unset($_SESSION["name"]);
		session_destroy();
		header('Location: ../login-dashboard.php');		
	}else{
		unset($_SESSION["id_adviser"]);
		unset($_SESSION["name_adviser"]);
		session_destroy();
		header('Location: ../login-adviser.php');
	}