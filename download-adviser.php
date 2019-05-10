<?php

	$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());
	
	function ExportFile($records) {
	$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // display field/column names as a first row
			  echo implode("\t", array_keys($row)) . "\n";
			  $heading = true;
			}
			echo implode("\t", array_values($row)) . "\n";
		  }

	} 



	$sql="SELECT students.id as students_id, students.name as students_name, UFID, email, phone, major, regitration_type, section, term, mentor_name, mentor_ufid, mentor_email, mentor_phone, mentor_department, mentor_college, description, status, approved_by_adviser, users.name as users_name, status_adviser FROM students LEFT JOIN users ON students.approved_by_adviser=users.id WHERE students.status=1";
	$result = mysql_query($sql);	
	
	/*

	 $data = array(
			 '0' => array('Name'=> 'Parvez', 'Status' =>'complete', 'Priority'=>'Low', 'Salary'=>'001'),
			 '1' => array('Name'=> 'Alam', 'Status' =>'inprogress', 'Priority'=>'Low', 'Salary'=>'111'),
			 '2' => array('Name'=> 'Sunnay', 'Status' =>'hold', 'Priority'=>'Low', 'Salary'=>'333'),
			 '3' => array('Name'=> 'Amir', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'444'),
			 '4' => array('Name'=> 'Amir1', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'777'),
			 '5' => array('Name'=> 'Amir2', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'777')
			);
	
	*/
	
	$x = 0;


	while ($fila = mysql_fetch_assoc($result)) {
		 	$data[$x] = array('#' => ($x+1),
		 					  'Approved/Deny by'=> $fila['approved_by_adviser'] , 
		 					  'Status' =>'complete', 
		 					  'Name'=>$fila['students_name'], 
		 					  'UFID #'=>$fila['UFID'],
		 					  'Email' =>$fila['email'], 
		 					  'Major'=>$fila['major'],
		 					  'College' =>$fila['regitration_type'], 
		 					  'Class Number'=>$fila['section'], 
		 					  'Term'=>$fila['term'],		 					  
		 					  );
		 	$x++;
	}	

	


	 

	 $filename = "report.xls";		 
     header("Content-Type: application/vnd.ms-excel");
	 header("Content-Disposition: attachment; filename=\"$filename\"");
	 ExportFile($data);

	/*while ($fila = mysql_fetch_assoc($result)) {
    echo $fila['students_name'];
     echo " ";
    echo $fila['users_name'];
    echo "<br>";
  
	}*/
	

?>