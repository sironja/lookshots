<?php
require("Configure.php");

$operation=isset($_POST['operation']) ? $_POST['operation'] : 'Add';//Add or Update (user_id needed in Update)
$feed_id=isset($_POST['feed_id']) ? $_POST['feed_id'] : 0 ;//Used To Update user record.
$feed_owner=isset($_POST['feed_by']) ? $_POST['feed_by'] : 0;//User Who post feed
$feed_title=isset($_POST['feed_title']) ? $_POST['feed_title'] : 'My feed title';
$feed_brand=isset($_POST['feed_brand']) ?  $_POST['feed_brand'] : 0;
$feed_retailer=isset($_POST['feed_retailer']) ? $_POST['feed_retailer'] : 0;
$feed_image= isset($_POST['feed_image']) ? save_image('feed',$_POST['feed_image'],'') : $ApplicationSettings['default_feed_photo'];


$is_active= 1;
$deleted= 0;
$feed_created_time=$ApplicationSettings['ServerDateTime'];
$feed_updated_time= $ApplicationSettings['ServerDateTime'];

																										
$insert_id=0;
$affected_rows=0;
$format=set_format();
if($operation=='Add')
{
	$query="INSERT INTO `lookshot_db`.`feed` (`id` ,`feed_owner` ,`feed_title` ,`feed_image` ,`feed_brand` ,`feed_retailer` ,`is_active` ,`deleted` ,`feed_created_time` ,`feed_updated_time`)
	VALUES (NULL , $feed_owner, '$feed_title', '$feed_image', $feed_brand, $feed_retailer, $is_active, $deleted, '$feed_created_time', '$feed_updated_time')";
	//Enable below function to debug query
	//debug_query($query);	
	$result=mysqli_query($con,$query);
	$insert_id=mysqli_insert_id($con);
	
}
else if($operation=='Update' && $user_id != 0 )
{
	$query="UPDATE `feed` SET  
	`feed_owner`=$feed_owner,
	`feed_title`=$feed_title,
	`feed_image`=$feed_image,
	`feed_brand`=$feed_brand,
	`feed_retailer`=$feed_retailer,
	`is_active`=$is_active,
	`deleted`=$deleteds,
	`feed_updated_time`=$feed_updated_time 
	WHERE id=$feed_id";
	//Enable below function to debug query
	//debug_query($query);		
	$result=mysqli_query($con,$query);
	$affected_rows=mysqli_affected_rows($con);

}
else//Invalid Operation.
{
	$post="! Error";
	$result_xml.=getAttrTagString("! Error");//String for XML
	$result_json[]= $post;//String for json
}

if($insert_id!=0 || $affected_rows!=0 )
{
	if ($insert_id!=0)
	$query="SELECT * FROM `feed` WHERE `id`=$insert_id";	
	
	if ($affected_rows!=0)
	$query="SELECT * FROM `feed` WHERE `id`=$feed_id";	
	$result="";
	$result=mysqli_query($con,$query);	
	while($post=mysqli_fetch_assoc($result))
	{	
		
		$post['feed_image']=add_site_url($post['feed_image']);				
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
