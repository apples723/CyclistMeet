<?php
include('db.php');

if(!isset($_SESSION)){
	session_start();
}

if(empty($_SESSION['user'])){
	header('location:index.php');
	echo 'forbidden page';
	exit;
} else {
	$id = $_SESSION['user'];
	$query = mysqli_query($connection,"select * from cm_user where id=$id");
	$user_from_db = mysqli_fetch_assoc($query);
	$row = $query->fetch_array(MYSQL_BOTH);
	echo $row;
	$fname = $row['firstname'];
	echo $fname;
	$lname = $row['lastname'];
	echo $lname;
	$gender = $row['gender'];
	echo $gender;
	$email = $row['email'];
	echo $email;
}
?>