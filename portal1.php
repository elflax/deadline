<?php
	session_start();
	if(isset($_SESSION['id'])){
		header("Location: /login-portal1.php");
	}
	$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());
	$sql="SELECT * FROM students";
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
		<div class="container-contact3">
			<div class="wrap-contact3" style="width: 900px;">
				<img src="./images/banner.jpeg" class="wrap-image">
				<span class="contact3-form-title" style="padding-bottom: 0px;">
					Dashboard
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
								<th>Mentor Email</th>
								<th>Mentor department</th>
								<th>Mentor College</th>
								<th>Brief description</th>
								<th>Approved/Denied by:</th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = mysql_fetch_assoc($result)) { $id = $row['id'];?>
							<tr>
								<td class="btn-group">
									<button class="btn btn-success btn-xs" <?php echo ($row['status'] != 0)? 'disabled':''; ?> onclick="aprove('<?php echo $id;?>')">Approve</button>
									<button class="btn btn-danger btn-xs" <?php echo ($row['status'] != 0)? 'disabled':''; ?> onclick="aprove('<?php echo $id;?>')">Deny</button>
								</td>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['UFID']; ?></td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['phone']; ?></td>
								<td><?php echo $row['major']; ?></td>
								<td><?php echo $row['regitration_type']; ?></td>
								<td><?php echo $row['section']; ?></td>
								<td><?php echo $row['term']; ?></td>
								<td><?php echo $row['mentor_name']; ?>2019</td>
								<td><?php echo $row['mentor_ufid']; ?></td>
								<td><?php echo $row['mentor_email']; ?></td>
								<td><?php echo $row['mentor_phone']; ?></td>
								<td><?php echo $row['mentor_department']; ?></td>
								<td><?php echo $row['mentor_college']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['aprovated_by']; ?></td>
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
		function aprove(id){			
        	var url = './ajax/aprove.php';
        	$.ajax({
	          	url: url,
	          	type: 'post',
	          	data: {id: id},
	          	dataType: "json",
	          	success: function(data) {
	          		alert(data);
	          	},
	          	async: false
	        });
		}
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
