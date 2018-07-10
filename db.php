<?php
$connection = mysqli_connect("localhost","st2014","progress","st2014");
if(!$connection) {
	 die('Andmebaasiga ühendamisel tekkis viga: '.mysql_connect_error());
}
?>