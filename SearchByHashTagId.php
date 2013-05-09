<?php
require("Configure.php");

$type =  isset($_POST['type']) ? $_POST['type'] : '' ;
$searchstring = isset($_POST['hashtag']) ? $_POST['hashtag'] : '' ;
$formate = 'json';


   if($type=="user")
   {
	   $query1 = "select users.id as user_id, users.fullname, users.username, users.user_email, users.cover_photo, users.profile_photo, users.user_created_time as user_created_time, users.udid as deveice_id from users inner join Hash_tags on Hash_tags.user_id = users.id where Hash_tags.hash_tags like '%$searchstring%'  GROUP BY `user_id` ";
	 //  echo $query1;
//	   exit;
	   $result1=mysqli_query($con,$query1);
	  
	   while($post=mysqli_fetch_assoc($result1))
        {
			
			            //$post['username'] = get_username_by_user_id($post['media_owner']);
	  					//$result_xml.=getAttrTagString($post);//String for XML
	  					//$result_json[]=array("post" => $post);//String for json
						
			           
						$result_xml.=getAttrTagString($post);//String for XML
	  					$result_json[]=$post;
						
		}  
   }
   else
   {
	  $query1 = "select media.id as media_id, media.media_title, media.media_owner, media.media_image, media.image_type as media_type, media.media_created_time as user_uploaded_time from media inner join Hash_tags on Hash_tags.media_id = media.id where Hash_tags.hash_tags like '%$searchstring%'  GROUP BY `media_id`";
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
							 $r = "comment_".$i."_text";
							 $b = "comment".$i."_by";
							 $t = "comment_".$i."_created_time";
						$post[$b] =	$post7['comment_by'];
						$post[$r] =	$post7['comment_text'];
						$post[$t] =	$post7['comment_created_time'];
						$i++;
						}
						$result_xml.=getAttrTagString($post);//String for XML
	  					$result_json[]=$post;
						}
		}
   }









if($formate=='xml')
displayXmlOutput($result_xml);
if($formate=='nxml')
displayNativeXmlOutput($result_json);
if($formate=='json')
displayJsonOutput($result_json);
?>