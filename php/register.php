<?php
	session_start();
	$db = new mysqli('localhost', 'root', 'password', 'titbits');
	if (!$db) {
	 die("Connection failed: " . mysqli_connect_error());
	}
	if(isset($_POST['fname'])&&isset($_POST['uid'])&&isset($_POST['pass'])) {
		if(empty($_POST['fname'])||empty($_POST['uid'])||empty($_POST['pass'])) {
			$message = "No fields must be blank";
		}
		else {
			$uname = mysqli_real_escape_string($db , $_POST['uid']);
			$q = "select * from userlist where username='".$uname."'";
			$result = mysqli_query($db,$q);
			$user = mysqli_fetch_array($result);
			if($user) {
				$message = "User already exists. Choose another username!";
			}
			else {
				$fname = mysqli_real_escape_string($db , $_POST['fname']);
				$uname = mysqli_real_escape_string($db , $_POST['uid']);
				$pass = md5(mysqli_real_escape_string($db , $_POST['pass']));
				$insert = "insert into userlist(name,username,password) values ('".$fname."','".$uname."','".$pass."')";
				$db->query($insert);
				$_SESSION['admin']=$_POST['uid'];
				header('location:index.php');
			}
		}
	}
?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Titbits</title>
	<link rel="shortcut icon" type="image/png" href="favicon.png"/>
	<link rel="stylesheet" type="text/css" href="css/switch.css">
</head>
<body>
	<div id="header">
		<a href="index.php"><img src="img/head.jpg"></a>
	</div>
	<div class="row" style="padding-top: 20px;">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<h4>Register at Titbits!</h4>
			<?php if(isset($message)) { echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>'.$message."
				</div>"; } ?>
			<form action="" method="post">
				<div class="form-group">
					<label for="fname">Full Name:</label>
    				<input type="text" class="form-control" id="fname" name="fname">
				</div>
				<div class="form-group">
					<label for="uid">Username:</label>
    				<input type="text" class="form-control" id="uid" name="uid">
				</div>
				<div class="form-group">
					<label for="pass">Password:</label>
    				<input type="password" class="form-control" id="pass" name="pass">
				</div>
				<button type="submit" class="btn btn-secondary">Register</button>
			</form>
		</div>
		<div class="col-sm-3"></div>
	</div>
</body>
</html>