<?php
include('db.php');
session_start();
$loggedIn = isset($_SESSION['user']);
$message = "Sinu profiili pole kylastatud.";
$data_about_visiters = "";
if ($loggedIn){
	include('session.php');
	$user = $_SESSION['user'];
	$query = mysqli_query($connection,"select * from cm_user where id=$user");
	$row = $query->fetch_array(MYSQL_BOTH);
	$fname = $row['firstname'];
	$lname = $row['lastname'];
	$gender = $row['gender'];
	$email = $row['email'];
	$pic = $row['pilt'];
	$greeting = $row['welecome'];
	
	
	$sql= "SELECT cm_user.username, cm_data.timestamp, cm_data.yesorno FROM cm_user,cm_data where cm_data.id=user_up_id and cm_data.user_id = $user";
	$query = mysqli_query($connection,$sql);
	$rowCount = mysqli_num_rows($query);

	if($rowCount > 0) {
		$message = '<p id="message_about_visiting">Sinu profiili külastasid järgmised kasutajad:</p>';
	}

	while ($row = mysqli_fetch_array($query)) {
		$timestamp= $row['timestamp'];
		$visiter= $row['username'];
		$opinion= $row['hinnang'];
		if ($opinion == "l"){
			$opinion = "LIKE";
		} else {
			$opinion = "NOPE";
		}
		$data_about_visiters = $data_about_visiters .
		'<tr>'.
		'<td>'.$timestamp.'</td>'.
		'<td>'.$visiter.'</td>'.
		'<td>'.$opinion.'</td>'.
		'</tr>';
    }



}

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Tere tulemast!</title>
<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
<div id="container">
<?php if ($loggedIn):?>
<h1>Tere tulemast, <?=htmlentities($user_from_db['kasutajanimi'],ENT_QUOTES)?>!</h1>
<h3><?=htmlentities($greeting,ENT_QUOTES)?></h3>
<p>Eesnimi: <?=htmlentities($fname,ENT_QUOTES)?></p>
<p>Perenimi: <?=htmlentities($lname,ENT_QUOTES)?></p>
<p>Sugu: <?=$gender?></p>
<p>E-post: <?=htmlentities($email,ENT_QUOTES)?></p>
<?php if ($pic==""){
} else {
	echo '<img src="data:image/jpeg;base64,'. htmlentities($pic,ENT_QUOTES).'" alt="photo" id="portrait">';
}	
?>
<ol>
<li><a href='showusers.php' id="link">Tutvumised</a></li>
<li><a href='data.php' id="link">Muuda andmed</a></li>
<li><a href='logout.php' id="link">Välju</a></li>
</ol>
<div id="visitors">
<?=$message?>
<table id="visitors_table">
<?=$data_about_visiters?>
</table>
</div>
<?php else: ?>
<h1 id="headerOne">Tere tulemast!</h1>
<div>
<a href='login.php' class="login" id="login">Sisene</a>
</div>
<?php endif; ?>
</div>
</body>
</html>