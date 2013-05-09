<?php
require("Configure.php");
//echo "<pre>";
//print_r($_POST);
//exit;
$operation=isset($_POST['operation']) ? $_POST['operation'] : 'Add';//Register or Update (user_id needed in Update)
$item_id=isset($_POST['item_id']) ? $_POST['item_id'] : 0 ;//Used To Update user record.
$item_name=isset($_POST['item_name']) ? $_POST['item_name'] : 'anonymous_item';
$item_photo=strlen($_POST['item_photo'])? save_image('item',$_POST['item_photo']) : $ApplicationSettings['default_item_photo'];

$is_active=isset($_POST['is_active']) ? $_POST['is_active'] : 1;
$deleted=isset($_POST['deleted']) ? $_POST['deleted'] : 0;
$item_created_time=$ApplicationSettings['ServerDateTime'];
$item_updated_time= $ApplicationSettings['ServerDateTime'];
$insert_id=0;
$affected_rows=0;
$format=set_format();

$itemname_available=1;
/*************Check Username available or Not************/
$itemname_available=check_item_availability($item_name);
	if($itemname_available == 0 && $operation=='Add')// 
	{
		$post=array();
		$post['message']="item Already Exist";		
		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=$post;//String for json	
	}
	else if($itemname_available == 1 && $operation=='Add')
	{  
		$query="INSERT INTO  `item` (`id` ,`item_name` ,`item_photo`,`is_active` ,`deleted` ,`item_created_time` ,`item_updated_time`)
		VALUES (NULL ,  '$item_name','$item_photo',  $is_active,  $deleted,  '$item_created_time',  '$item_updated_time')";

		//Enable below function to debug query
		
		//debug_query($query);	
		//exit;
		$result=mysqli_query($con,$query);
		$insert_id=mysqli_insert_id($con);
		
	}
	else if($operation=='Update' && $item_id != 0 )
	{
		$query="UPDATE `item` SET 
		`item_name` = '$item_name',		
		`is_active` = '$is_active',
		`deleted` = '$deleted',
		`item_created_time` = '$item_created_time',
		`item_updated_time` = '$item_updated_time'		
		WHERE `item`.`id` =$item_id";
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
		$query="SELECT * FROM `item` WHERE `id`=$insert_id";	
		
		if ($affected_rows!=0)
		$query="SELECT * FROM `item` WHERE `id`=$item_id";	
		$result="";
		$result=mysqli_query($con,$query);	
		while($post=mysqli_fetch_assoc($result))
		{	
		     $post['item_photo']=add_site_url($post['item_photo']);
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