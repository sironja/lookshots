<?php
require("Configure.php");
  $token = isset($_POST['token']) ? $_POST['token'] : '0';
  $media_id = isset($_POST['media_id']) ? $_POST['media_id'] : '0';
  $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '0';
  $reason = isset($_POST['reason']) ? $_POST['reason'] : '0';
  $created_time= $ApplicationSettings['ServerDateTime'];
  $format = 'json';
  $deleted = 0;
  $is_active = 1;
  $query = "insert into flag_media (`id`,`media_id`,`flag_user_id`,`is_active`,`deleted`,`created_time`,`reason`) values     (NULL,'$media_id','$user_id','$is_active','$deleted','$created_time','$reason')";

  $result=mysqli_query($con,$query);
  $insert_id=mysqli_insert_id($con);
  $query2 = "update media set flag=1 where id = $media_id";
  $result=mysqli_query($con,$query2);
  $affected_rows=mysqli_affected_rows($con);
  if($affected_rows!=0||$insert_id!=0)
       {
          $post['message'] = "Yes"; 
            		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=$post;
       }
  else
      {
           $post['message'] = "No"; 
            		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=$post;
      }
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);
?>
