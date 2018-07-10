<?php
include('session.php');
include('db.php');
//session_start();
$loggedIn = isset($_SESSION['user']);
$good_message = "Sisesta uued andmed.";
$pic_error_message = "";
if ($loggedIn){
	$user = $_SESSION['user'];
	$query = mysqli_query($connection,"select * from cm_user where id=$user");
	
	$row = $query->fetch_array(MYSQL_BOTH);

	$username = $row['username'];
	$password = $row['password'];
	$fname = $row['firstname'];
	$lname = $row['lastname'];
	$gender = $row['gender'];
	$email = $row['email'];
	$pic = $row['pilt'];
	$greeting = $row['welecome'];

	
	

	if(isset($_POST['ch_action']) && $_POST['ch_action']=="go") {
		
		$username_=mysqli_real_escape_string($connection,$_POST['ch_username']);
		//echo $username . '<br>';
		$password=mysqli_real_escape_string($connection,$_POST['ch_password']);
		//echo $password . '<br>';
		$fname=mysqli_real_escape_string($connection,$_POST['ch_fname']);

		//echo $fname . '<br>';
		$lname=mysqli_real_escape_string($connection,$_POST['ch_lname']);

		//echo $lname . '<br>';
		$gender=$_POST['ch_gender'];

		//echo $gender . '<br>';
		$email=mysqli_real_escape_string($connection,$_POST['ch_email']);

		//echo $email . '<br>';
		$greeting=mysqli_real_escape_string($connection,$_POST['ch_greeting']);

		
		if($_FILES["ch_pic"]["tmp_name"] != ""){
			if(move_uploaded_file($_FILES["ch_pic"]["tmp_name"], 'uploads/' . basename($_FILES["ch_pic"]["name"]))){
				$bin_string = file_get_contents('uploads/' . basename($_FILES["ch_pic"]["name"]));
				$pic = mysqli_real_escape_string($connection,base64_encode($bin_string));
			} else {
				$pic_error_message = "Faili kirjutamine ebaõnnestus!";
			}
		}
		
		
		
		$query = mysqli_query($connection,"select * from cm_user where id='$user'");
	
		$row = $query->fetch_array(MYSQL_BOTH);

		$usernameDB = $row['username'];
		$passwordDB = $row['password'];
		$fnameDB = $row['firstname'];
		$lnameDB = $row['lastname'];
		$genderDB = $row['gender'];
		$emailDB = $row['email'];
		$picDB = $row['pilt'];
		$greetingDB = $row['welcome'];
		
		//echo $pnameDB;
		//echo $pname;
		
		if ($usernameDB==$username && $passwordDB==$password && $fnameDB==$fname && $lnameDB==$lname && 
			$genderDB==$gender&& $emailDB==$email && $picDB==$pic && $greetingDB==$greeting){
			header("Location:". $_SERVER['REQUEST_URI']);
			exit;
		}
		
		$sql="";
		if($_FILES["ch_pic"]["tmp_name"] != ""){
			$sql = "update cm_user set username='$username', password='$password', firstname='$fname', lastname='$lname'," .
					" gender='$gender', email='$email', pilt='$pic', welcome='$greeting' where id='$user';";
		} else {
			$sql = "update cm_user set username='$username', password='$password', firstname='$fname', lastname='$lname'," .
					" gender='$gender', email='$email', welcome='$greeting' where id='$user';";
		}
		
		$query = mysqli_query($connection, $sql);
	
		//echo $sql;
		//echo $query;
		if($query == TRUE) {
			$good_message = "Andmed on edukalt muudetud.";
		} else {
			$good_message = 'Ei õnnestunud andmeid muuta.';
		}
	} 
}

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Andmete muutmine</title>
<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
<div id="container">
<h1>Andmete muutmine</h1>
<h3><?=htmlentities($username,ENT_QUOTES)?> andmed</h3>
<p style="color:red;"><?=$pic_error_message?></p>
<p style="color:red;"><?=$good_message?></p>
<form method="post" id="ch_form" enctype="multipart/form-data">
<input type="hidden" id="ch_action" name="ch_action" value="go"></input>
<label for="ch_username">Kasutajanimi: </label><input type="text" id="ch_username" name="ch_username" maxlength="15" size="25" value=<?=htmlentities($username,ENT_QUOTES)?>></input>

<label>Parool: </label><input type="password" id="ch_password" name="ch_password" maxlength="30" size="25" value=<?=htmlentities($password,ENT_QUOTES)?>></input>

<label>Eesnimi: </label><input type="text" id="ch_fname" name="ch_fname" maxlength="70" size="25" value=<?=htmlentities($fname,ENT_QUOTES)?>></input>

<label>Perenimi: </label><input type="text" id="ch_lname" name="ch_lname" maxlength="70" size="25" value=<?=htmlentities($lname,ENT_QUOTES)?>></input>

<label>E-post: </label><input type="email" id="ch_email" name="ch_email" maxlength="50" size="25" value=<?=htmlentities($email,ENT_QUOTES)?>></input>

<label id="gender_label">Sugu: </label>
<?php
	if($gender == "m"){
		echo '<input type="radio" id="man" name="ch_gender" value="m" checked><label for="man">mees</label>'
		. '<input type="radio" id="woman" name="ch_gender" value="n"><label for="woman">naine</label>'
		. '<input type="radio" id="other" name="ch_gender" value="t"><label for="other">muu</label>'; 
	} else if ($gender == "n"){
		echo '<input type="radio" id="man" name="ch_gender" value="m"><label for="man">mees</label>'
		. '<input type="radio" id="woman" name="ch_gender" value="n" checked><label for="woman">naine</label>'
		. '<input type="radio" id="other" name="ch_gender" value="t"><label for="other">muu</label>';
	}else{
		echo '<input type="radio" id="man" name="ch_gender" value="m"><label for="man">mees</label>'
		. '<input type="radio" id="woman" name="ch_gender" value="n"><label for="woman">naine</label>'
		. '<input type="radio" id="other" name="ch_gender" value="t" checked><label for="other">muu</label>'; 
	}

?>
<label id="picture_label">Pilt: </label><input type="file" accept="image/*" id="ch_pic" name="ch_pic"></input>

<?php if ($pic==""){
} else {
	echo '<img src="data:image/jpeg;base64,'. htmlentities($pic,ENT_QUOTES).'" alt="photo" id="portrait">';
}	
?>

<label id="text_label">Sisesta tervitusteksti: </label>
<textarea rows="6" cols="50" id="ch_greeting" name="ch_greeting" form="ch_form">
<?=htmlentities($greeting,ENT_QUOTES)?>
</textarea>
<input type="submit" value="Säilita muudatusi"></input>


</form>

<a href='index.php' class="index">Tagasi</a>
</div>
</body>
</html>