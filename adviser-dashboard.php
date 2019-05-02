<?php
	session_start();
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
			<div class="wrap-contact3" style="width: 92%;">
				<img src="./images/banner.jpeg" class="wrap-image">
				<span class="contact3-form-title" style="padding-bottom: 0px;">
					Applicants
				</span>
				<div class="cont" style="width: 100%; overflow-x: auto;">
					<table id="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>UFID</th>
								<th>Email</th>
								<th>Major</th>
								<th>College</th>
								<th>Section Term</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row = mysql_fetch_assoc($result)) {?>
							<tr>
								<td class="text-center" data-toggle="popover" title="Name" data-placement="top" data-content="<?php echo ' '.$row['name']; ?>"><?php echo $row['name']; ?></td>
								<td class="text-center" data-toggle="popover" title="UFID" data-placement="top" data-content="<?php echo ' '.$row['UFID']; ?>"><?php echo $row['UFID']; ?></td>
								<td class="text-center" data-toggle="popover" title="Email" data-placement="top" data-content="<?php echo ' '.$row['email']; ?>"><?php echo $row['email']; ?></td>
								<td class="text-center" data-toggle="popover" title="Major" data-placement="top" data-content="<?php echo ' '.$row['major']; ?>"><?php echo $row['major']; ?></td>
								<td class="text-center" data-toggle="popover" title="College" data-placement="top" data-content="<?php echo ' '.$row['regitration_type']; ?>"><?php echo $row['regitration_type']; ?></td>
								<td class="text-center" data-toggle="popover" title="Section Term" data-placement="top" data-content="<?php echo ' '.$row['section']; ?>"><?php echo $row['section'] .' - '. $row['term']; ?></td>
								<?php if($row['status'] == 1){ ?>
								<td class="text-center" data-toggle="popover" title="Status" data-placement="top" data-content="Approved">Approved</td>	
								<?php }else{?>
								<td class="text-center" data-toggle="popover" title="Status" data-placement="top" data-content="Deny">Deny</td>
								<?php } ?>
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
		        buttons: [{
		            extend: 'excel',
				    customize: function (xlsx) {
		                var sheet = xlsx.xl.worksheets['sheet1.xml'];
		                var numrows = 3;
		                var clR = $('row', sheet);
		                var i = -2;
		                var j = 0;
		                var tr = $('tbody tr').children();
		                $('row c ', sheet).each(function () {
		                	var content = $(tr[i]).attr('data-content');
		                	var r = $(this).attr('r');
		                	var row = parseInt(r[1]);
		                	var col = r[0];
		                	console.log(r);
		                	console.log(row > 2);
		                	console.log(content);
		                	if(row > 2 ){
		                		console.log('entra');
		                		var node1 = $(this).children()[0].nodeName
		                		var tag = $(this).children()[0];
		                		if(node1 == 'v'){
		                			$(tag).text(content);
		                		}else{
		                			var tag2 = $(tag).children()[0];
		                			$(tag2).text(content);
		                		}
		                	}
		                	i++;
		                	if(i%17 == 0){
		                		j=0;
		                	}
		                });


		                sheet.childNodes[0].childNodes[1].innerHTML = sheet.childNodes[0].childNodes[1].innerHTML;
		                console.log(sheet.childNodes[0].childNodes[1].innerHTML);
		            },
		        }],
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
