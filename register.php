<?php
include('db.php');

$error_username ="";
$error_password="";
$error_email="";
$error_message="";
if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password'])){
	if(empty($_POST['username'])) {
		$error_username = 'Username required. ';
	} 
	if(empty($_POST['password'])) {
		$error_password = 'Password is required. ';
	}
	if(empty($_POST['email'])) {
		$error_email= 'Email is required';
	}
}else{
	$username = mysqli_real_escape_string($connection,$_POST['username']);
	
	$password = mysqli_real_escape_string($connection,$_POST['password']);
	
	$fname = mysqli_real_escape_string($connection,$_POST['fname']);
	
	$lname = mysqli_real_escape_string($connection,$_POST['lname']);
	
	$email = mysqli_real_escape_string($connection,$_POST['email']);
	
	$gender = $_POST['gender'];
	
	$sql = "insert into cm_user(username,password,firstname,lastname,email,gender) values " .
		   "('$username','$password','$fname','$lname','$email','$gender')";
	
	$query = mysqli_query($connection,$sql);
	echo $sql;
	if($query==true){
		session_start();
		$_SESSION['user']=mysqli_insert_id($connection);
		echo 'Profiil on edukalt loodud.';
		header('Location:index.php');
	} else {
		$error_message = 'Registreerimine ebaõnnestus';
	}
}
?>


<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Register</title>
		<link rel="stylesheet" type="text/css" href="styles/main.css">
	</head>
	
	<body>
	<div id="container">
		<h1>Uue konto loomine</h1>
		<?php 
			$error = "";
			if($error_username != "" || $error_password != "" || $error_email != "") {
			$error = $error_username . "<br>" . $error_password . "<br>" . $error_email . "<br>";
		}
		?>
		<p style="color:red;"><?=$error_message?></p>
		<p style="color:red;"><?=$error?></p>
		<form method="post">
			<label>Username:</label>
			<input type="text" name="username" placeholder="kasutajanimi" maxlength="15" size="25" required>
			<label>Password:</label>
			<input type="password" name="password" placeholder="salasõna" maxlength="30" size="40" required>
			<label>First Name:</label>
			<input type="text" name="fname" placeholder="eesnimi" maxlength="70" size="80">
			<label>Last Name:</label>
			<input type="text" name="lname" placeholder="perenimi" maxlength="70" size="80">
			<label>Email Address:</label>
			<input type="email" name="email" placeholder="e-post" maxlength="50" size="60" required>
			
			<label>Gender:</label>
				<input type="radio" id="man" name="gender" value="m" checked><label for="man">men</label>
				<input type="radio" id="woman" name="gender" value="n"><label for="woman">women</label>
				<input type="radio" id="other" name="gender" value="t"><label for="other">other</label> 
			<button type="submit">Create Account</button>
		</form>
		<a href='login.php' id="login">Go Back</a>
		</div>
	<body>
</html>