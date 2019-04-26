<?php 
	$error = '';
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$mysql_id = mysql_connect("localhost","root","") or die(mysql_error());
		mysql_select_db("bioinformatics") or die(mysql_error());

		$name = $_POST['name'];
		$password = $_POST['password'];

		$name = stripslashes($name);
		$password = stripslashes($password);

		$sql="SELECT password FROM users WHERE name='".$name."'";

	    $result = mysql_query($sql);

	    $cont = 0;
	    $presult = '';
	    while ($row = mysql_fetch_assoc($result)) {
	    	$cont++;
	    	$presult = $row['password'];
		}
	    if($cont == 0){
			$error = 'Name not found';
	    }else{
	    	if($password != $presult){
	    		$error = 'Password incorrect';
	    	}else{
		    	header("Location: /portal1.php");
		    }
	    }
	}
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
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
</head>
<body>

	<div class="bg-contact3" style="background-image: url('images/bg-01.jpg');">
			<?php if($error != ''){ ?>
			<div class="alert alert-danger" role="alert">
				<?php echo $error; ?>
			</div>
			<?php } ?>
		<div class="container-contact3">
			<div class="wrap-contact3">
				<img src="./images/banner.jpeg" class="wrap-image">
				<form class="contact3-form validate-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<span class="contact3-form-title" style="padding-bottom: 0px;">
						Dashboard
					</span>
					<label class="label-contact3">
						Student Approval List
					</label>
					<div class="wrap-input3 validate-input" data-validate="Name is required">
						<input class="input3" type="text" name="name" placeholder="Name" required>
						<span class="focus-input3"></span>
					</div>

					<div class="wrap-input3 validate-input" data-validate="Password is required">
						<input class="input3" type="password" name="password" placeholder="Password" required>
						<span class="focus-input3"></span>
					</div>

					<div class="container-contact3-form-btn text-center" style="text-align: center;">
						<button class="contact3-form-btn">
							Submit
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js"></script>
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
