<?php
//echo "<pre>";
//print_r($_POST);
require("Configure.php");
$type =  isset($_POST['type']) ? $_POST['type'] : '' ;
$searchstring = isset($_POST['searchstring']) ? $_POST['searchstring'] : '' ;
$userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
$accesstoken = isset($_POST['accesstoken']) ? $_POST['accesstoken'] : 0;


$type_for_hashtag = isset($_POST['type_hashtag']) ? $_POST['type_hashtag']: "user";
//$searchstring = isset($_POST['searchstring']) ? $_POST['searchstring'] : '';
//print_r($_POST);
//exit;
$format = set_format();

if($type=='')
{   

	$query =  "SELECT m.`id` , m.`media_owner` , m.`media_title` , m.`media_image` , m.`image_type` , COUNT( `like_on` ) AS `like_count`
FROM `media` AS m
INNER JOIN `likes` AS l ON m.`id` = l.`like_on`
GROUP BY `like_on`
ORDER BY `like_count` DESC limit 32";
//echo $query;
//exit;
$result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['media_image']=add_site_url($post['media_image']);
	  $post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=array("post" => $post);//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=array("post" => $post);//String for json	
}

}
	

else if($type == 'brand')
{ 

  //$query = "  SELECT
//`media`.`id` as `media_id`,
//`media`.`media_owner`,
//`media`.`media_image`
//
//FROM `media` Inner join `tags` on `media`.id = `tags`.`tag_on` WHERE `tags`.`brand_id`=$id";
$query ="select * from brand where brand_name like '%$searchstring%' ";
//echo $query;
//exit;
$result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['brand_photo']=add_site_url($post['brand_photo']);
	  //$post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=array("post" => $post);//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=array("post" => $post);//String for json	
}
}
else if($type == 'user')
{
//	echo  "farid";
//exit;
	$query = "select* from users where fullname like '%$searchstring%' ";
    $result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['cover_photo']=add_site_url($post['cover_photo']);
	  $post['profile_photo']=add_site_url($post['profile_photo']);
	  //$post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=array("post" => $post);//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=array("post" => $post);//String for json	
}
}
else if($type == 'item')
{
	$query = "  SELECT * FROM item WHERE item_name like '%$searchstring%' ";
	//echo $query;
//	exit;
$result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['item_photo']=add_site_url($post['item_photo']);
	  //$post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=array("post" => $post);//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=array("post" => $post);//String for json	
}
}
else if($type == 'hashtag')
{ 

   if($type_for_hashtag=="user")
   {
	    $query = "select comments.id as comment_id,comments.comment_on, comments.comment_text, comments.comment_created_time as comment_time, users.fullname, users.id as user_id, users.username,users.cover_photo,                   users.profile_photo, users.user_email, users.udid as device_id from comments inner join users on comments.comment_by = users.id where comments.comment_text like                  '%$searchstring%'";
		    $result=mysqli_query($con,$query);

         if(mysqli_num_rows($result))
            {
 				 while($post=mysqli_fetch_assoc($result))
  					{	

	  					$post['cover_photo']=add_site_url($post['cover_photo']);
	  					$post['profile_photo']=add_site_url($post['profile_photo']);
	  					//$post['username'] = get_username_by_user_id($post['media_owner']);
	  					$result_xml.=getAttrTagString($post);//String for XML
	  					$result_json[]=array("post" => $post);//String for json
  					}
			}
		else
		   {	
				$post['message']="No Record Found.";		
				$result_xml.=getAttrTagString($post);//String for XML
				$result_json[]=array("post" => $post);//String for json	
		   }

   }
   else
   {
	   $query1 = "select id as media_id, media_title, media_image, image_type, media_created_time as uploaded_time, media_owner from media";
	   $result1=mysqli_query($con,$query1);
	  
	   while($post1=mysqli_fetch_assoc($result1))
        {
			$mid = $post1['media_id'];
			
			$query2 = "select comment_on, comment_text, comment_by, comment_created_time, id as comment_id from comments where comment_on = $mid and comment_text like '%$searchstring%'";
			
	        $result2=mysqli_query($con,$query2);
			$post2=mysqli_fetch_assoc($result2);
			          
			            $post1['media_image']=add_site_url($post1['media_image']);
                        if($post2!='')
						{
							//$post1['media_image']=add_site_url($post1['media_image']);
						$post = 	$post1; 
						
			            //$post['username'] = get_username_by_user_id($post['media_owner']);
	  					//$result_xml.=getAttrTagString($post);//String for XML
	  					//$result_json[]=array("post" => $post);//String for json
						$midd = $post['media_id'];
						$qq =  "select comment_text, comment_by, comment_created_time from comments where comment_on = $midd and comment_text like '%$searchstring%' order by comment_created_time desc limit 3";
						$result3=mysqli_query($con,$qq);
						$i = 1;
			            while($post7=mysqli_fetch_assoc($result3))
						{
							 $r = "comment_text".$i;
							 $b = "comment_by".$i;
							 $t = "comment_created_time".$i;
						$post[$b] =	$post7['comment_by'];
						$post[$r] =	$post7['comment_text'];
						$post[$t] =	$post7['comment_created_time'];
						$i++;
						}
						$result_xml.=getAttrTagString($post);//String for XML
	  					$result_json[]=array("post" => $post);
						}
		}
   }
}
else if($type == 'eventtype')
{
	 $query = "select * from media where image_type like '%$searchstring%'";
	// echo $query;
//	 exit;
	 $result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['media_image']=add_site_url($post['media_image']);
	  $post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=array("post" => $post);//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=array("post" => $post);//String for json	
}
}

//echo"<pre>";
//print_r($result_json);
//exit;
//$format='nxml';
$format='nxml';
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);