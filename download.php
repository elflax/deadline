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



	$sql="SELECT students.id as students_id, students.name as students_name, UFID, email, phone, major, regitration_type, section, term, mentor_name, mentor_ufid, mentor_email, mentor_phone, mentor_department, mentor_college, description, status, aprovated_by, users.name as users_name FROM students LEFT JOIN users ON students.aprovated_by=users.id";
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
		 					  'Approved/Deny by'=> $fila['users_name'] , 
		 					  'Status' =>'complete', 
		 					  'Student Name'=>$fila['students_name'], 
		 					  'Student UFID'=>$fila['UFID'],
		 					  'Student Email' =>$fila['email'], 
		 					  'Student Phone'=> $fila['phone'], 
		 					  'Major'=>$fila['major'],
		 					  'College' =>$fila['regitration_type'], 
		 					  'Section'=>$fila['section'], 
		 					  'Term'=>$fila['term'],
		 					  'Mentor Name' =>$fila['mentor_name'], 
		 					  'Mentor UFID'=>$fila['mentor_ufid'], 
		 					  'Mentor Phone'=>$fila['mentor_phone'],
		 					  'Mentor Email' =>$fila['mentor_email'], 
		 					  'Mentor Department'=>$fila['mentor_department'], 
		 					  'Mentor College'=>$fila['mentor_college'],
		 					  'Brief Description' => trim(preg_replace('/\s+/', ' ', $fila['description']))
		 					  
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