<?php
require("Configure.php");
//echo "<pre>";
//print_r($_POST);
//exit;
$operation=isset($_POST['operation']) ? $_POST['operation'] : 'Register';//Register or Update (user_id needed in Update)
$like_id=isset($_POST['like_id']) ? $_POST['like_id'] : 0 ;//Used To Update user record.
//$like_on_type=isset($_GET['like_on_type']) ? $_GET['like_on_type'] : 'Feed'; //Feed or Profile
$like_on=isset($_POST['like_on']) ? $_POST['like_on'] : 0;//Id of Feed or Profile
$like_by=isset($_POST['like_by']) ?  $_POST['like_by'] : 0;
$is_active=1;
$deleted= 0;
$like_created_time=$ApplicationSettings['ServerDateTime'];
$like_created_time= $ApplicationSettings['ServerDateTime'];

																										
$insert_id=0;
$affected_rows=0;
format=set_format();
if($operation=='Register')
{
	$query="INSERT INTO `lookshot_db`.`likes` (`id` ,`like_on` ,`like_by` ,`is_active` ,`deleted` ,`like_created_time` ,`like_updated_time`)
	VALUES (NULL , '$like_on', '$like_by', '$is_active', '$deleted', '$like_created_time', '$like_created_time')";
	//Enable below function to debug query
	//debug_query($query);	
	$result=mysqli_query($con,$query);
	$insert_id=mysqli_insert_id($con);
	
}
else if($operation=='Update' && $user_id != 0 )
{
	$query="UPDATE `lookshot_db`.`likes` SET 
	`like_on` = '$like_on',
	`like_by` = '$like_by',
	`cover_photo` = '$cover_photo',
	`profile_photo` = '$profile_photo',
	`is_active` = $is_active,
	`deleted` = $deleted,	
	`like_created_time` = '$like_created_time',
	`like_created_time` = '$like_created_time'
	WHERE `users`.`id` =$user_id";
	//Enable below function to debug query
	//debug_query($query);		
	$result=mysqli_query($con,$query);
	$affected_rows=mysqli_affected_rows($con);

}
else//Invalid Operation.
{
	$post="! Error";
	$result_xml.=getAttrTagString("! Error");//String for XML
	$result_json[]=$post;//String for json
}

if($insert_id!=0 || $affected_rows!=0 )
{
	if ($insert_id!=0)
	$query="SELECT * FROM `likes` WHERE `id`=$insert_id";	
	
	if ($affected_rows!=0)
	$query="SELECT * FROM `likes` WHERE `id`=$user_id";	
	$result="";
	$result=mysqli_query($con,$query);	
	while($post=mysqli_fetch_assoc($result))
	{	
		/*if ($insert_id!=0)
		{
			$post['password']=$password;
		}*/
		//$post['cover_photo']=add_site_url($post['cover_photo']);		
		//$post['profile_photo']=add_site_url($post['profile_photo']);
		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]= $post;//String for json
	}
}

$format = 'json';
if($format=='json')
displayJsonOutput($result_json);
if($format=='xml')
displayXmlOutput($result_xml);

//echo"<pre>";
//print_r($postss);
//exit;
?>