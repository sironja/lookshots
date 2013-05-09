<?php
//echo "<pre>";
//print_r($_POST);
require("Configure.php");
$login_user_id=isset($_POST['login_user_id']) ? $_POST['login_user_id'] : 0;
$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;
$format = 'json';
if($login_user_id == $user_id)
{
  $post = array();
  $query = " select id, username, fullname, profile_photo, cover_photo, about from users where id = $user_id";
  $result = mysqli_query($con,$query);
  while($p = mysqli_fetch_assoc($result))
   {   
       $post['user_id'] = $p['id'];
       $post['username'] = $p['username'];
       $post['fullname'] = $p['fullname'];
       $post['profile_photo'] =add_site_url($p['profile_photo']);
       $post['cover_photo'] = add_site_url($p['cover_photo']);
       $post['Status'] = "Self";
       $post['no_of_post'] = no_of_post($user_id);
       $post['no_of_follower'] = no_of_follower($user_id);
       $post['no_of_following'] = no_of_following($user_id);
       $post['about'] = $p['about'];
       $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;
   } 
}
else
{ 
  $post = array();
  $query = " select id, username, fullname, profile_photo, cover_photo, about from users where id = $user_id";
  $result = mysqli_query($con,$query);
  while($p = mysqli_fetch_assoc($result))
   {   
       $post['user_id'] = $p['id'];
       $post['username'] = $p['username'];
       $post['fullname'] = $p['fullname'];
       $post['profile_photo'] =add_site_url($p['profile_photo']);
       $post['cover_photo'] = add_site_url($p['cover_photo']);
       $post['Status'] = check_status($login_user_id,$user_id);
       $post['no_of_post'] = no_of_post($user_id);
       $post['no_of_follower'] = no_of_follower($user_id);
       $post['no_of_following'] = no_of_following($user_id);
       $post['about'] = $p['about'];
       $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;
   }
}
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);
?>
