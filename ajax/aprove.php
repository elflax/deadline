<?php
	$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());

	$sql = 'UPDATE `students` SET `status`=1,`aprovated_by`="" WHERE id='.$_POST['id'];
	$result = mysql_query($sql);
	if(!$result){
		echo mysql_error();
	}else{
		echo 'Status changed successfully';
	}
