<?php
//echo"<pre>";
//print_r($_POST);
//exit;
require("Configure.php");
$format=set_format();

	$query="SELECT * FROM `splash` WHERE `is_active`=1 AND `deleted`=0 ";	
	$result="";
	$result=mysqli_query($con,$query);	
	//if(mysqli_num_rows($result))
	{
	  while($post=mysqli_fetch_assoc($result))
	  {	
		  
		  $post['splash_images']=add_site_url($post['splash_images']);				  
		  $result_xml.=getAttrTagString($post);//String for XML
		  $result_json[]=$post;//String for json
	  }
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