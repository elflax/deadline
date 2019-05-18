<?php
	session_start();
	if(!isset($_SESSION['id_adviser'])){
		header("Location: ./login-adviser.php");
	}
$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());
	$message = '';
	$alert = '';
	if(isset($_GET['id'])){
		$sql = 'UPDATE `students` SET `status_adviser`='.$_GET['type'].',`approved_by_adviser`='.$_SESSION['id_adviser'].' WHERE id='.$_GET['id'];
		$result = mysql_query($sql);
		if(!$result){
			$message = mysql_error();
		}else{
			$to = $_GET['email'];
			$from = "jreal@ufl.edu";
	    	$headers = "From: $from";
    		$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	    	if($_GET['type'] == 1){
	    		$to = $_GET['email'];
				$from = "jreal@ufl.edu";
		    	$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: MCS IT <jreal@ufl.edu>' . "\r\n";
				$message = " Your application to register for the Bioinformatics Independent Research course has been approved. You will be registered for the course before classes begin.<br><br> If you need to change or withdraw your registration before classes start, please contact your academic advisor.";
	    		$alert = 'The form request has been approved';
	    		$subject ="Bioinfo Ind Res Class - Application Approved"; 
	    		mail($to, $subject, $message, $headers);
	    	}else{
	    		$to = $_GET['email'];
				$from = "jreal@ufl.edu";
		    	$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: MCS IT <jreal@ufl.edu>' . "\r\n";
				$message = "We're sorry, but your application to register for the Bioinformatics Independent Research course has been denied, because you lack the prerequisites to take the course at this time.<br><br> Please check the course prerequisites on the Bioinformatics Minor website. You may contact your academic advisor if you feel you have received this notice in error.";
	    		$alert = 'The form request has been rejected';
	    		$subject ="Bioinfo Ind Res Class - Application Denied"; 
	    		mail($to, $subject, $message, $headers);
	    	}
	    	
		}
	}
	$sql="SELECT students.id as students_id, students.name as students_name, UFID, email, phone, major, regitration_type, section, term, mentor_name, mentor_ufid, mentor_email, mentor_phone, mentor_department, mentor_college, description, status, approved_by_adviser, users.name as users_name, status_adviser FROM students LEFT JOIN users ON students.approved_by_adviser=users.id WHERE students.status=1";
	$result = mysql_query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Adviser Dashboard</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

	<div class="bg-contact3" style="background-image: url('images/bg-01.jpg');">
		<?php if($alert != ''){ ?>
		<div class="alert alert-success" role="alert">
			<?php echo $alert; ?>
		</div>
		<?php } ?>
		<div class="container-contact3">
			<div class="wrap-contact3" style="width: 92%;">
				<img src="./images/banner.jpeg" class="wrap-image">
				<span class="contact3-form-title" style="padding-bottom: 0px;">
					Adviser
					<div style="text-align: right;">
						<a href="./ajax/logout.php?type=2" class="btn btn-xs btn-success" title="logout" style="min-width: 60px;"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
					</div>
					<div style="text-align: right;">
						
					</div>
				</span>
				<span class="contact3-form-title" style="padding-bottom: 0px;">
					Applicants
				</span>
				<div class="cont" style="width: 100%; overflow-x: auto;">
					<button class="dt-button buttons-excel buttons-html5 contact3-form-btn" type="button" style="min-width: 70px;" id="export" onclick="ExportExcel();">
						<span>
							<i class="fa fa-file-excel-o" style="font-size: 20px;"> </i>
						</span>	
					</button>
					<br><br>
					<table id="table">
						<thead>
							<tr>
								<th>Approved/Denied by:</th>
								<th>Action</th>
								<th>Name</th>
								<th>UFID</th>
								<th>Email</th>
								<th>Major</th>
								<th>College</th>
								<th>Class Number</th>
								<th>Term</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = mysql_fetch_assoc($result)) {?>
							<tr>
								<td class="text-center" data-toggle="popover" title="Approved/Denied by:" data-placement="top" data-content="<?php echo ' '.$row['users_name']; ?>"><?php echo $row['users_name']; ?></td>
								<td class="btn-group text-center" data-content='<?php echo ($row["status_adviser"]=='1')? "Approve":(($row["status_adviser"]=='2')? "Deny":"Waiting" ); ?>'>
									<?php if($row['status_adviser'] == '0') {?>
									<a href="./adviser-dashboard.php?id=<?php echo $row['students_id'];?>&email=<?php echo $row['email']; ?>&type=1" class="btn btn-success btn-xs">Approve</a>
									<a href="./adviser-dashboard.php?id=<?php echo $row['students_id'];?>&email=<?php echo $row['email']; ?>&type=2" class="btn btn-danger btn-xs">Deny</a>									
									<?php }elseif($row['status_adviser'] == '1'){ ?>
										<b class="text-success">Approve</b>
									<?php }elseif($row['status_adviser'] == '2'){?>
										<b class="text-danger">Deny</b>
									<?php }?>
								</td>
								<td class="text-center" data-toggle="popover" title="Name" data-placement="top" data-content="<?php echo ' '.$row['students_name']; ?>"><?php echo $row['students_name']; ?></td>
								<td class="text-center" data-toggle="popover" title="UFID" data-placement="top" data-content="<?php echo ' '.$row['UFID']; ?>"><?php echo $row['UFID']; ?></td>
								<td class="text-center" data-toggle="popover" title="Email" data-placement="top" data-content="<?php echo ' '.$row['email']; ?>"><?php echo $row['email']; ?></td>
								<td class="text-center" data-toggle="popover" title="Major" data-placement="top" data-content="<?php echo ' '.$row['major']; ?>"><?php echo $row['major']; ?></td>
								<td class="text-center" data-toggle="popover" title="College" data-placement="top" data-content="<?php echo ' '.$row['regitration_type']; ?>"><?php echo $row['regitration_type']; ?></td>
								<td class="text-center" data-toggle="popover" title="Class Number" data-placement="top" data-content="<?php echo ' '.$row['section']; ?>"><?php echo $row['section']; ?></td>
								<td class="text-center" data-toggle="popover" title="Term" data-placement="top" data-content="<?php echo ' '.$row['term']; ?>"><?php echo $row['term']; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/dataRender/ellipsis.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script>
			var pag = ['1'];
		function paginate(){
			$('.paginate_button').each((ind, elem) => {
				$(elem).click(() => {
					var curr = $('.current').attr('data-dt-idx');
					if(pag.indexOf(curr) === -1){
						pag.push(curr);
						$('[data-toggle="popover"]').popover({
  							trigger: 'hover'
  						});
					}
					paginate();
				});
			});
			$('th').each((ind, elem) => {
				$(elem).click(() => {
					$('[data-toggle="popover"]').popover({
						trigger: 'hover'
					});
					paginate();
				});
			});
		}
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
		$(document).ready(() => {
			$('#table').DataTable({		        
		        columnDefs: [ {
			        targets: [0,3,4,6],
			        render: $.fn.dataTable.render.ellipsis(20)
			    } ],
		        initComplete: function () {
		        	$('.buttons-excel').addClass('contact3-form-btn');
		        	$('.buttons-excel').css('min-width', '70px');
		        	$('.buttons-excel').attr('title', 'Export to Excel');
		        	$('.buttons-excel > span').html('<i class="fa fa-file-excel-o" style="font-size: 20px;"></i> ');
  					$('[data-toggle="popover"]').popover({
  						trigger: 'hover'
  					});
					paginate();
		        }
			});
		});
	</script>
	<script src="js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
<script>
	function ExportExcel(){
		window.open("download-adviser.php");
	}	

  	window.dataLayer = window.dataLayer || [];
  	function gtag(){dataLayer.push(arguments);}
  	gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
