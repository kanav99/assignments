<?php
	session_start();
	$db = new mysqli('localhost', 'root', 'password', 'titbits');
	if (!$db) {
	 die("Connection failed: " . mysqli_connect_error());
	}
	if(!isset($_SESSION['admin'])) {
		header('location:index.php');
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
		<div id="account-nav">
			<a class="btn btn-secondary" href="logout.php">Logout</a>
		</div>
	</div>
	<div class="row" id="main">
		<div class="col-sm-9" id="paste">
			<h4>Your Bits</h4>
			<ul class="list-group">
				<?php
					$q="select * from bit_table where owner='".$_SESSION['admin']."'";
					$result = $db->query($q);
					while($row = $result->fetch_assoc()) {
						$x = '';
						if($row['private']==1)
							$x = '<i style="position:absolute;right:5px;top:5px;">Private</i>';
						echo '<li class="list-group-item">
								<a href="paste.php?id='.$row['id'].'"><h6>'.$row['title'].'(#'.$row['id'].')</h6></a>'.$x.'
								<textarea class="form-control" readonly>'.$row['paste'].'</textarea>
							  </li>';
					}
				?>
			</ul>
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
</body>
</html>