<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Image_lib extends CI_Image_lib
{
	//扩展裁剪类，生成的缩略图为(_200-200.jpg)
	function my_corp($source_path, $target_width, $target_height)
	{
		$source_info   = getimagesize($source_path);
		$source_width  = $source_info[0];
		$source_height = $source_info[1];
		$source_mime   = $source_info['mime'];
		$source_ratio  = $source_height / $source_width;
		$target_ratio  = $target_height / $target_width;
	
		// 源图过高
		if ($source_ratio > $target_ratio)
		{
			$cropped_width  = $source_width;
			$cropped_height = $source_width * $target_ratio;
			$source_x = 0;
			$source_y = ($source_height - $cropped_height) / 2;
		}
		// 源图过宽
		elseif ($source_ratio < $target_ratio)
		{
			$cropped_width  = $source_height / $target_ratio;
			$cropped_height = $source_height;
			$source_x = ($source_width - $cropped_width) / 2;
			$source_y = 0;
		}
		// 源图适中
		else
		{
			$cropped_width  = $source_width;
			$cropped_height = $source_height;
			$source_x = 0;
			$source_y = 0;
		}
	
		switch ($source_mime)
		{
			case 'image/gif':
				$source_image = imagecreatefromgif($source_path);
				$hz='.gif';
				break;
	
			case 'image/jpeg':
				$source_image = imagecreatefromjpeg($source_path);
				$hz='.jpg';
				break;
	
			case 'image/png':
				$source_image = imagecreatefrompng($source_path);
				$hz='.png';
				break;
	
			default:
				return false;
				break;
		}
	
		$target_image  = imagecreatetruecolor($target_width, $target_height);
		$cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);
	
		// 裁剪
		imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height); 
		
		// 缩放
		imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $target_width, $target_height, $cropped_width, $cropped_height);

        imagejpeg($target_image, $source_path.'_'.$target_width.'-'.$target_height.$hz);		
		imagedestroy($source_image);
		imagedestroy($target_image);
		imagedestroy($cropped_image);	
	}
}