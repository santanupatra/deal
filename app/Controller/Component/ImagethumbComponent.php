<?php
class ImagethumbComponent extends Component{

	function generateThumb( $src_path, $thumb_path, $thumb_width,$image_file_name ) 
	{
	
  		$src_dir = 	opendir( $src_path );

    	$img_path_info 	= 	pathinfo($src_path . $image_file_name);
    	if(strtolower($img_path_info['extension']) == 'jpg') 
		{
      		$image 	= 	imagecreatefromjpeg( "{$src_path}{$image_file_name}" );
		} 
		else if(strtolower($img_path_info['extension']) == 'png')
		{
	 		$image 	= 	imagecreatefrompng( "{$src_path}{$image_file_name}" );
		} 
		
		else if( strtolower($img_path_info['extension']) == 'gif'){
	 		$image 	= 	imagecreatefromgif( "{$src_path}{$image_file_name}" );
		} 
	 
	    $imgwidth = imagesx( $image );
	    $imgheight = imagesy( $image );
	    $new_thumb_width = $thumb_width;
	    $new_thumb_height = floor( $imgheight * ( $thumb_width / $imgwidth ) );
	    $temp_img = imagecreatetruecolor( $new_thumb_width, $new_thumb_height );
	    imagecopyresized( $temp_img, $image, 0, 0, 0, 0, $new_thumb_width, $new_thumb_height, $imgwidth, $imgheight );
	  
		if(strtolower($img_path_info['extension']) == 'jpg') 
		{
	      imagejpeg( $temp_img, "{$thumb_path}{$image_file_name}" );
		} 
		else if(strtolower($img_path_info['extension']) == 'png')
		{
		 	imagepng( $temp_img, "{$thumb_path}{$image_file_name}" );
		} 
		else  if ( strtolower($img_path_info['extension']) == 'gif' ){
		    imagegif( $temp_img, "{$thumb_path}{$image_file_name}" );
		} 
	}
}

?>