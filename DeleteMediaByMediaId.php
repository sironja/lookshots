<?php
  require("Configure.php");
 $media_id = isset($_POST['media_id']) ? $_POST['media_id'] : '';
 $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
 $format= 'json';
 $query = "select * from media where id = $media_id and media_owner=$user_id";
 $result = mysqli_query($con,$query);
 $row = mysqli_num_rows($result);
 if($row>0)
   {
         $query="UPDATE `media` SET
	`deleted`=1 
	WHERE id=$media_id and media_owner = $user_id";
       $result=mysqli_query($con,$query);
	$affected_rows=mysqli_affected_rows($con);
        if ($affected_rows!=0)
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
   }
 else
   {
       $post['message'] = "already deleted";
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
