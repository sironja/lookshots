<?php
//echo"<pre>";
//print_r($_POST);
//exit;
require("Configure.php");
$format=set_format();
$searchstring=isset($_POST['searchstring']) ? $_POST['searchstring'] : '';
//$password=isset($_POST['password']) ?  $_POST['password'] : $ApplicationSettings['Defaultpass'];
//$encrypted_pass=md5($password);//used to store in db

$query="SELECT * FROM `retailer` WHERE `retailer_name` LIKE '$searchstring%'  ";
//echo $query;
//exit;

$result=mysqli_query($con,$query);	
if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['retailer_photo']=add_site_url($post['retailer_photo']);		
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]= $post;//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
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
?>
