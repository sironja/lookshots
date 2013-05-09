<?php
require_once("Configure.php");
/*echo "<pre>";
print_r($_POST);
exit;*/

$login_userid=isset($_POST['login_userid']) ? $_POST['login_userid'] : '' ;
$following_userid=isset($_POST['following_userid']) ?  $_POST['following_userid'] : '';
$is_active= 1;
$format = 'json';
 $query = "select * from follow where `user_id` = $login_userid and `following` = $following_userid";  
$result = mysqli_query($con,$query);
$row =  mysqli_num_rows($result);

if($row<=0)
{
       $query = "insert into follow (`id`,`user_id`,`following`,`is_active`) values (NULL, '$login_userid','$following_userid','$is_active= 1')";
       $result=mysqli_query($con,$query);
        $insert_id= mysqli_insert_id($con);
	
		if ($result&&$insert_id!=0)
		$query="SELECT * FROM `follow` WHERE `id`=$insert_id";	
		
	        else
	         $post="No Record found that is you are not following";	
		
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

    
    $query  = " update follow set `is_active` = 1 where `user_id` = '$login_userid' and `following` = '$following_userid'" ;
    $result=mysqli_query($con,$query);
       $affected_row = mysqli_affected_rows($con);
     if ($affected_row>0)
		{
                  $query="SELECT * FROM `follow` WHERE `user_id` = '$login_userid' and `following` = '$following_userid'";	
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
                   $post="No Record found that is you are not following";
                   $result_xml.=getAttrTagString($post);//String for XML
			$result_json[]=$post;//String for json	
		 }
               
 }	
//}
//else
	
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
