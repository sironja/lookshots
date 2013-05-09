<?php
//echo"<pre>";
//print_r($_POST);
//exit;
require("Configure.php");
$format=set_format();
$searchstring=isset($_POST['username']) ? $_POST['username'] : '';
//$password=isset($_POST['password']) ?  $_POST['password'] : $ApplicationSettings['Defaultpass'];
//$encrypted_pass=md5($password);//used to store in db

$query="SELECT * FROM `users` WHERE `username` LIKE '$searchstring%' order by user_created_time desc limit 32";
//echo $query;
//exit;

$result=mysqli_query($con,$query);	
if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['cover_photo']=add_site_url($post['cover_photo']);
	  $post['profile_photo']=add_site_url($post['profile_photo']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]= $post;//String for json	
}
//echo"<pre>";
//print_r($result_json);
//exit;
//$format='nxml';
$format='json';
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);