<?php
	session_start();
	$db = new mysqli('localhost', 'root', 'password', 'titbits');
	if (!$db) {
	 die("Connection failed: " . mysqli_connect_error());
	}
	if(isset($_SESSION['admin'])) {
		header('location:home.php');
	}
	if(isset($_POST['go'])) {
		$uname = mysqli_real_escape_string($db , $_POST['username']);
		$pass = md5(mysqli_real_escape_string($db , $_POST['password']));
		$q = "select * from userlist where username='".$uname."' and password='".$pass."'";
		$result = mysqli_query($db,$q);
		$user = mysqli_fetch_array($result);
		if($user){
			$_SESSION['admin'] = $_POST['username'];
			header('location:home.php');
		}
		else {
			$message = "Invalid Username or Password";
		}
	}
	if(isset($_POST['save-btn'])) {
		$title = mysqli_real_escape_string($db , $_POST['title']);
		$text = mysqli_real_escape_string($db , $_POST['pastetext']);
		$q = "select count(*) from bit_table";
		$result = mysqli_query($db,$q);
		$row = mysqli_fetch_array($result);
		$id = $row[0] + 1;
		$q = "insert into bit_table(id,title,paste,private,owner) values ('".$id."','".$title."','".$text."',false,'')";
		$db->query($q);
		header('location:paste.php?id='.$id);
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
			<img src="img/head.jpg">
			<div id="account-nav">
				<div class="dropdown">
				  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    Sign in
				  </button>
				  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
				    <form class="px-4 py-3" action="" method="post">
					    <div class="form-group">
					      <label for="usename">Username</label>
					      <input type="text" class="form-control" name="username" placeholder="Username">
					    </div>
					    <div class="form-group">
					      <label for="password">Password</label>
					      <input type="password" class="form-control" name="password" placeholder="Password">
					    </div>
					    <div class="form-check">
					      <input type="checkbox" class="form-check-input" name="remember">
					      <label class="form-check-label" for="remember">
					        Remember me
					      </label>
					    </div>
					    <button type="submit" class="btn btn-primary" name="go">Sign in</button>
					  </form>
					  <div class="dropdown-divider"></div>
					  <a class="dropdown-item" href="register.php">New around here? Sign up</a>
				  </div>
				</div>
			</div>
		</div>
	
		<?php if(isset($message)) { echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>'.$message."
				</div>"; } ?>

		<div class="row" id="main">
			<div class="col-sm-9" id="paste">
				<h4>Paste here!</h4>
				<form action="" method="post">
				<div class="form-group">
  					<div><textarea class="form-control" rows="20" id="pastetext" name="pastetext"></textarea></div>
  					<div id="options">
  						Bit Title 
  						<input type="text" id="title" name="title">
	  					<label>
						  Private bits only availible for members
						</label>
	  					<button class="btn btn-secondary" id="save-btn" name="save-btn">Save!</button>
	  				</div>
				</div>
				</form>
			</div>
			<div class="col-sm-3" id="recent">
				<h4>Recent Public Bits</h4>
				<ul class="list-group">
					<?php
						$i = 0;
						$q = "select count(*) from bit_table";
						$result = mysqli_query($db,$q);
						$row = mysqli_fetch_array($result);
						$count = $row[0];
						while($i != 10 && $count != 0 ) {
							$q = "select * from bit_table where id=".$count;
							$result = $db->query($q);
							$row = $result->fetch_assoc();
							if($row['private'] == 0) {
								if($row['owner']=='')
									$owner="Anonymous";
								else
									$owner=$row['owner'];
								echo '<a class="list-group-item" href="paste.php?id='.$row['id'].'">
										<h6>'.$row['title'].'(#'.$row['id'].')</h6>
										<h7>By '.$owner.'</h7>
									</a>';
									$i++;
							}
							$count--;
						}
					?>
				</ul>
			</div>
		</div>
		<script type="text/javascript" src="js/script.js"></script>
	</body>
</html>