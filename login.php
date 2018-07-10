<?php
include('db.php');
session_start();
$error = "";
if(empty($_POST['username']) || empty($_POST['password'])) {
	$error = 'Please Login';
} else {
	$user=htmlspecialchars($_POST['username']);
	$pass=htmlspecialchars($_POST['password']);
	
	echo $user;
	$query = mysqli_query($connection, "select * from cm_user where username = '$user' and password = '$pass'");
	echo $query
	$rowCount = mysqli_num_rows($query);
	
	if($rowCount == 1) {
		$row = mysqli_fetch_assoc($query);
		$_SESSION['user'] = $row['id'];
		//echo $_SESSION['user'];
		header('Location: index.php');
		exit;
	} else {
		$error = 'Incorrect Username and Password';
	}
}

function cleanInput($value){
	$value = preg_replace("/[\'\")(;|`,<>]/", "", $value); 
	return $value;
} 
?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Sisene</title>
<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>

<div id="container">
<h1>Sisene</h1>
<p style="color:red;"><?=$error?></p>
<form method="post">
	<table>
		<tr>
			<td>
				<label id="userLabel">Username: </label>
			</td>
			<td>
				<input type="text" id="username" name="username" placeholder="Username">
			</td>
		</tr>
		<tr>
			<td>
				<label id="passLabel">Password: </label>
			</td>
			<td>
				<input type="password" id="password" name="password" placeholder="Password">
			</td>
		</tr>
	</table>
	<button type="submit" id="submit">Log In</button>
</form>
<div>
<p>Don't have an account?</p>
<a href='register.php' id="register">Register</a>
</div>
<a href='index.php' id="index">Go back</a>
</div>

</body>
</html>