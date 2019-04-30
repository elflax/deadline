<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("Location: ./login-dashboard.php");
	}
	$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());
	$message = '';
	if(isset($_GET['id'])){
		$sql = 'UPDATE `students` SET `status`='.$_GET['type'].',`aprovated_by`='.$_SESSION['id'].' WHERE id='.$_GET['id'];
		$result = mysql_query($sql);
		if(!$result){
			$message = mysql_error();
		}else{
			$to = $_GET['email'];
			$from = "example@gmail.com";
	    	$headers = "From: $from";
	    	if($_GET['id'] == 1){
	    		$message = 'Your form request has been aproved';
	    	}else{
	    		$message = 'Your form request has been rejected';
	    	}
		}
	}
	$sql="SELECT students.id as students_id, students.name as students_name, UFID, email, phone, major, regitration_type, section, term, mentor_name, mentor_ufid, mentor_email, mentor_phone, mentor_department, mentor_college, description, status, aprovated_by, users.name as users_name FROM students LEFT JOIN users ON students.aprovated_by=users.id";
	$result = mysql_query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact V3</title>
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
		<?php if($message != ''){ ?>
		<div class="alert alert-success" role="alert">
			<?php echo $message; ?>
		</div>
		<?php } ?>
		<div class="container-contact3">
			<div class="wrap-contact3" style="width: 900px;">
				<img src="./images/banner.jpeg" class="wrap-image">
				<span class="contact3-form-title" style="padding-bottom: 0px;">
					Dashboard
					<div style="text-align: right;">
						<a href="./ajax/logout.php" class="btn btn-xs btn-success" title="logout" style="min-width: 60px;"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
					</div>
					<div style="text-align: right;">
						
					</div>
				</span>
				<label class="label-contact3">
					Student Approval List 
				</label>
				<div class="cont" style="width: 100%; overflow-x: auto;">
					<table id="table">
						<thead>
							<tr>
								<th>Action</th>
								<th>#</th>
								<th>Name</th>
								<th>Student UFID</th>
								<th>Student Email</th>
								<th>Phone</th>
								<th>Major</th>
								<th>College</th>
								<th>Section</th>
								<th>Term</th>
								<th>Mentor Name</th>
								<th>Mentor UFID</th>
								<th>Mentor Phone</th>
								<th>Mentor Email</th>
								<th>Mentor department</th>
								<th>Mentor College</th>
								<th>Brief description</th>
								<th>Approved/Denied by:</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = mysql_fetch_assoc($result)) { $id = $row['students_id']; $email = $row['email']; ?>
							<tr>
								<td class="text-center" data-toggle="popover" title="Action" data-placement="top" data-content="<?php echo $row['users_name']; ?>"><?php echo (count($row['users_name']) <= 10)? $row['users_name']:substr(string, 0, 10); ?></td>
								<td class="btn-group text-center">
									<?php if($row['status'] == 0) {?>
									<a href="./admin-dashboard.php?id=<?php echo $id;?>&email=<?php echo $email; ?>&type=1" class="btn btn-success btn-xs">Approve</a>
									<a href="./admin-dashboard.php?id=<?php echo $id;?>&email=<?php echo $email; ?>&type=2" class="btn btn-danger btn-xs">Deny</a>									
									<?php }elseif($row['status'] == 1){ ?>
										<b class="text-success">Approve</b>
									<?php }elseif($row['status'] == 2){?>
										<b class="text-danger">Deny</b>
									<?php }?>
								</td>
								<td class="text-center" data-toggle="popover" title="Name" data-placement="top" data-content="<?php echo $row['students_id']; ?>"><?php echo $row['students_id']; ?></td>
								<td class="text-center" data-toggle="popover" title="Student UFID" data-placement="top" data-content="<?php echo $row['students_name']; ?>"><?php echo (count($row['students_name']) <= 10)? $row['students_name']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Student Email" data-placement="top" data-content="<?php echo $row['UFID']; ?>"><?php echo (count($row['UFID']) <= 10)? $row['UFID']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Phone" data-placement="top" data-content="<?php echo $row['email']; ?>"><?php echo (count($row['email']) <= 10)? $row['email']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Major" data-placement="top" data-content="<?php echo $row['phone']; ?>"><?php echo (count($row['phone']) <= 10)? $row['phone']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="College" data-placement="top" data-content="<?php echo $row['major']; ?>"><?php echo (count($row['major']) <= 10)? $row['major']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Section" data-placement="top" data-content="<?php echo $row['regitration_type']; ?>"><?php echo (count($row['regitration_type']) <= 10)? $row['regitration_type']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Term" data-placement="top" data-content="<?php echo $row['section']; ?>"><?php echo (count($row['section']) <= 10)? $row['section']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor Name" data-placement="top" data-content="<?php echo $row['term']; ?>"><?php echo (count($row['term']) <= 10)? $row['term']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor UFID" data-placement="top" data-content="<?php echo $row['mentor_name']; ?>"><?php echo (count($row['mentor_name']) <= 10)? $row['mentor_name']:substr(string, 0, 10); ?>2019</td>
								<td class="text-center" data-toggle="popover" title="Mentor Phone" data-placement="top" data-content="<?php echo $row['mentor_ufid']; ?>"><?php echo (count($row['mentor_ufid']) <= 10)? $row['mentor_ufid']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor Email" data-placement="top" data-content="<?php echo $row['mentor_phone']; ?>"><?php echo (count($row['mentor_phone']) <= 10)? $row['mentor_phone']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor department" data-placement="top" data-content="<?php echo $row['mentor_email']; ?>"><?php echo (count($row['mentor_email']) <= 10)? $row['mentor_email']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor College" data-placement="top" data-content="<?php echo $row['mentor_department']; ?>"><?php echo (count($row['mentor_department']) <= 10)? $row['mentor_department']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Brief description" data-placement="top" data-content="<?php echo $row['mentor_college']; ?>"><?php echo (count($row['mentor_college']) <= 10)? $row['mentor_college']:substr(string, 0, 10); ?></td>
								<td class="text-center" data-toggle="popover" title="Approved/Denied by:" data-placement="top" data-content="<?php echo $row['description']; ?>"><?php echo (count($row['description']) <= 10)? $row['description']:substr(string, 0, 10); ?></td>
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
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
		$(document).ready(() => {
			$('#table').DataTable({
				dom: 'Bfrtip',
		        buttons: [
		            'excel',
		        ],
		        initComplete: function () {
		        	$('.buttons-excel').addClass('contact3-form-btn');
		        	$('.buttons-excel').css('min-width', '70px');
		        	$('.buttons-excel').attr('title', 'Export to Excel');
		        	$('.buttons-excel > span').html('<i class="fa fa-file-excel-o" style="font-size: 20px;"></i> ');
  					$('[data-toggle="popover"]').popover({
  						trigger: 'hover'
  					});
		        }
			});
		});
	</script>
	<script src="js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
