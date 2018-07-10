<?php
$connection = mysqli_connect("localhost","svc_cycle","password","cyclistmeet_db");
if(!$connection) {
	 die('Andmebaasiga ühendamisel tekkis viga: '.mysql_connect_error());
}
?>