<?php
require('Configure.php');
$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;
$post='';
$page_no=isset($_POST['page']) ? $_POST['page'] : 0;

$format = set_format();
$r = total_number_record($user_id);

$query = "SELECT media.id  ,media.media_title, media.media_image ,media.image_type, media.thumb as thumbnail_image,  media.media_owner as user_id,users.fullname, users.profile_photo, users.username FROM media INNER JOIN users ON media.media_owner = users.id WHERE users.id =$user_id and is_active = 1 and deleted = 0 limit $page_no,30";
 
 $result=mysqli_query($con,$query);

	while($po=mysqli_fetch_assoc($result))
  {	
      $post= $po;
	  
	 // print_r($post);
	  
	 // exit;
	  //$post['media_image']=add_site_url($post['media_image']);
     // $post['media']=$post['media_owner'];
	  
     $post['tags']= get_tag_by_media_id($post['id']);
     

   //  print_r($post);exit;
     if($r>0)
      {
         $post['number_of_rechord_found']=$r;

      }   
    $post['profile_photo']  = add_site_url($post['profile_photo']); 
    $post['media_image']=add_site_url($post['media_image']); 
    $post['thumbnail_image']=add_site_url($post['thumbnail_image']);
	  $post['is_user_share'] = is_user_share($user_id,$post['id']);
	  $post['is_user_commented'] = is_user_comented($user_id,$post['id']);
	  $post['is_user_likes'] = is_user_likes($user_id,$post['id']);
	  //$post['comment'] = get_comment($user_id,$post['id']);
	  $post['total_comment_count'] = get_comment_count($post['id']);
	  $post['total_like_count'] = get_like($post['id']);
          $post['comments'] = get_recent_comment($post['id']);
	  $post['total_share_count'] = get_share($post['id']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
  
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);

?>
