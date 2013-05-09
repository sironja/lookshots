<?php
/**********************Database Connection **************/
$con = mysqli_connect("localhost","lookshot_user1","user1","lookshot_db");
$_SESSION['con']=$con;
if(mysqli_connect_errno())
{
	echo "Failed to Connect to MySQL : ".mysqli_connect_error();
}
?>