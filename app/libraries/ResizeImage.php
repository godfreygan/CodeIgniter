
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ResizeImage
{
	private $type;
	private $width;
	private $height;
	private $resize_width;
	private $resize_height;
	private $cut;
	private $srcimg;
	private $dstimg;
	private $im;

	function full($imgPath, $width, $height, $isCut, $savePath)
	{
		$this->srcimg = $imgPath;
		$this->resize_width = $width;
		$this->resize_height = $height;
		$this->cut = $isCut;
		$this->type = strtolower(substr(strrchr($this->srcimg,"."),1));
		$this->init_img();
		$this -> dst_img($savePath);
		$this->width = imagesx($this->im);
		$this->height = imagesy($this->im);
		$this->create_img();
		ImageDestroy ($this->im);
	}

	private function create_img()
	{
		$resize_ratio = ($this->resize_width)/($this->resize_height);
		$ratio = ($this->width)/($this->height);
		if($this->cut)
		{
			$newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);
			if($this->type=="png")
			{
				imagefill($newimg, 0, 0, imagecolorallocatealpha($newimg, 0, 0, 0, 127));
			}
			if($ratio>=$resize_ratio)
			{
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
			}else{
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width)/$resize_ratio));
			}
		}else{
			if($ratio>=$resize_ratio)
			{
				$newimg = imagecreatetruecolor($this->resize_width,($this->resize_width)/$ratio);
				if($this->type=="png")
				{
					imagefill($newimg, 0, 0, imagecolorallocatealpha($newimg, 0, 0, 0, 127));
				}
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width)/$ratio, $this->width, $this->height);
			}else{
				$newimg = imagecreatetruecolor(($this->resize_height)*$ratio,$this->resize_height);
				if($this->type=="png")
				{
					imagefill($newimg, 0, 0, imagecolorallocatealpha($newimg, 0, 0, 0, 127));
				}
				imagecopyresampled($newimg, $this->im, 0, 0, 0, 0, ($this->resize_height)*$ratio, $this->resize_height, $this->width, $this->height);
			}
		}
		if($this->type=="png")
		{
			imagesavealpha($newimg, true);
			imagepng ($newimg, $this->dstimg);
		}else{
			imagejpeg ($newimg, $this->dstimg);
		}
	}

	private function init_img()
	{
		if($this->type=="jpg")
		{
			$this->im = imagecreatefromjpeg($this->srcimg);
		}
		if($this->type=="gif")
		{
			$this->im = imagecreatefromgif($this->srcimg);
		}
		if($this->type=="png")
		{
			$this->im = imagecreatefrompng($this->srcimg);
		}
	}

	private function dst_img($dstpath)
	{
		$full_length = strlen($this->srcimg);
		$type_length = strlen($this->type);
		$name_length = $full_length-$type_length;
		$name = substr($this->srcimg, 0, $name_length-1);
		$this->dstimg = $dstpath;
	}
}