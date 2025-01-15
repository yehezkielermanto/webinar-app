<?php 
header('content-type:image/jpeg');
    $font="BRUSHSCI.TTF";
	$image=imagecreatefromjpeg("certificate.jpg");
	$color=imagecolorallocate($image,19,21,22);
	$text="Swara Teguh Herawan";
	$font_size=50;
	$angle =0;
    
 // Get image dimensions
$image_width = imagesx($image);
$image_height = imagesy($image);

$text_bound = imageftbbox($font_size, $angle, $font, $text);

//Get the text upper, lower, left and right corner bounds
$lower_left_x =  $text_bound[0]; 
$lower_left_y =  $text_bound[1];
$lower_right_x = $text_bound[2];
$lower_right_y = $text_bound[3];
$upper_right_x = $text_bound[4];
$upper_right_y = $text_bound[5];
$upper_left_x =  $text_bound[6];
$upper_left_y =  $text_bound[7];

//Get Text Width and text height
$text_width =  $lower_right_x - $lower_left_x; //or  $upper_right_x - $upper_left_x
$text_height = $lower_right_y - $upper_right_y; //or  $lower_left_y - $upper_left_y

//Get the starting position for centering
$start_x_offset = ($image_width - $text_width) / 2;
$start_y_offset = ($image_height - $text_height) / 2;

// Add text to image
// imagettftext($image, $font_size, $angle, $start_x_offset, $start_y_offset, $color, $font, $text);
 imagettftext($image, $font_size, $angle, $start_x_offset, 420, $color, $font, $text);
	imagejpeg($image);
	imagedestroy($image);
?>