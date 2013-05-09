<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("db.php");
/********************Some IMP Values*********/
$ApplicationSettings=array();
$ApplicationSettings['SiteURL'] = 'http://'.$_SERVER["HTTP_HOST"].'/lookshot';//GET SERVEER DOMAIN
$ApplicationSettings['LocalHostURL'] = 'http://129.168.1.41';//GET SERVEER DOMAIN
$ApplicationSettings['cover_photo_location'] = '/images/avatars/'; 
$ApplicationSettings['profile_photo_location'] = '/images/avatars/'; 
$ApplicationSettings['feed_photo_location'] = '/images/feed/'; 
$ApplicationSettings['media_photo_location'] = '/images/media/'; 
$ApplicationSettings['brand_photo_location'] = '/images/brand/';
$ApplicationSettings['item_photo_location'] = '/images/item/';
$ApplicationSettings['retailer_photo_location'] = '/images/retailer/'; 
$ApplicationSettings['default_cover_photo'] = $ApplicationSettings['cover_photo_location'].'default_cover_photo.jpg'; //
$ApplicationSettings['default_profile_photo'] = $ApplicationSettings['profile_photo_location'].'default_profile_photo.jpg'; //
$ApplicationSettings['default_feed_photo'] = $ApplicationSettings['feed_photo_location'].'default_feed_photo.jpg'; //
$ApplicationSettings['default_media_photo'] = $ApplicationSettings['media_photo_location'].'default_media_photo.jpg'; //
$ApplicationSettings['default_brand_photo'] = $ApplicationSettings['brand_photo_location'].'default_brand_photo.jpg'; //
$ApplicationSettings['default_retailer_photo'] = $ApplicationSettings['retailer_photo_location'].'default_retailer_photo.jpg'; //
$ApplicationSettings['default_item_photo'] = $ApplicationSettings['item_photo_location'].'default_retailer_photo.jpg'; //
$ApplicationSettings['ServerDateTime']=date("Y-m-d H:i:s");
$ApplicationSettings['CurrentTimestamp']=time();
$ApplicationSettings['Defaultpass']=genRandomPassword();
$result_json=array();
$result_xml="";
/**********Some IMP Functions**********************/
function array_push_assoc($array, $key, $value)
{
		$array[$key] = $value;
		return $array;
}	
function set_format()//To set Responce Format
{
	if(!isset($_POST['format']) || $_POST['format']=='')
	$format='json';
	else
	$format=trim(strtolower($_POST['format']));
	return $format;
}

function displayXmlOutput($result='')//Display Output According to XML Format 
{
	header("Content-type:text/xml");
	echo "<posts>".$result." </posts>";	
}

function displayJsonOutput($result='')//Display Output According to JSON Format 
{
	header("Content-type:text/json");
	echo json_encode(array("posts"=>$result));
}
function displayNativeXmlOutput($posts)//Display Output in Native XML FOAMAT
{
	header('Content-type: text/xml');
	echo '<posts>';
	foreach($posts as $index => $post) 
	{
		if(is_array($post)) 
		{
			foreach($post as $key => $value)
			{
				echo '<',$key,'>';
				if(is_array($value)) 
				{
					foreach($value as $tag => $val) 
					{
						echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
					}
				}
				echo '</',$key,'>';
			}
		}
	}
	echo '</posts>';
}
function getAttrTagString($post)//To make xml String of a single Record.
{
	$attributedtag="";
	$attributedtag.=" <post  ";
	foreach($post as $k=>$v)
	{
//		echo "<br>K : ".$k;
//		echo "<br>V : ".$v;
		$attributedtag.= " $k= \"$v\"";
	}
	$attributedtag.=" />";
	return $attributedtag;
}

function close_db_con()//Close Database Connection
{
	mysqli_close($con);
}

