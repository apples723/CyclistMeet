<?php
include('db.php');
include('session.php');
$loggedIn = isset($_SESSION['user']);

$message = "";
$message2="";
if ($loggedIn){
	$user = $_SESSION['user'];
	$query = mysqli_query($connection,"select * from cm_users where id='$id'");
	$row = $query->fetch_array(MYSQL_BOTH);
	
	$gender = $row['gender'];
	$sql="SELECT id,
username, first name, last name, gender, email, picture, welcome FROM cm_users WHERE NOT id='$user' AND NOT gender='$gender' AND NOT id IN (SELECT kylastatus_id FROM cm_kylastus WHERE kylastaja_id='$user') ORDER BY kasutajanimi ASC LIMIT 1";
	$result = mysqli_query($connection,$sql);
	$rowCount = mysqli_num_rows($result);
	if ($rowCount==0){
		$message2 = '<h1>Kasutajad said otsa!</h1>';
	}else if ($rowCount==1){
		$row = $result->fetch_array(MYSQL_BOTH);
		$id = $row['id'];
		$username = $row['username'];
		$fname = $row['firstname'];
		$lname = $row['lastname'];
		$gender = $row['gender'];
		$email = $row['email'];
		$pic = $row['pilt'];
		$greeting = $row['welcome'];
	}
}

if(isset($_POST['opinion'])){
	$user = $_SESSION['user'];
	$opinion = $_POST['opinion'];
	
	$sql="";
	if($opinion === "like"){
		$sql = "INSERT INTO cm_data(user, id, like) VALUES ('$user','$id', 'l')";
	} else {
		$sql = "INSERT INTO cm_data(user, id, like) VALUES ('$user','$id', 'd')";
	}
	echo $sql;
	$query = mysqli_query($connection,$sql);
	if($query==true){
		header('Location:showusers.php');
	} else {
		$message = 'Miski läks valesti. Proovi veel kord.';
	}
}
	

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Tutvumised</title>
<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
<div id="container">

<?php if ($loggedIn):?>
<?=$message2?>
<?php if ($rowCount==1) {?>
<h1><?=htmlentities ($username,ENT_QUOTES)?></h1>
<h3><?=htmlentities ($greeting,ENT_QUOTES)?></h3>
<p>Eesnimi: <?=htmlentities ($fname,ENT_QUOTES)?></p>
<p>Perenimi: <?=htmlentities ($lname,ENT_QUOTES)?></p>
<p>Sugu: <?=htmlentities ($gender,ENT_QUOTES)?></p>
<p>E-post: <?=htmlentities ($email,ENT_QUOTES)?></p>
<?php if ($pic==""){
} else {
	echo '<img src="data:image/jpeg;base64,'. htmlentities ($pic,ENT_QUOTES).'" alt="photo" id="portrait">';
}	
?>
<?=$message?>
<div id="opinion_div">
<form method="post" action="showusers.php" id="opinion_form">
<button type="submit" name="opinion" id="opinion" value="like">LIKE</button>
</form>

<form method="post" action="showusers.php" id="opinion_form">
<button type="submit" name="opinion" id="opinion" value="nope">NOPE</button>
</form>
</div>
<?php } ?>
<a href='index.php' id="index">Pealehele</a>
<?php else: ?>
<div>
<a href='login.php' id="login">Sisene</a>
</div>
<div></div>
<?php endif; ?>
</div>
</body>
</html>