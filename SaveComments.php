<?php
require("Configure.php");

$operation=isset($_POST['operation']) ? $_POST['operation'] : 'Add';//Add or Update (user_id needed in Update)
$comment_id=isset($_POST['comment_id']) ? $_POST['comment_id'] : 0 ;//Used To Update user record.
$comment_on=isset($_POST['comment_on']) ? $_POST['comment_on'] : 0;
$comment_text=isset($_POST['comment_text']) ?  $_POST['comment_text'] : '';
$comment_by=isset($_POST['comment_by']) ? $_POST['comment_by'] : 0;
$is_active= 1;
$deleted=isset($_POST['deleted']) ? $_POST['deleted'] : 0;
$comment_created_time=$ApplicationSettings['ServerDateTime'];
$comment_updated_time= $ApplicationSettings['ServerDateTime'];																									
$insert_id=0;
$affected_rows=0;
$format=set_format();
if($operation=='Add')
{
	$query="INSERT INTO  `lookshot_db`.`comments` (`id` ,`comment_on` ,`comment_text` ,`comment_by` ,`is_active` ,`deleted` ,`comment_created_time` ,`comment_updated_time`)
			VALUES (NULL , '$comment_on',  '$comment_text',  $comment_by,  $is_active,  $deleted,  '$comment_created_time',  '$comment_updated_time')";
	//Enable below function to debug query
	//debug_query($query);
	//exit;
	//echo $query;
//	exit;
	$result=mysqli_query($con,$query);
	$insert_id=mysqli_insert_id($con);
	$matches = null;   // prega_matchs starts

// if (preg_match_all('/(?!\b)(#\w+\b)/',$test,$matches)){
if (preg_match_all('(#\w+\b)',$comment_text,$matches)){
// echo "Matches found!\r\n\r\n";
// var_dump($matches);
//echo"<pre>";
// print_r($matches);
 $a=count($matches, COUNT_RECURSIVE);
$x = array();
for($i=0; $i<$a-1; $i++)
{

$x[$i] = $matches[0][$i];

}
$len = count($x);
for($i=0;$i<$len;$i++)
{
	$query2 = "insert into Hash_tags ( comment_id, media_id, user_id, hash_tags) values ( '$insert_id', '$comment_on', '$comment_by', '$x[$i]' )";
	$result=mysqli_query($con,$query2);
}

}// end of prega_matchs

	
}
else if($operation=='Update' && $comment_id != 0 )
{
	$query="UPDATE  `lookshot_db`.`comments` SET `deleted` =  $deleted WHERE id=$comment_id";
        // echo $query;
       	//Enable below function to debug query
	//debug_query($query);		
	
	$result=mysqli_query($con,$query);
	
	$affected_rows=mysqli_affected_rows($con);
	
		$del = "DELETE FROM Hash_tags 
WHERE comment_id=$comment_id";

$r = mysqli_query($con,$del);
	
$matches = null;   // prega_matchs starts

// if (preg_match_all('/(?!\b)(#\w+\b)/',$test,$matches)){
if (preg_match_all('(#\w+\b)',$comment_text,$matches)){
// echo "Matches found!\r\n\r\n";
// var_dump($matches);
//echo"<pre>";
// print_r($matches);
 $a=count($matches, COUNT_RECURSIVE);
$x = array();
for($i=0; $i<$a-1; $i++)
{

$x[$i] = $matches[0][$i];

}
$len1 = count($x);
for($i=0;$i<$len1;$i++)
{
	$query2 = "insert into Hash_tags ( comment_id, media_id, user_id, hash_tags) values ( '$comment_id', '$comment_on', '$comment_by', '$x[$i]' )";
			//echo $query2;
			
			
	$result=mysqli_query($con,$query2);
}//exit;

}// end of prega_matchs
}
else//Invalid Operation.
{
	$post="! Error";
	$result_xml.=getAttrTagString("! Error");//String for XML
	$result_json[]=array("post" => $post);//String for json
}

if($insert_id!=0 || $affected_rows!=0 )
{
	if ($insert_id!=0)
	$query="SELECT `id` as comment_id, `comment_on` as media_id, `comment_text`  ,`comment_by` as user_id, `comment_created_time`, `comment_updated_time` , `deleted` , `is_active` FROM `comments` WHERE `id`=$insert_id";	
	
	if ($affected_rows!=0)
	$query="SELECT * FROM `comments` WHERE `id`=$comment_id";	
	$result="";
	$result=mysqli_query($con,$query);	
	while($post=mysqli_fetch_assoc($result))
	{	
                $post['username'] = get_username_by_user_id($post['user_id']);
                $post['profile_photo'] = get_profile_photo($post['user_id']);
		$post['comment_time'] =  "1 Second";
		$result_xml.=getAttrTagString($post);//String for XML
		$result_json[]=$post;//String for json
	}
}
//echo"<pre>";
//print_r($result_json);
//exit;
if($format=='xml')
displayXmlOutput($result_xml);
if($format=='nxml')
displayNativeXmlOutput($result_json);
if($format=='json')
displayJsonOutput($result_json);

?>
