<?php
	session_start();
	$db = new mysqli('localhost', 'root', 'password', 'titbits');
	if (!$db) {
	 die("Connection failed: " . mysqli_connect_error());
	}
	
	if(!isset($_SESSION['admin']))
		header("location:index.php");
	if(!isset($_GET['id']))
		header('location:index.php');
	$id = $_GET['id'];
	
	if(isset($_POST['save-btn'])) {
		$title = mysqli_real_escape_string($db , $_POST['title']);
		$text = mysqli_real_escape_string($db , $_POST['pastetext']);
		if(isset($_POST['private'])) {
			$private = 1;
		}
		else
		{
			$private = 0;
		}
		$q = "update bit_table set title='".$title."',paste='".$text."',private=".$private." where id='".$id."'";
		$db->query($q);
		header('location:paste.php?id='.$id);
	}
	$q = "select * from bit_table where id=".$id;
	$result = $db->query($q);
	if($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if($row['owner']!=$_SESSION['admin'])
			header("location:index.php"); 
	}
	else {
		header("location:index.php");
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
			<div class="dropdown">
			  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <?php 
			    	echo "Hi @".$_SESSION['admin'];
			    ?>
			  </button>
			  <?php
		  		echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="account.php">Your Bits</a>
						<a class="dropdown-item" href="logout.php">Logout</a>
					  </div>';
			  ?>
			  
			</div>
		</div>
	</div>
	<div class="row" id="main">
			<div class="col-sm-9" id="paste">
				<h4>Paste here!</h4>
				<div class="form-group">
					<form action="" method="post">
  					<div><textarea class="form-control" rows="20" id="pastetext" name="pastetext"><?php echo $row['paste']; ?></textarea></div>
  					<div id="options">
  						Bit Title 
  						<input type="text" id="title" name="title" value=<?php echo $row['title']?>>
  						Private 
	  					<label class="switch">
						  <input type="checkbox" id="private" name="private" >
						  <span class="slider round"></span>
						</label>
	  					<button class="btn btn-secondary" id="save-btn" name="save-btn">Save!</button>
	  				</div>
	  				</form>
				</div>
				<script type="text/javascript"> <?php if($row['private'] == 1) echo "document.getElementById('private').checked = true;" ?></script>
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