function genRandomPassword()
{
	$length = 10;     
	$characters = '12346789abcdefghjkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXYZ';
	$string = '';
	for ($p = 0; $p < $length; $p++)
	{
		$string .= @$characters[@mt_rand(0, @strlen($characters))];
	}
	return $string;
}
function debug_query($query)
{
	echo "<br>".$query;
	//exit;
}
function add_site_url($str)
{	
	//return $str= 'http://192.168.1.41'.$str;	 
	return $str='http://'.$_SERVER["HTTP_HOST"].'/lookshot'.$str;	 
}
function save_image($image_type,$imgstring)
{	
	$imagename=time();	
	$ImagePath='';
	$img=false;
	$decodeimage=str_replace(" ","+",$imgstring);	
	$img = imagecreatefromstring(base64_decode($decodeimage));//Code to decode image from base64 to string.
	if($img != false)
	{   
		if($image_type=='avatars')
		{		
		  $imagename=$imagename.genRandomPassword();
			$convimage = imagejpeg($img,'images/avatars/'.$imagename.'.jpg');//Code to convert image in jpeg.			
			//$ImagePath = $ApplicationSettings['cover_photo_location'].$imagename.'.jpg';
			$ImagePath = '/images/avatars/'.$imagename.'.jpg';
		}
		if($image_type=='brand')
		{
			$convimage = imagejpeg($img,'images/brand/'.$imagename.'.jpg');//Code to convert image in jpeg.
			//$ImagePath = $ApplicationSettings['brand_photo_location'].$imagename.'.jpg';
			$ImagePath = '/images/brand/'.$imagename.'.jpg';
		}
		if($image_type=='feed')
		{
			$convimage = imagejpeg($img,'images/feed/'.$imagename.'.jpg');//Code to convert image in jpeg.
			//$ImagePath = $ApplicationSettings['feed_photo_location'].$imagename.'.jpg';
			$ImagePath = '/images/feed/'.$imagename.'.jpg';
  		}
		if($image_type=='media')
		{
			$convimage = imagejpeg($img,'images/media/'.$imagename.'.jpg');//Code to convert image in jpeg.
			//$ImagePath = $ApplicationSettings['feed_photo_location'].$imagename.'.jpg';
			$ImagePath = '/images/media/'.$imagename.'.jpg';
		}
		if($image_type=='retailer')
		{
			$convimage = imagejpeg($img,'images/retailer/'.$imagename.'.jpg');//Code to convert image in jpeg.
			//$ImagePath = $ApplicationSettings['feed_photo_location'].$imagename.'.jpg';
			$ImagePath = '/images/retailer/'.$imagename.'.jpg';
		}
		if($image_type == 'item')
		{
			$convimage = imagejpeg($img,'images/item/'.$imagename.'.jpg');//Code to convert image in jpeg.
			//$ImagePath = $ApplicationSettings['feed_photo_location'].$imagename.'.jpg';
			$ImagePath = '/images/item/'.$imagename.'.jpg';
		}
	}
	else
	{
		$ImagePath="Unable to save image.";
	}
	return $ImagePath;
}
function check_username_availability($username,$user_email)///Email & username both should be unique
{
	$flag=1;
	$query="SELECT * FROM `users` WHERE `username`='$username' OR `user_email`='$user_email' ";		
	$result=mysqli_query($_SESSION['con'],$query);	
	if(mysqli_num_rows($result))
	$flag=0;
	else
	$flag=1;
	
	return $flag;
}

