<?php
require("Configure.php");
/*echo "<pre>";
print_r($_POST);
exit;*/
$operation=isset($_POST['opera']) ? $_POST['opera'] : 'Add';//Register or Update (user_id needed in Update)
$brand_id=isset($_POST['brand_id']) ? $_POST['brand_id'] : 0 ;//Used To Update user record.
$brand_name=isset($_POST['brand_name']) ? $_POST['brand_name'] : 'anonymous_brand';
$brand_photo=strlen($_POST['brand_photo']) ?save_image('brand',$_POST['brand_photo']) : $ApplicationSettings['default_brand_photo'];
$is_active= 1;
$deleted= 0;

$brand_created_time=$ApplicationSettings['ServerDateTime'];
$brand_updated_time= $ApplicationSettings['ServerDateTime'];

																										
$insert_id=0;
$affected_rows=0;
$format=set_format();
$brandname_available=1;
/*************Check Username available or Not************/
$brandname_available=check_brand_availability($brand_name);
	
	if($brandname_available == 0 && $operation=='Add')// 
	{
		$post=array();
		$post['message']="Brand Already Exist";		
		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=array("post" => $post);//String for json	
	}
	else if($brandname_available == 1 && $operation=='Add')
	{
		$query="INSERT INTO  `brand` (`id` ,`brand_name` ,`brand_photo` ,`is_active` ,`deleted` ,`brand_created_time` ,`brand_updated_time`)
		VALUES (NULL ,  '$brand_name',  '$brand_photo',  $is_active,  $deleted,  '$brand_created_time',  '$brand_updated_time')";
		//Enable below function to debug query
		
		//debug_query($query);	
		//exit;
		$result=mysqli_query($con,$query);
		$insert_id=mysqli_insert_id($con);
		
	}
	else if($operation=='Update' && $brand_id != 0 )
	{
		$query="UPDATE `brand` SET 
		`brand_name` = '$brand_name',
		`brand_photo` = '$brand_photo',
		`is_active` = '$is_active',
		`deleted` = '$deleted',
		`brand_created_time` = '$brand_created_time',
		`brand_updated_time` = '$brand_updated_time'		
		WHERE `brand`.`id` =$brand_id";
		//Enable below function to debug query
		//debug_query($query);		
		//exit; 	
		$result=mysqli_query($con,$query);
		$affected_rows=mysqli_affected_rows($con);
	
	}	
	else//Invalid Operation.
	{
		$post["Error"]="Invalid Operation";
		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=$post;//String for json
	}
	
/************Preparing Final output***************/	
	if($insert_id!=0 || $affected_rows!=0 )
	{
		if ($insert_id!=0)
		$query="SELECT * FROM `brand` WHERE `id`=$insert_id";	
		
		if ($affected_rows!=0)
		$query="SELECT * FROM `brand` WHERE `id`=$brand_id";	
		$result="";
		$result=mysqli_query($con,$query);	
		while($post=mysqli_fetch_assoc($result))
		{	
			$post['brand_photo']=add_site_url($post['brand_photo']);		
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
displayNativeXmlOutput($result_xml);
if($format=='json')
displayJsonOutput($result_json);

?>