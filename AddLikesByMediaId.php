<?php
  require("Configure.php");
  //$token = isset($_POST['token']) ? $_POST['token'] : '0';
  $media_id = isset($_POST['media_id']) ? $_POST['media_id'] : '0';
  $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '0';
$like_created_time= $ApplicationSettings['ServerDateTime'];
$like_update_time= $ApplicationSettings['ServerDateTime'];
    $query = "select * from likes where like_on = $media_id and like_by = $user_id";
    $result = mysqli_query($con,$query);
    $row = mysqli_num_rows($result);
     if($row>0)
          {
                $post = mysqli_fetch_assoc($result);
                if($post['is_active']==1&&$post['deleted']==0 )
                     {
			$query="UPDATE `likes` SET
	        	`deleted`=1,
                 	`is_active` = 0 
	         	WHERE `like_on`=$media_id and `like_by` = $user_id";
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
                        		$query="UPDATE `likes` SET
	        	`deleted`=0,
                 	`is_active` = 1 
	         	WHERE `like_on`=$media_id and `like_by` = $user_id";
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
          }
    else
        {
                        $is_active = 1;
		        $deleted = 0;
                        $query="INSERT INTO `lookshot_db`.`likes` (`id` ,`like_on` ,`like_by` ,`is_active` ,`deleted` ,`like_created_time` ,`like_updated_time`)
			VALUES (NULL , '$media_id', '$user_id', '$is_active', '$deleted', '$like_created_time', '$like_update_time')";
			//Enable below function to debug query
			//debug_query($query);	
			$result=mysqli_query($con,$query);
			$insert_id=mysqli_insert_id($con);
                        if($insert_id!=0)
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
$format = 'json';
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);
?>
