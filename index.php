<?php

	$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
	mysql_select_db("bioinformatics") or die(mysql_error());
	$sql = 'SELECT `id`, `name`, `value` FROM `config` WHERE `id` = 1 AND `value`="0"';
	$form = mysql_query($sql);
	$row2 = mysql_fetch_assoc($form);
	$result2 = $row2['value'];	
	$message = '';
	$alert = '';
	if($result2 != '0'){
		header("Location: ./error.html");
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$name = $_POST['name'];
		$ufid = $_POST['ufid'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$major = $_POST['major'];
		$regitration_type = $_POST['regitration_type'];
		$section = $_POST['section'];
		$term = $_POST['term'];
		$year = $_POST['year'];
		$mentor_name = $_POST['mentor_name'];
		$mentor_ufid = $_POST['mentor_ufid'];
		$mentor_email = $_POST['mentor_email'];
		$mentor_phone = $_POST['mentor_phone'];
		$mentor_department = $_POST['mentor_department'];
		$mentor_college = $_POST['mentor_college'];
		$brief_description = $_POST['brief_description'];


		$name = stripslashes($name);
		$ufid = stripslashes($ufid);
		$email = stripslashes($email);
		$phone = stripslashes($phone);
		$major = stripslashes($major);
		$regitration_type = stripslashes($regitration_type);
		$section = stripslashes($section);
		$term = stripslashes($term);
		$year = stripslashes($year);
		$mentor_name = stripslashes($mentor_name);
		$mentor_ufid = stripslashes($mentor_ufid);
		$mentor_email = stripslashes($mentor_email);
		$mentor_phone = stripslashes($mentor_phone);
		$mentor_department = stripslashes($mentor_department);
		$mentor_college = stripslashes($mentor_college);
		$brief_description = stripslashes($brief_description);
		$aux = htmlspecialchars($brief_description);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$alert = 'E-mail is not a valid email';
		}
		if (!filter_var($mentor_email, FILTER_VALIDATE_EMAIL)) {
			$alert = 'Mentor E-mail is not a valid email';
		}
		if(strlen($phone) != 10){
			$alert = 'Phone number must to have 10 digits';
		}
		if(strlen($mentor_phone) != 10){
			$alert = 'Mentor phone number must to have 10 digits';
		}

		if($term != "0" && $year != "0" && $alert == ''){
			$sql = 'INSERT INTO `students`(`name`, `UFID`, `email`, `phone`, `major`, `regitration_type`, `section`, `term`, `mentor_name`, `mentor_ufid`, `mentor_email`, `mentor_phone`, `mentor_department`, `mentor_college`, `description`) VALUES ("'.$name.'","'.$ufid.'","'.$email.'","'.$phone.'","'.$major.'","'.$regitration_type.'","'.$section.'","'.$term.' '.$year.'","'.$mentor_name.'","'.$mentor_ufid.'","'.$mentor_email.'","'.$mentor_phone.'","'.$mentor_department.'","'.$mentor_college.'","'.$aux.'")';
			mysql_query($sql) or die(mysql_error());

			mysql_close();
			$message = 'Application submitted successfully!';
		}else{
			if($term == "0"){
				$alert = 'You must select a term valid';
			}elseif($year == "0"){
				$alert = 'You must select a year valid';
			}
		}
	}
	$sql="SELECT * FROM terms";
	$terms = mysql_query($sql);	
	$sql="SELECT * FROM section";
	$section = mysql_query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bioinformatic Form</title>
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
</head>
<body>

	<div class="bg-contact3" style="background-image: url('images/bg-01.jpg');">
		<?php if($message != ''){ ?>
		<div class="alert alert-success" role="alert">
			<?php echo $message; ?>
		</div>
		<?php } ?>
		<?php if($result2 != '0'){ ?>
		<div class="alert alert-warning" role="alert">
			The form is closed
		</div>
		<?php } ?>
		<?php if($alert != ''){ ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $alert; ?>
		</div>
		<?php } ?>
		<div class="container-contact3">
			<div class="wrap-contact3">
				<img src="./images/banner.jpeg" class="wrap-image">
				<form class="contact3-form validate-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<span class="contact3-form-title">
						Student Information
					</span>

					<div class="wrap-input3 validate-input" data-validate="Name is required">
						<input class="input3" type="text" name="name" placeholder="Name" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="UFID is required">
						<input class="input3" type="text" name="ufid" placeholder="UFID#" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input3" type="email" name="email" placeholder="Your Email">
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="UFID is required">
						<input class="input3" type="number" name="phone" placeholder="Student Phone #" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Major is required">
						<input class="input3" name="major" placeholder="Major" required>
						<span class="focus-input3"></span>
					</div>


					<div class="wrap-contact3-form-radio">
						<div class="contact3-form" style="color: white;">
							Registration For
						</div>
						<br>
						<div class="contact3-form-radio m-r-42">
							<input class="input-radio3" id="radio1" type="radio" name="regitration_type" value="BSC4913" checked="checked">
							<label class="label-radio3" for="radio1">
								BSC4913
							</label>
						</div>

						<div class="contact3-form-radio">
							<input class="input-radio3" id="radio2" type="radio" name="regitration_type" value="BSC4914">
							<label class="label-radio3" for="radio2">
								BSC4914
							</label>
						</div>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Class Number is required">
						<input class="input3" name="section" placeholder="Class Number" required>
						<span class="focus-input3"></span>
					</div>

					<div class="row">
						<div class="wrap-input3 col-lg-6 col-md-6 col-xs-6">
							<div>
								<select class="selection-2" name="term">
									<option value="0">Term:</option>
									<option value="Fall">Fall</option>
									<option value="Spring">Spring</option>
								</select>
							</div>
							<span class="focus-input3"></span>
						</div>
						<div class="wrap-input3 col-lg-6 col-md-6 col-xs-6">
							<div>
								<select class="selection-2" name="year">
									<option value="0">Year:</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
								</select>
							</div>
							<span class="focus-input3"></span>
						</div>
					</div>

					<br>
					<br>

					<span class="contact3-form-title">
						Research Mentor Information
					</span>
					
					<div class="wrap-input3 validate-input" data-validate="Mentor name is required">
						<input class="input3" name="mentor_name" placeholder="Mentor Name" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Mentor UFID is required">
						<input class="input3" type="text" name="mentor_ufid" placeholder="Mentor UFID" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Mentor Email is required">
						<input class="input3" type="email" name="mentor_email" placeholder="Mentor Email" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Mentor Phone is required">
						<input class="input3" type="number" name="mentor_phone" placeholder="Mentor Phone" required>
						<span class="focus-input3"></span>
					</div>
					
					<div class="wrap-input3 validate-input" data-validate="Mentor Department is required">
						<input class="input3" name="mentor_department" placeholder="Mentor Department" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Mentor College is required">
						<input class="input3" name="mentor_college" placeholder="Mentor College" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate = "Brief Description is required">
						<textarea class="input3" name="brief_description" placeholder="Brief Description of research project (conceptual, 4 sentences):" required></textarea>
						<span class="focus-input3"></span>
					</div>
					<?php if($result2 == '0'){ ?>
					<div class="container-contact3-form-btn text-center" style="text-align: center;">
						<button class="contact3-form-btn" id="submit-button">
							Submit
						</button>
					</div>
					<?php } ?>
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
	<script src="js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
