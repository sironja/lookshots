<?php
$src="http://www.lookshots.com/lookshot/images/media/test.jpg";
$dest="/lookshot/";
$desired_width=208;
make_thumb($src, $dest, $desired_width);
function make_thumb($src, $dest, $desired_width) {
echo "<br>".$src;
echo "<br>".$dest;
echo "<br>".$desired_width;

	/* read the source image */
	echo "<br>sourceimage : ".$source_image = imagecreatefromjpeg($src);
	echo "<br>width : ".$width = imagesx($source_image);
	echo "<br>height : ".$height = imagesy($source_image);

	/* find the "desired height" of this thumbnail, relative to the desired width  */
	echo "<br> desired_height : ".$desired_height = floor($height * ($desired_width / $width));

	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest);
}

echo "Called";
?>
