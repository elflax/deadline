<?php
	session_start();
	$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());

	$sql = 'UPDATE `students` SET `status`='.$_POST['type'].',`aprovated_by`='.$_SESSION['id'].' WHERE id='.$_POST['id'];
	$result = mysql_query($sql);
	if(!$result){
		echo mysql_error();
	}else{
		$to = "eliasvoorhees@gmail.com";
		$from = "example@gmail.com";
    	$headers = "From: $from";
    	if($_POST['id'] == 1){
    		$message = 'Your form request has been aproved';
    	}else{
    		$message = 'Your form request has been rejected';
    	}
		echo json_encode(['value' => 'Status changed successfully!']);
	}
