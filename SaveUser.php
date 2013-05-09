<?php
require_once("Configure.php");
/*echo "<pre>";
print_r($_POST);
exit;*/
$operation=isset($_POST['operation']) ? $_POST['operation'] : 'Register';//Register or Update (user_id needed in Update)
$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0 ;//Used To Update user record.
$fullname=isset($_POST['fullname']) ? $_POST['fullname'] : '';
$fullname=strlen($_POST['fullname']) ? $_POST['fullname'] : '';
$username=isset($_POST['username']) ? $_POST['username'] : 'anonymous_username';
$password=isset($_POST['password']) ?  $_POST['password'] : $ApplicationSettings['Defaultpass'];
$encrypted_pass=md5($password);//used to store in db      
$user_email=isset($_POST['user_email']) ? $_POST['user_email'] : '';
$cover_photo=strlen($_POST['cover_photo']) ? save_image('avatars',$_POST['cover_photo']) : $ApplicationSettings['default_cover_photo'];
$profile_photo=strlen($_POST['profile_photo']) ?  save_image('avatars',$_POST['profile_photo']) : $ApplicationSettings['default_profile_photo'];
$udid = isset($_POST['udid']) ? $_POST['udid'] : 'unknown_udid_1';
$is_active= 1;
$deleted= 0;
$user_created_time=$ApplicationSettings['ServerDateTime'];
$user_updated_time=$ApplicationSettings['ServerDateTime'];
$last_login_time= $ApplicationSettings['ServerDateTime'];

																										
$insert_id=0;
$affected_rows=0;
$format=set_format();
$username_available=1;
/*************Check Username available or Not************/
$username_available=check_username_availability($username,$user_email);
//if($username_available)
//{
//if($username!='' && $password!='' && $user_email!='')
//{
	if($operation=='Register' && $username_available ==1)
	{
		$query="INSERT INTO `users` (`id` ,`fullname`,`username` ,`password` ,`user_email` ,`cover_photo` ,`profile_photo`,`udid` ,`is_active` ,`deleted` ,`user_created_time` ,`user_updated_time` ,`last_login_time`)
	VALUES (NULL, '$fullname' , '$username', '$encrypted_pass', '$user_email', '$cover_photo', '$profile_photo', '$udid',$is_active, $deleted,'$user_created_time', '$user_updated_time', '$last_login_time')";
		//Enable below function to debug query
		//debug_query($query);	
		$result=mysqli_query($con,$query);
		$insert_id=mysqli_insert_id($con);
		
	}
	else if ($operation=='Register' && $username_available ==0)
	{
		$post=array();
		$post['message']="Username Not Available";		
		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=$post;//String for json	
	
	}
	else if($operation=='Update' && $user_id != 0 )
	{
		$query="UPDATE `users` SET 
		`fullname` = '$fullname',
		`username` = '$username',
		`user_email` = '$user_email',
		`cover_photo` = '$cover_photo',
		`profile_photo` = '$profile_photo',
		`udid` = '$udid''
		`is_active` = $is_active,
		`deleted` = $deleted,	
		`user_updated_time` = '$user_updated_time',
		`last_login_time` = '$last_login_time'
		WHERE `users`.`id` =$user_id";
		//Enable below function to debug query
		//debug_query($query);		
		$result=mysqli_query($con,$query);
		$affected_rows=mysqli_affected_rows($con);
	
	}
	
	else//Invalid Operation.
	{
		$post['message']="! Error";
		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=$post;//String for json
	}
//}
//else
//{
//		$post['message']="Username, Password & email can not be empty.";
//		$result_xml.=getAttrTagString($post);//String for XML
//		$result_json[]=array("post" => $post);//String for json	
//}
	if($insert_id!=0 || $affected_rows!=0 )
	{
		if ($insert_id!=0)
		$query="SELECT * FROM `users` WHERE `id`=$insert_id";	
		
		if ($affected_rows!=0)
		$query="SELECT * FROM `users` WHERE `id`=$user_id";	
		$result="";
		$result=mysqli_query($con,$query);	
		while($post=mysqli_fetch_assoc($result))
		{	
			if ($insert_id!=0)
			{
				$post['password']=$password;
			}
			$post['cover_photo']=add_site_url($post['cover_photo']);		
			$post['profile_photo']=add_site_url($post['profile_photo']);
			$result_xml.=getAttrTagString($post);//String for XML
			$result_json[]=$post;//String for json
		}
	}
//}
//else
	
//echo"<pre>";
//print_r($result_json);
//exit;
//echo $format;
//exit;
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='json')
displayJsonOutput($result_json);
if($format=='nxml')
displayNativeXmlOutput($result_json);

?>