<?php
require("Configure.php");
$format=set_format();
$media_id=isset($_POST['media_id']) ? $_POST['media_id'] : '';
$query = "select id as comment_id,  comment_text,comment_by as user_id, comment_on as media_id from comments where comment_on = $media_id and `is_active` =  1 and `deleted` = 0 order by comment_created_time desc";
$result = mysqli_query($con, $query);
$row = mysqli_num_rows($result);
$post = array();
$current_time = date("Y-m-d H:i:s");
if($row>0)
{ 
   while($post=mysqli_fetch_assoc($result))
     { 
         $post['username'] = get_username_by_user_id($post['user_id']);
         $post['profile_photo'] = get_profile_photo($post['user_id']);
         $post['comment_time'] =  get_commetn_time($post['comment_id'],$current_time);
         $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]= $post;
     }
}
else
{
      $post['message'] ="No comment found";
      $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]= $post;
}
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);
?>

