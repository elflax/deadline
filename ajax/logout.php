<?php
	session_start();
	unset($_SESSION["id"]);
	unset($_SESSION["name"]);
	unset($_SESSION["id_adviser"]);
	unset($_SESSION["name_adviser"]);
	session_destroy();
	header('Location: ../login-dashboard.php');