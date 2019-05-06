<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("Location: ./login-dashboard.php");
	}

	$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());
	if(isset($_GET['active'])){
		$sql = 'UPDATE `config` SET `value` = "'.$_GET['active'].'" WHERE `config`.`id` = 1';
		$result = mysql_query($sql);
	}
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
	$sql = 'SELECT `id`, `name`, `value` FROM `config` WHERE `id` = 1';
	$form = mysql_query($sql);	
	$row2 = mysql_fetch_assoc($form);
	$result2 = $row2['value'];
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
	<style type="text/css">
	</style>
</head>
<body>
	<div class="bg-contact3" style="background-image: url('images/bg-01.jpg');">
		<?php if($message != ''){ ?>
		<div class="alert alert-success" role="alert">
			<?php echo $message; ?>
		</div>
		<?php } ?>
		<div class="container-contact3">
			<div class="wrap-contact3" style="width: 90%;">
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

				<div style="text-align: right;">
					<label class="switch">
					  	<input type="checkbox" id="active-form" <?php echo ($result2 == '0')? 'checked':'' ; ?>>
					  	<span class="slider round"></span><br>
						<label class="label-contact3" style="margin-top: 20px; color: white;">Active form</label>
					</label>
				</div>
				<br>
				<br>
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
							</tr>
						</thead>
						<tbody>
							<?php while ($row = mysql_fetch_assoc($result)) { $id = $row['students_id']; $email = $row['email']; ?>
							<tr>
								<td class="text-center" data-toggle="popover" title="Approved/Denied by:" data-placement="top" data-content="<?php echo ' '.$row['users_name']; ?>"><?php echo $row['users_name']; ?></td>
								<td class="btn-group text-center" data-content='<?php echo ($row["status"]=='1')? "Approve":(($row["status"]=='2')? "Deny":"Waiting" ); ?>'>
									<?php if($row['status'] == '0') {?>
									<a href="./admin-dashboard.php?id=<?php echo $id;?>&email=<?php echo $email; ?>&type=1" class="btn btn-success btn-xs">Approve</a>
									<a href="./admin-dashboard.php?id=<?php echo $id;?>&email=<?php echo $email; ?>&type=2" class="btn btn-danger btn-xs">Deny</a>									
									<?php }elseif($row['status'] == '1'){ ?>
										<b class="text-success">Approve</b>
									<?php }elseif($row['status'] == '2'){?>
										<b class="text-danger">Deny</b>
									<?php }?>
								</td>
								<td class="text-center" data-toggle="popover" title="#" data-placement="top" data-content="<?php echo ' '.$row['students_id']; ?>"><?php echo $row['students_id']; ?></td>
								<td class="text-center" data-toggle="popover" title="Name" data-placement="top" data-content="<?php echo ' '.$row['students_name']; ?>"><?php echo $row['students_name']; ?></td>
								<td class="text-center" data-toggle="popover" title="Student UFID" data-placement="top" data-content="<?php echo ' '.$row['UFID']; ?>"><?php echo $row['UFID']; ?></td>
								<td class="text-center" data-toggle="popover" title="Student Email" data-placement="top" data-content="<?php echo ' '.$row['email']; ?>"><?php echo $row['email']; ?></td>
								<td class="text-center" data-toggle="popover" title="Phone" data-placement="top" data-content="<?php echo ' '.$row['phone']; ?>"><?php echo $row['phone']; ?></td>
								<td class="text-center" data-toggle="popover" title="Major" data-placement="top" data-content="<?php echo ' '.$row['major']; ?>"><?php echo $row['major']; ?></td>
								<td class="text-center" data-toggle="popover" title="College" data-placement="top" data-content="<?php echo ' '.$row['regitration_type']; ?>"><?php echo $row['regitration_type']; ?></td>
								<td class="text-center" data-toggle="popover" title="Section" data-placement="top" data-content="<?php echo ' '.$row['section']; ?>"><?php echo $row['section']; ?></td>
								<td class="text-center" data-toggle="popover" title="Term" data-placement="top" data-content="<?php echo ' '.$row['term']; ?>"><?php echo $row['term']; ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor Name" data-placement="top" data-content="<?php echo ' '.$row['mentor_name']; ?>"><?php echo $row['mentor_name']; ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor UFID" data-placement="top" data-content="<?php echo ' '.$row['mentor_ufid']; ?>"><?php echo $row['mentor_ufid']; ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor Phone" data-placement="top" data-content="<?php echo ' '.$row['mentor_phone']; ?>"><?php echo $row['mentor_phone']; ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor Email" data-placement="top" data-content="<?php echo ' '.$row['mentor_email']; ?>"><?php echo $row['mentor_email']; ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor department" data-placement="top" data-content="<?php echo ' '.$row['mentor_department']; ?>"><?php echo $row['mentor_department']; ?></td>
								<td class="text-center" data-toggle="popover" title="Mentor College" data-placement="top" data-content="<?php echo ' '.$row['mentor_college']; ?>"><?php echo $row['mentor_college']; ?></td>
								<td class="text-center" data-toggle="popover" title="Brief description" data-placement="top" data-content="<?php echo ' '.$row['description']; ?>"><?php echo $row['description']; ?></td>
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
		}
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
		$(document).ready(() => {
			$('#table').DataTable({
		        
		        columnDefs: [ {
			        targets: [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
			        render: $.fn.dataTable.render.ellipsis(20)
			    } ],
  		        initComplete: function () {

  					$('[data-toggle="popover"]').popover({
  						trigger: 'hover'
  					});
  					$('#active-form').click(() => {		
  						if(confirm('Are you change the form status?')){		
							if( !$('#active-form').is(':checked') ) {
								document.location = './admin-dashboard.php?active=1';
							}else{
								document.location = './admin-dashboard.php?active=0';
							}
						}
					});
					paginate();
		        },

			});
    		$('#table td').css('white-space','initial');
		});
	</script>
	<script src="js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
<script>

	function ExportExcel(){
		window.open("download.php");
	}	

  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
