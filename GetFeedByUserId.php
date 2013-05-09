<?php
require("Configure.php");
$format='json';
$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : '';
//echo
$query = "select id as media_id, media_title, media_image, image_type, media_owner from media where media_owner in(SELECT following FROM follow WHERE user_id =$user_id) or media_owner=$user_id order by media_created_time desc";

$result = mysqli_query($con,$query);
$row = mysqli_num_rows($result);
if($row>0)
{
   while($post=mysqli_fetch_assoc($result))
    {
          $post['media_image']=add_site_url($post['media_image']);
$post['username']=get_username_by_user_id($post['media_owner']);
$post['fullname']=get_fullname($post['media_owner']);
$post['profile_photo']=get_profile_photo($post['media_owner']);
$post['is_user_share'] = is_user_share($user_id,$post['media_id']);
$post['is_user_commented'] = is_user_comented($user_id,$post['media_id']);
$post['is_user_likes'] = is_user_likes($user_id,$post['media_id']);
$post['tags']= get_tag_by_media_id($post['media_id']);
//$post['comment'] = get_comment($user_id,$post['media_id']);//All comments
$post['total_comment_count'] = get_comment_count($post['media_id']);
$post['total_like_count'] = get_like($post['media_id']);
$post['total_share_count'] = get_share($post['media_id']);
if($post['comment'] = get_recent_comment($post['media_id'])!='')
{
        $post['comment'] = get_recent_comment($post['media_id']);
}//Latest 3 comments
else
{
   $post['comment'] = "";
}
$result_xml.=getAttrTagString($post);//String for XML
$result_json[]=$post;//String for json
    }
}
else
{
  $post['message']= "No Feed Present";
 $result_xml.=getAttrTagString($post);//String for XML
$result_json[]=$post;//String for json
}

//echo "<br><pre>";
//print_r($result_json);
//exit;

if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);
?>
