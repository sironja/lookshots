<?php
require("Configure.php");
//echo "<pre>";
//print_r($_POST);
//exit;
$operation=isset($_POST['action']) ? $_POST['action'] : 'Add';//Add or Update (user_id needed in Update)
$tag_id=isset($_POST['tag_id']) ? $_POST['tag_id'] : 0 ;//Used To Update user record.
//$tag_on_type=isset($_POST['tag_on_type']) ? $_POST['tag_on_type'] : 'media';//Media Id
$item_id = isset($_POST['item_id']) ? $_POST['item_id'] : 0;
$tag_on=isset($_POST['tag_on']) ? $_POST['tag_on'] : 0;
$brand_id= isset($_POST['brand_id']) ? $_POST['brand_id'] : 0;
$retailer_id= isset($_POST['retailer_id']) ? $_POST['retailer_id'] : 0;
$tag_position=isset($_POST['tag_position']) ?  $_POST['tag_position'] : '';
$tag_by=isset($_POST['tag_by']) ? $_POST['tag_by'] : 0;//User or friend id who is doing tag
$is_active= 1;
$deleted= 0;

$tag_created_time=$ApplicationSettings['ServerDateTime'];
$tag_updated_time= $ApplicationSettings['ServerDateTime'];

																										
$insert_id=0;
$affected_rows=0;
$format=set_format();
if($operation=='Add')
{
	$query="INSERT INTO `tags` (`id` ,`tag_on` ,`brand_id`,`retailer_id`,`item_id`,`tag_position` ,`tag_by` ,`is_active` ,`deleted` ,`tag_created_time` ,`tag_updated_time`)
	VALUES (NULL , '$tag_on','$brand_id','$retailer_id','$item_id', '$tag_position', $tag_by, $is_active, $deleted, '$tag_created_time', '$tag_updated_time')";
	//Enable below function to debug query
	//debug_query($query);	
	//exit;
	$result=mysqli_query($con,$query);
	$insert_id=mysqli_insert_id($con);
	
}
else if($operation=='Update' && $tag_id != 0 )
{
	$query="UPDATE `tags` SET  
	`tag_on`=$tag_on,
	`tag_position`='$tag_position',
	`tag_by`=$tag_by,	
	`is_active`=$is_active,
	`deleted`=$deleted,
	`tag_updated_time`='$tag_updated_time' 
	WHERE id=$tag_id";
	//Enable below function to debug query
	//debug_query($query);		
	$result=mysqli_query($con,$query);
	$affected_rows=mysqli_affected_rows($con);

}
else//Invalid Operation.
{
	$post['message']="Invalid Operation.";
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json
}

if($insert_id!=0 || $affected_rows!=0 )
{
	if ($insert_id!=0)
	$query="SELECT * FROM `tags` WHERE `id`=$insert_id";	
	
	if ($affected_rows!=0)
	$query="SELECT * FROM `tags` WHERE `id`=$tag_id";	
	$result="";
	$result=mysqli_query($con,$query);	
	while($post=mysqli_fetch_assoc($result))
	{	
		
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
