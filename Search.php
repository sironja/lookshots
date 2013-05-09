<?php
//echo "<pre>";
//print_r($_POST);
require("Configure.php");
$type =  isset($_POST['type']) ? $_POST['type'] : '' ;
$searchstring = isset($_POST['searchstring']) ? $_POST['searchstring'] : '' ;
$userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
$accesstoken = isset($_POST['accesstoken']) ? $_POST['accesstoken'] : 0;


//$searchstring = isset($_POST['searchstring']) ? $_POST['searchstring'] : '';
//print_r($_POST);
//exit;
$format = set_format();

if($type=='')
{   

	$query =  "SELECT m.`id` , m.`thumb` as thumbnail_image,m.media_owner, COUNT( `like_on` ) AS `like_count`
FROM `media` AS m
INNER JOIN `likes` AS l ON m.`id` = l.`like_on` where m.`is_active` = 1 and m.`deleted`=0

GROUP BY `like_on`
ORDER BY `like_count`  DESC limit 32";

$result=mysqli_query($con,$query);
$r =mysqli_num_rows($result);
if($r>0)
{
  while($p=mysqli_fetch_assoc($result))
  {	
          $post['media_id']=$p['id'];
          $post['thumbnail_image']=add_site_url($p['thumbnail_image']);
	  $post['media_owner'] = $p['media_owner'];
          $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }

if($r<32)
{	
        $l = 32-$r;
       $query = "select m.`id` , m.`thumb` as thumbnail_image,m.media_owner FROM `media` AS m where m.`is_active` = 1 and m.`deleted`=0 ORDER BY `media_created_time` desc limit $l";
 
       $result = mysqli_query($con,$query);
       $row = mysqli_num_rows($result);
        if($row>0)
          {
              while($p=mysqli_fetch_assoc($result))
                {	
                $post['media_id']=$p['id'];
                  $post['thumbnail_image']=add_site_url($p['thumbnail_image']);
                 $post['media_owner'] = $p['media_owner'];
	           $result_xml.=getAttrTagString($post);//String for XML
	         $result_json[]=$post;//String for json
                  }   
          }	
}
}
else
{	
       $query = "select m.`id` , m.`thumb` as thumbnail_image,m.media_owner FROM `media` AS m where m.`is_active` = 1 and m.`deleted`=0 ORDER BY `media_created_time` desc limit 32";
       $result = mysqli_query($con,$query);
       $row = mysqli_num_rows($result);
        if($row>0)
          {
              while($p=mysqli_fetch_assoc($result))
  {	
          $post['media_id']=$p['id'];
          $post['thumbnail_image']=add_site_url($p['thumbnail_image']);
          $post['media_owner'] = $p['media_owner'];
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }   
          }
       else
        {
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]= $post;//String for json
        }	
}
}
	

else if($type == 'brand')
{ 

  //$query = "  SELECT
//`media`.`id` as `media_id`,
//`media`.`media_owner`,
//`media`.`media_image`
//
//FROM `media` Inner join `tags` on `media`.id = `tags`.`tag_on` WHERE `tags`.`brand_id`=$id";
$query ="select id,brand_name,brand_photo from brand where brand_name like '$searchstring%'  ";
//echo $query;
//exit;
$result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['brand_photo']=add_site_url($post['brand_photo']);
	  //$post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json	
}
}
else if($type == 'user')
{
//	echo  "farid";
//exit;
	$query = "select id,fullname,username,user_email,cover_photo,profile_photo from users where fullname like '$searchstring%' and is_active=1 and deleted =0 " ;
    $result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['cover_photo']=add_site_url($post['cover_photo']);
	  $post['profile_photo']=add_site_url($post['profile_photo']);
	  //$post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json	
}
}
else if($type == 'item')
{
	$query = "  SELECT id,item_name,item_photo FROM item WHERE item_name like '$searchstring%' and is_active=1 and deleted =0";
	//echo $query;
//	exit;
$result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  $post['item_photo']=add_site_url($post['item_photo']);
	  //$post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json	
}
}
else if($type == 'hashtag')
{    
     $searchstring = "#".$searchstring;
    $query = "select hash_tags_id, hash_tags,media_id,comment_id from Hash_tags where hash_tags like '$searchstring%' and is_active=1 and deleted =0";
  $result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json	
}
}
else if($type == 'eventtype' && $searchstring!="")
{
	 $query = "SELECT  distinct  `image_type` as `eventtype` FROM  `media` where image_type like '$searchstring%'  ";
	// echo $query;
//	 exit;
	 $result=mysqli_query($con,$query);

if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	 // $post['media_image']=add_site_url($post['media_image']);
	 // $post['username'] = get_username_by_user_id($post['media_owner']);
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
else
{	
	$post['message']="No Record Found.";		
	$result_xml.=getAttrTagString($post);//String for XML
	$result_json[]=$post;//String for json	
}
}
else if($type == 'eventtype' && $searchstring=="")
{
  $query = "SELECT DISTINCT  `image_type` as `eventtype` FROM  `media` ";
  $result=mysqli_query($con,$query);
  if(mysqli_num_rows($result))
{
  while($post=mysqli_fetch_assoc($result))
  {	

	  
	  
	  $result_xml.=getAttrTagString($post);//String for XML
	  $result_json[]=$post;//String for json
  }
}
}

//echo"<pre>";
//print_r($result_json);
//exit;
//$format='nxml';

if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);
