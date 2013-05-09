<?php
//echo"<pre>";
//print_r($_POST);
//exit;
require("Configure.php");
$format=set_format();
$username=isset($_POST['username']) ? $_POST['username'] : 'anonymous_username';
$password=isset($_POST['password']) ?  $_POST['password'] : $ApplicationSettings['Defaultpass'];
$nudid =isset($_POST['udid']) ?  $_POST['udid'] : 0;
$encrypted_pass=md5($password);
$q="SELECT udid FROM `users` WHERE `username`='$username' AND `password`='$encrypted_pass' LIMIT 1";	
$res=mysqli_query($con,$q);	
$pos=mysqli_fetch_assoc($res);
if($pos['udid']==$nudid)
{
}
else
{
	$q1= "update users set `udid` = '$nudid'";
	$res1=mysqli_query($con,$q1);
}

$encrypted_pass=md5($password);//used to store in db
$query="SELECT * FROM `users` WHERE `username`='$username' AND `password`='$encrypted_pass' LIMIT 1";	
$result="";
$result=mysqli_query($con,$query);	
if(mysqli_num_rows($result))
{
	
  while($post=mysqli_fetch_assoc($result))
  {	
      
	  $post['password']=$password;		  
	  $post['cover_photo']=add_site_url($post['cover_photo']);		
	  $post['profile_photo']=add_site_url($post['profile_photo']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
else
{	
	$post['message']="Invalid Username Password";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json	
}
//echo"<pre>";
//print_r($result_json);
//exit;
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);