<?php
require('Configure.php');


$media_id=isset($_POST['media_id']) ? $_POST['media_id'] : 0;
$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;
$post=array();

$format = set_format();
 $query = "SELECT media.id ,media.media_title, media.media_image , media.image_type, media.thumb as thumbnail_image , media.media_owner FROM media  WHERE media.id =$media_id and is_active=1 and deleted=0";
//echo $query;
//exit;
$result=mysqli_query($con,$query);

While($post=mysqli_fetch_assoc($result))
{

$post['media_image']=add_site_url($post['media_image']);
$post['thumbnail_image']=add_site_url($post['thumbnail_image']);
$post['username']=get_username_by_user_id($post['media_owner']);
$post['fullname']=get_fullname($post['media_owner']);
$post['profile_photo']=get_profile_photo($post['media_owner']);
$post['is_user_share'] = is_user_share($user_id,$media_id);
$post['is_user_commented'] = is_user_comented($user_id,$media_id);
$post['is_user_likes'] = is_user_likes($user_id,$media_id);
 $post['tags']= get_tag_by_media_id($post['id']);
$post['comment'] = get_comment($user_id,$media_id);
$post['total_comment_count'] = get_comment_count($media_id);
$post['total_like_count'] = get_like($media_id);
$post['total_share_count'] = get_share($media_id);
$post['comments'] = get_recent_comment($post['id']);
$result_xml.=getAttrTagString($post);//String for XML
$result_json[]=$post;//String for json
}

//echo '<pre>';
//print_r($result_json);
//exit;

if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);
?>
