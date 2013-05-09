<?php
require_once("Configure.php");
/*echo "<pre>";
print_r($_POST);
exit;*/

$login_userid=isset($_POST['login_userid']) ? $_POST['login_userid'] : '' ;
$following_userid=isset($_POST['following_userid']) ?  $_POST['following_userid'] : '';
$is_active= 1;
$format = 'json';

       $query = "update follow set `is_active` = 0 where `user_id` = '$login_userid' and `following` = '$following_userid'";

       $result=mysqli_query($con,$query);
       // $insert_id= mysqli_insert_id($con);
	$affected_row = mysqli_affected_rows($con);
          
		
               if ($affected_row!=0)
              {

		$query="SELECT id, user_id, following as unfollowed_user_id FROM `follow` WHERE `user_id` = '$login_userid' and `following` = '$following_userid'";
                $result="";
		$result=mysqli_query($con,$query);	
		while($post=mysqli_fetch_assoc($result))
		{	
		
			$result_xml.=getAttrTagString($post);//String for XML
			$result_json[]=$post;//String for json
		}
              }
	        else
                 {
	         $post="No Record found that is you are already  not following";
                $result_xml.=getAttrTagString($post);//String for XML
			$result_json[]=$post;//String for json	   		
                 }
                
	
//}
//else      UPDATE `follow` SET `is_active`=0 WHERE `user_id` = 32,`following` = 47
	
//echo"<pre>";
//print_r($result_json);
//exit;
//echo $format;
//exit;
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='json')
displayJsonOutput($result_json);
if($format=='nxml')
displayNativeXmlOutput($result_json);

?>
