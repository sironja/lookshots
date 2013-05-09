<?php
require("Configure.php");
require("images/media/caller.php");
//echo "<pre>";
//print_r($_POST);
//exit;

$operation=isset($_POST['action']) ? $_POST['action'] : 'Add';//Add or Update (user_id needed in Update)
$media_id=isset($_POST['media_id']) ? $_POST['media_id'] : 0 ;//Used To Update user record.
$media_owner=isset($_POST['media_owner']) ? $_POST['media_owner'] : 0;//User Who post media
$media_title=isset($_POST['media_title']) ? $_POST['media_title'] : 'My media title';
$media_tags=strlen($_POST['media_tags']) ? $_POST['media_tags'] : '';
$media_image=strlen($_POST['media_image']) ?  save_image('media',$_POST['media_image'],'') : $ApplicationSettings['default_media_photo'];
$image_type=strlen($_POST['image_type']) ? $_POST['image_type'] : '';
$is_active= 1;
$deleted= 0;
$media_created_time=$ApplicationSettings['ServerDateTime'];
$media_updated_time= $ApplicationSettings['ServerDateTime'];

																										
$insert_id=0;
$affected_rows=0;
$format=set_format();
if($operation=='Add')
{	
        $src=add_site_url($media_image);
        $dest="t_".time().".jpg";//ONLY NAME OF FIL
            $desired_width = 208;
        thumb($src, $dest, $desired_width);
        $thumb = '/images/media/'.$dest;

	$query="INSERT INTO `media` (`id` ,`media_owner` ,`media_title` ,`media_image`  ,`image_type`  ,`is_active` ,`deleted` ,`media_created_time` ,`media_updated_time`, `thumb`)
	VALUES (NULL , '$media_owner', '$media_title', '$media_image', '$image_type', $is_active, $deleted, '$media_created_time', '$media_updated_time','$thumb')";
//	echo $query;
//	exit;
	//Enable below function to debug query
	//debug_query($query);	
	$result=mysqli_query($con,$query);
	
    $insert_id=mysqli_insert_id($con);
	
}
else if($operation=='Update' && $media_id != 0 )
{
	$query="UPDATE `media` SET  
	`media_owner`=$media_owner,
	`media_title`=$media_title,
	`media_image`=$media_image,
	`image_type`=$image_type,
	`is_active`=$is_active,
	`deleted`=$deleted,
	`media_updated_time`=$media_updated_time ,
         `thumb` = '$thumb'
	WHERE id=$media_id";
	//Enable below function to debug query
	//debug_query($query);		
	$result=mysqli_query($con,$query);
	$affected_rows=mysqli_affected_rows($con);

}
else//Invalid Operation.
{
	$post["Error"]="Invalid Operation";
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json
}

if($insert_id!=0 || $affected_rows!=0 )
{
	if ($insert_id!=0)
	{
		
		if($media_tags!='')
		{
			/************Saving Corrosponding Tags in Media Details**************/
			$tag_array =array();
			$tag_array=media_tag_array($media_tags);// | Saperated media tags to array
                       	//print_r($tag_array);
			for($i=0;$i<count($tag_array); $i++)
			{
                               
				save_media_tag($tag_array[$i],$insert_id); // Saprating values by , and saving them using curl Posting
                                //echo "<br>time of call".$i;
			}
			
			/*$query= "SELECT 
				`media`.`id` as `media_id`,
				`media`.`media_owner`,
				`media`.`media_title`,
				`media`.`media_image`,
                                `media`.`thumb`,
				`tags`.`id` as tag_id ,
				`tags`.`brand_id`,
                                `tags`.`retailer_id`,
				`tags`.`item_id`,
                                `tags`.`tag_position`,
				`tags`.`tag_by`
				FROM `media` Inner join `tags` on `media`.id = `tags`.`tag_on` WHERE `media`.`id`=$insert_id ";*/
                        $query= "SELECT 
				`media`.`id` as `media_id`,
				`media`.`media_owner`,
				`media`.`media_title`,
				`media`.`media_image`,
                                `media`.`thumb`
				FROM `media` WHERE `media`.`id`=$insert_id ";
		}
		else
		{
			$query= "SELECT 
				`media`.`id` as `media_id`,
				`media`.`media_owner`,
				`media`.`media_title`,
				`media`.`media_image`,
                                `media`.`thumb`
				FROM `media` WHERE `media`.`id`=$insert_id ";
	 
	}	
	}
	
	if ($affected_rows!=0)
	{
	$query="SELECT 
			`media`.`id` as `media_id`,
			`media`.`media_owner`,
			`media`.`media_title`,
			`media`.`media_image`,
                        `media`.`thumb`,
			
			FROM `media`  WHERE `media`.`id`=$media_id";	
	}
	$result="";
	$result=mysqli_query($con,$query);		
	while($post=mysqli_fetch_assoc($result))
	{	
		$post['tags']= get_tag_by_media_id($post['media_id']);
		$post['media_image']=add_site_url($post['media_image']);
                $post['thumb'] = add_site_url($post['thumb']);				
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