function check_brand_availability($brand_name)
{
	$flag=1;
	$query="SELECT * FROM `brand` WHERE `brand_name`='$brand_name' ";			
	$result=mysqli_query($_SESSION['con'],$query);	
	if(mysqli_num_rows($result))
	$flag=0;
	else
	$flag=1;
	
	return $flag;
}
function get_tag_by_media_id($mediaid)
{
        $string="";
	$query="    SELECT `tag_on`,`brand_id` ,`retailer_id`,`item_id`,`tag_position`,`tag_by` FROM `tags` WHERE `tag_on`='$mediaid' ";			
	$result=mysqli_query($_SESSION['con'],$query);	
	if(mysqli_num_rows($result))
	{
       while($rec=mysqli_fetch_assoc($result))
		{
		 //print_r($rec);
		$item_name="";
		$item_name=get_item_name_by_id($rec['item_id']);
                $brand_name=get_brand_name_by_id($rec['brand_id']);
                $retailer_name=get_retailer_name_by_id($rec['retailer_id']);
		$string = $string.$rec['item_id'].'~'.$item_name.',';
		$string = $string.$rec['brand_id'].'~'.$brand_name.',';
		$string = $string.$rec['retailer_id'].'~'.$retailer_name.',';
		$string = $string.$rec['tag_position'].',';
		$string = $string.$rec['tag_by'];
		$string = $string." | ";
		}
	}
	
	
	return $string;
 
}
function check_item_availability($item_name)
{
	$flag=1;
	$query="SELECT * FROM `item` WHERE `item_name`='$item_name' ";			
	$result=mysqli_query($_SESSION['con'],$query);	
	if(mysqli_num_rows($result))
	$flag=0;
	else
	$flag=1;	
	return $flag;
}
function media_tag_array($string)
{
	$tag_array=array();
	$tag_array=explode('|',$string);
	return $tag_array;
	
}
function save_media_tag($media_tag,$media_id)
{
	$media_tag=explode(',',$media_tag);
	//echo "<pre>";
	//print_r($media_tag);
	
	$url = "http://".$_SERVER["HTTP_HOST"]."/lookshot/SaveTag.php";
	$params = "item_id=$media_tag[0]&tag_on=$media_id&brand_id=$media_tag[1]&retailer_id=$media_tag[2]&tag_position=$media_tag[3]&tag_by=$media_tag[4]&"; //Brand_id,Retailer_id,tag_position,tag_by 
	//echo "<br>params".	$params;
	//exit;
	$user_agent = "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$result=curl_exec ($ch);
	curl_close ($ch);	
	//echo "Results: <br>".$result;
}
function get_username_by_user_id($id)
{   
    $pos = array();
	$query  = "select username from users where id= $id";
	$result = mysqli_query($_SESSION['con'],$query);
	$pos = mysqli_fetch_assoc($result);
	return $pos['username'];
}
function get_fullname($id)
{
        $pos = array();
	$query  = "select fullname from users where id= $id";
	$result = mysqli_query($_SESSION['con'],$query);
	$pos = mysqli_fetch_assoc($result);
	return $pos['fullname'];
}
function get_profile_photo($id)
{
    $pos = array();
$p = array();
	$query  = "select profile_photo from users where id= $id and is_active=1 and deleted=0";

	$result = mysqli_query($_SESSION['con'],$query);
	$pos = mysqli_fetch_assoc($result);
      $p['profile_photo'] = add_site_url($pos['profile_photo']);

        return $p['profile_photo'];
}
function is_user_share($uid,$mid)
{
	$flag = "0"; 
	$query = "select * from shares where share_on=$mid and share_by=$uid and is_active=1 and deleted=0";
   
$result = mysqli_query($_SESSION['con'],$query);
	if(mysqli_num_rows($result))
	$flag="1";
	else
	$flag="0";	
	return $flag;
}
function is_user_comented($uid,$mid)
{
	$flag = "0"; 
	$query = "select * from comments where comment_on=$mid and comment_by=$uid and is_active=1 and deleted=0";
    $result = mysqli_query($_SESSION['con'],$query);
	
	$r=mysqli_num_rows($result);

	if($r>0)
	{
		$flag="1";
	}
	else
	{
		$flag="0";
	}
	return $flag;
}
function is_user_likes($uid,$mid)
{
	$flag = "0"; 
	$query = "select * from likes where like_on=$mid and like_by=$uid and is_active=1 and deleted=0";
    $result = mysqli_query($_SESSION['con'],$query);
	
	$r=mysqli_num_rows($result);

	if($r>0)
	{
		$flag="1";
	}
	else
	{
		$flag="0";
	}
	return $flag;
}
function get_comment($uid,$mid)
{
	$com =''; 
	$query = "select comment_text from comments where comment_on=$mid and comment_by=$uid and is_active=1 and deleted=0";
    $result = mysqli_query($_SESSION['con'],$query);
	
	while($rec=mysqli_fetch_assoc($result))
	{
		 //print_r($rec);
		 $com = $com.$rec['comment_text'].' | ';
	}
		if($com!=''||$com!=NULL)
	    {  
		   
		}
	else
	{   
	      $com = "No Comment Found";
		 
	}
	return $com;
	
}
function get_comment_count($mid)
{
	$count = ''; 
	$query = "select count(comment_on)from comments where comment_on = $mid and deleted = 0 ";
    $result = mysqli_query($_SESSION['con'],$query);
	
	$rec=mysqli_fetch_assoc($result);
	
		   // print_r($rec);
	       $count = $count.$rec['count(comment_on)'];
	
	//exit;
	return $count;
	
}
function get_recent_comment($media_id)
{
       $string="";
	$query="    SELECT `comment_text`,`comment_by` FROM `comments` WHERE `comment_on`='$media_id' and deleted =0 order by comment_created_time desc limit 3  ";			
	$result=mysqli_query($_SESSION['con'],$query);	
       
	if(mysqli_num_rows($result)>0)
	{
         $post =  array();
        $i = 1;
        
       while($rec=mysqli_fetch_assoc($result))
		{
		 //print_r($rec);
		 $string = $rec['comment_text'];
		$string = $string."|";
                $string = $string.$rec['comment_by'];
                $string = $string."|";
                $string = $string.get_username_by_user_id($rec['comment_by']);
                $post["Comment ".$i] = $string;
                
                  $i++;
                    
		}
            if (count($post)>0)
              {
             return $post;}
            else 
                {
                   //return count($post);
                  //exit;
                return  $post["Comment"] = "";
               }
               // echo "<pre>";
               // print_r($post);
                // exit;
             
	}
	
	 
	//return $string;

}
function get_like($mid)
{
	$count = ''; 
	$query = "select count(like_on)from likes where like_on = $mid and is_active = 1 and deleted =0";
    $result = mysqli_query($_SESSION['con'],$query);
	
	$rec=mysqli_fetch_assoc($result);
	
		 // print_r($rec);
	     $count = $count.$rec['count(like_on)'];
	
	return $count;
     
}
function get_share($mid)
{
	$count = ''; 
	$query = "select count(share_on)from shares where share_on = $mid";
	$result = mysqli_query($_SESSION['con'],$query);	
	$rec=mysqli_fetch_assoc($result);
	
		 // print_r($rec);
	     $count = $count.$rec['count(share_on)'];
	
	//exit;
	return $count;
	
}
function total_number_record($mid)
{
    $id = $mid;
	$query = "select * from media where media_owner=$id";
	$result = mysqli_query($_SESSION['con'],$query);
	$r =  mysqli_num_rows($result);
	return $r;
}
function get_item_name_by_id($item_id)
{
	$item_name = ''; 
	$query = "select `item_name` from item where id = $item_id";
    
	$result = mysqli_query($_SESSION['con'],$query);	
	$rec=mysqli_fetch_assoc($result);
	$item_name =$rec['item_name'];
	//echo "<br>item_id : ".$item_id." sitem name : ".$item_name;
	return $item_name;
	
}
function get_brand_name_by_id($brand_id)
{
	$brand_name = '';
	 $query = "select `brand_name` from brand where id = $brand_id"; 
              
	$result = mysqli_query($_SESSION['con'],$query);
	$rec=mysqli_fetch_assoc($result);
	 $brand_name =$rec['brand_name'];
       
	return $brand_name;

}
function get_retailer_name_by_id($retailer_id)
{
	$retailer_name = '';
	 $query = "select `retailer_name` from retailer where id = $retailer_id";
         
	$result = mysqli_query($_SESSION['con'],$query);
	$rec=mysqli_fetch_assoc($result);
	$retailer_name =$rec['retailer_name'];
     
	return $retailer_name;

}
function no_of_follower($id)
{ 
       $r = "";
      $query = "select * from follow where following=$id";
	$result = mysqli_query($_SESSION['con'],$query);
	$r =  mysqli_num_rows($result);
	return (string)$r;
}
function no_of_following($id)
{
       $r= "";
     $query = "select * from follow where user_id=$id";
	$result = mysqli_query($_SESSION['con'],$query);
	$r =  mysqli_num_rows($result);
	return (string)$r;
}
function no_of_post($id)
{    
     $r = "";
    $query = "select * from media where media_owner=$id";
	$result = mysqli_query($_SESSION['con'],$query);
	$r =  mysqli_num_rows($result);
	return (string)$r;
}
function check_status($luid,$uid)
{
     $status= "";
     $query = "select * from follow where user_id = $luid and following = $uid"; 
     $result = mysqli_query($_SESSION['con'],$query);
	$r =  mysqli_num_rows($result);
    if($r>0)
      {
         $status = "follow";
      }
    else
       { 
         $status = "unfollow"; 
       }
    return $status;
}
function get_commetn_time($cid,$current_time)
{
    // $r = array();
     $query = "select comment_created_time from comments where id = $cid ";
     $res = mysqli_query($_SESSION['con'],$query);
     $result = mysqli_fetch_assoc($res);
     $create = new DateTime($result['comment_created_time']);
     $today = new DateTime($current_time);
     $interval = $create->diff($today);
     $year = $interval->format('%y');
     $month = $interval->format('%m'); 
     $day = $interval->format('%d');
     $hr = $interval->format('%h');
     $min = $interval->format('%i');
     $sec = $interval->format('%s');
     if($year>0)
        {
           $r = $year." Years";// year print
        }
     else if($month >=1)
        {
           $r = $month." Months";// month print
        }
     else if($day==7)
        {
           $r = "1 Week";
            //a 1 weak
        }
     else if($day==14)
        {
           $r = "2 Week";
            //a 2 weak
        }
     else if($day==21)
        {
	    $r = "3 Week";
            //a 3 weak
        }
     else if($day==28)
        {
            $r = "4 Week";//a 4 weak
        } 
     else if($day>=1&&$day!=7&&$day!=14&&$day!=21&&$day!=28)
        {
            $r = $day." Day";// days ago
        }
     else if($hr>0)
        {
            $r = $hr." Hours";
            // hours ago
        }
     else if($min>=1)
        {
            $r = $min." Minuts";
            // days ago
        }
     else
        {
            $r = $sec." Seconds";
        }
     return $r;
}
?>
