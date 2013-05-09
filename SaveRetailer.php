<?php
require("Configure.php");
//echo "<pre>";
//print_r($_POST);
//exit;
$operation=isset($_POST['operation']) ? $_POST['operation'] : 'Add';//Register or Update (user_id needed in Update)
$retailer_id=isset($_POST['retailer_id']) ? $_POST['retailer_id'] : 0 ;//Used To Update user record.
$retailer_name=isset($_POST['retailer_name']) ? $_POST['retailer_name'] : 'anonymous_retailer';
$retailer_photo=strlen($_POST['retailer_photo']) ? save_image('retailer',$_POST['retailer_photo']) : $ApplicationSettings['default_retailer_photo'];
$lang=isset($_POST['lang']) ? $_POST['lang'] : 0 ;
$long =isset($_POST['long']) ? $_POST['long'] : 0 ;
$place=isset($_POST['place']) ? $_POST['place'] : '';
$lat=isset($_POST['lat']) ? $_POST['lat'] : 00.0000;
$long=isset($_POST['long']) ? $_POST['long'] : 00.0000;
$is_active= 1;
$deleted= 0;
$retailer_created_time=$ApplicationSettings['ServerDateTime'];
$retailer_updated_time= $ApplicationSettings['ServerDateTime'];
$format = 'json';
																										
$insert_id=0;
$affected_rows=0;
$format=set_format();
$brandname_available=1;
/*************Check Username available or Not************/	
   if($operation=='Add')
	{
		$query="INSERT INTO `retailer` (`id`, `retailer_name`, `retailer_photo`, `place`, `lat`, `long`, `is_active`, `deleted`, `retailer_created_time`, `retailer_updated_time`) 
		VALUES (NULL, '$retailer_name', '$retailer_photo', '$place', '$lang', '$long', '$is_active', '$deleted', '$retailer_created_time', '$retailer_updated_time')";
		//Enable below function to debug query
		//echo $query;
//		exit;
		//debug_query($query);	
		//exit;
		$result=mysqli_query($con,$query);
		$insert_id=mysqli_insert_id($con);
		
	}
	else if($operation=='Update' && $retailer_id != 0 )
	{
		$query="UPDATE `lookshot_db`.`retailer` SET 
		`retailer_name` = '$retailer_name',
		`retailer_photo` = '$retailer_photo',
		`place` = '$place',
    	`lat` = '$lat',
		`long` = '$long',
		`is_active` = '$is_active',
		`deleted` = '$deleted',
		`retailer_updated_time` = '$retailer_updated_time'		
		WHERE `retailer`.`id` =$retailer_id";
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
		$query="SELECT * FROM `retailer` WHERE `id`=$insert_id";	
		
		if ($affected_rows!=0)
		$query="SELECT * FROM `retailer` WHERE `id`=$retailer_id";	
		$result="";
		$result=mysqli_query($con,$query);	
		while($post=mysqli_fetch_assoc($result))
		{	
			$post['retailer_photo']=add_site_url($post['retailer_photo']);		
			$result_xml.=getAttrTagString($post);//String for XML
			$result_json[]= $post;//String for json & nxml
		}
	}
//echo 	"formate  ".$format;
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
