<?php
/**
* @framework CakePHP v 1.x Or higher
* @php v 5.x or higher
* @class ResizeHelper v 1.0
* @path app\views\helpers\resize.php
* @description http://harake.wordpress.com/2010/02/02/the-resize-helper-to-resize-images-on-the-fly/
* @author Hussein Ahmad Harake, single, male, and Lebanese Web Engineer/Developer (born in 1977)
* @copyright 2000 - 2010, Hussein Ahmad Harake
* @email hussein_elharake@yahoo.com
* @phone 0096170719664
* @license http://www.opensource.org/licenses/lgpl-license.php - Any LGPL license you like
*/
class ResizeHelper extends AppHelper {
	private $__dimensions = array();
	public $versions_store = null;
	public $versions_public = null;
	public $versions_webroot = null;
	public function pad($filename, $destination_width, $destination_height, $x, $y)	{
		/*
		The positions of the small image according to the container ($destination_width, $destination_height) are
		1 2 3 //for x
		2
		3
		// for y 
		*/
		return $this->__resize($filename, $destination_width, $destination_height, $x . 'x' . $y);
		}

	public function wrap($filename, $destination_width, $destination_height) {
		return $this->__resize($filename, $destination_width, $destination_height, 'thumb');
	}

	public function crop($filename, $destination_width, $destination_height) {
		return $this->__resize($filename, $destination_width, $destination_height, 'cc');
	}

	public function dimensions() {
		return $this->__dimensions;
	}

	public function reset() {
		$this->__dimensions = array();
		$this->versions_store = null;
		$this->versions_public = null;
		$this->versions_webroot = null;
	}
	
	private function __resize($filename, $destination_width, $destination_height, $how) {
		if (!function_exists("gd_info")) {
			return false; //gd library dosent exist
		}
		if (empty($this->versions_store)) {
			if (Configure::read('versions_store')) {
				$this->versions_store = Configure::read('versions_store');
			} elseif (defined('VERSIONS_STORE')) {
				$this->versions_store = VERSIONS_STORE;
			} else {
				return false;
			}
		}
		if (!is_dir($this->versions_store)) {
			return false;
		}
		$DS_length = strlen(DS);
		$versions_store_length = strlen($this->versions_store);
		$last_DS_length_chars = substr($this->versions_store, $versions_store_length - $DS_length);
		if ($last_DS_length_chars !== DS) {
			$this->versions_store .= DS;
		}
		$filepath = $this->versions_store . $filename;
		if (!file_exists($filepath)) {
			return false; //file dosent exist
		}
		$fi = @getimagesize($filepath);
		if (empty($fi)) {
			return false; //not a valid picture
		}
		if (empty($fi[0]) || empty($fi[1])) {
			return false; //probably multiple images into one
		}
		if (empty($this->versions_webroot)) {
			if (Configure::read('versions_webroot')) {
				$this->versions_webroot = Configure::read('versions_webroot');
			} else  {
				$this->versions_webroot = WWW_ROOT;
			}
		}
		if (empty($this->versions_public)) {
			if (Configure::read('versions_public')) {
				$this->versions_public = Configure::read('versions_public');
			} elseif (defined('VERSIONS_PUBLIC')) {
				$this->versions_public = VERSIONS_PUBLIC;
			} else  {
				$this->versions_public = $this->versions_webroot;
			}
		}
		$pos = strpos($this->versions_public, $this->versions_webroot);
		if (is_bool($pos)) { //same as $pos === false
			$this->versions_public = $this->versions_webroot . $this->versions_public;
		} elseif (!$pos) { //same as $pos === 0
			//DO NOTHING
		} else { //same as $pos > 0
			return false;
		}
		$versions_public_length = strlen($this->versions_public);
		if (!is_dir($this->versions_public)) {
			$webroot_length = strlen($this->versions_webroot);
			$relative_versions_public = explode(DS, substr($this->versions_public, $webroot_length, $versions_public_length - $webroot_length - $DS_length + 1));
			$versions_public = $this->versions_webroot;
			foreach ($relative_versions_public as $folder) {
				$versions_public .= $folder;
				if (!is_dir($versions_public) && !@mkdir($versions_public, 0755)) {
					return false;
				}
				$versions_public .= DS;
			}
			$this->versions_public = $versions_public;
		} else {
			$last_DS_length_chars = substr($this->versions_public, $versions_public_length - $DS_length);
			if ($last_DS_length_chars !== DS) {
				$this->versions_public .= DS;
			}
		}
		if (is_file($this->versions_public . $how. $filename)) {
			return $this->__fetchURL($how, $destination_width, $destination_height, $filename);
		}
		$cd = $this->versions_public . $how;
		if (!is_dir($cd) && !@mkdir($cd, 0755)) {
			return false;
		}
		//$cd .= DS . $destination_width . "x$destination_height";
		//if (!is_dir($cd) && !@mkdir($cd, 0755)) {
		//	return false;
		//}
		return $this->__createResized($filename, $destination_width, $destination_height, $how, $fi[0], $fi[1], $fi['mime'], $filepath, $cd . DS);
	}

	private function __fetchURL($how, $w, $h, $filename) {
		$fi = @getimagesize($this->versions_public . $how . DS . $w . 'x' . $h . DS . $filename, $info);
		if (empty($fi)) {
			return false; //not a valid picture
		}
		if (empty($fi[0]) || empty($fi[1])) {
			return false; //probably multiple images into one
		}
		$this->__dimensions = array('width' => $fi[0], 'height' => $fi[1], 'image_type' => $fi[2], 'text_string' => $fi[3]);
		return '/' . str_replace(DS, '/', str_replace($this->versions_webroot, '', $this->versions_public)) . "$how/$w" . "x$h/$filename";
	}

	private function __createResized($filename, $destination_width, $destination_height, $how, $source_width, $source_height, $mime, $filepath, $cd) {
		if ($how == 'cc') {
			$height_width_ratio = min($destination_width / $source_width, $destination_height / $source_height);
			if ($height_width_ratio >= 1) { //we are not resizing to small, return the file
				$cd = $this->versions_public . $how;
				if (is_dir($cd)) {
					$cd = $cd . DS . $filename;
					if (!is_file($cd)) {
						copy($filepath, $cd);
					}
				} else {
					if (!@mkdir($cd, 0755)) {
						return false;
					}
					$cd = $cd . DS;
					copy($this->versions_public . $filename, $cd . $filename);
				}
				return $this->__fetchURL($how, $source_width, $source_height, $filename);
			}
			 //we are resizing to small
			if ($source_width < $destination_width || $source_height < $destination_height) { //exactly one dimension is growing, correct new dimension
				$correct_dst_dim = max($destination_width / $source_width, $destination_height / $source_height);
				$destination_width = floor($destination_width / $correct_dst_dim);
				$destination_height = floor($destination_height / $correct_dst_dim);
				$cd = $this->versions_public . $how;
				if (is_dir($cd)) {
					$cd = $cd . DS;
					if (is_file("$cd" . $filename)) {
						return $this->__fetchURL($how, $destination_width, $destination_height, $filename);
					}
				} else {
					if (!@mkdir($cd, 0755)) {
						return false;
					}
					$cd = $cd . DS;
				}
			}
			$height_width_ratio = min($source_width / $destination_width, $source_height / $destination_height);
			$destination_image_identifier = @imagecreatetruecolor($destination_width, $destination_height);
			$ideal_source_width = $height_width_ratio * $destination_width;
			$ideal_source_height = $height_width_ratio * $destination_height;
		} elseif ($how == 'thumb') {
			$height_width_ratio = min($destination_width / $source_width, $destination_height / $source_height);
			if ($height_width_ratio >= 1) { //we are not resizing to small, return the file
				$cd = $this->versions_public . $how;
				if (is_dir($cd)) {
					$cd = $cd . DS . $filename;
					if (!is_file($cd)) {
						copy($filepath, $cd);
					}
				} else {
					if (!@mkdir($cd, 0755)) {
						return false;
					}
					$cd = $cd . DS . $filename;
					copy($filepath, $cd);
				}
				return $this->__fetchURL($how, $source_width, $source_height, $filename);
			}
			$ideal_source_width = $height_width_ratio * $source_width;
			$ideal_source_height = $height_width_ratio * $source_height;
			$destination_image_identifier = @imagecreatetruecolor($ideal_source_width, $ideal_source_height);
		} elseif (in_array($how, array('1x1', '1x2', '1x3', '2x1', '2x2', '2x3', '3x1', '3x2', '3x3'))) {
			$height_width_ratio = min($destination_width / $source_width, $destination_height / $source_height);
			if ($height_width_ratio > 1) {
				$height_width_ratio = 1;
			}
			$destination_image_identifier = @imagecreatetruecolor($destination_width, $destination_height);
			@imagefilledrectangle($destination_image_identifier, 0, 0, $destination_width, $destination_height, @imagecolorallocate($destination_image_identifier, 255, 255, 255));
			$ideal_destination_height = floor($height_width_ratio * $source_height);
			$ideal_destination_width = floor($height_width_ratio * $source_width);
		} else {
			return false;
		}
		switch($mime) {
			case "image/gif":
								$source_image_identifier = @imagecreatefromgif($filepath);
								$tidx = @imagecolortransparent($source_image_identifier);
								if ($tidx >= 0) {
									$tcol = @imagecolorsforindex($source_image_identifier, $tidx);
									$tidx = @imagecolorallocate($destination_image_identifier, $tcol['red'], $tcol['green'], $tcol['blue']);
									@imagefill($destination_image_identifier, 0, 0, $tidx);
									@imagecolortransparent($destination_image_identifier, $tidx);
									$total_number_of_colors_of_the_palette_of_the_gif_source_image = @imagecolorstotal($source_image_identifier);
									@imagetruecolortopalette($destination_image_identifier, TRUE, $total_number_of_colors_of_the_palette_of_the_gif_source_image);
								}
								break;
			case "image/jpeg":
								$source_image_identifier = @imagecreatefromjpeg($filepath);
								break;
			case "image/png":
								$source_image_identifier = @imagecreatefrompng($filepath);
								$tidx = @imagecolortransparent($source_image_identifier);
								if ($tidx >= 0) {
									$tcol = @imagecolorsforindex($source_image_identifier, $tidx);
									$tidx = @imagecolorallocate($destination_image_identifier, $tcol['red'], $tcol['green'], $tcol['blue']);
									@imagefill($destination_image_identifier, 0, 0, $tidx);
									@imagecolortransparent($destination_image_identifier, $tidx);
								} 
								@imagealphablending($destination_image_identifier, false);
								$color = @imagecolorallocatealpha($destination_image_identifier, 0, 0, 0, 127);
								@imagefill($destination_image_identifier, 0, 0, $color);
								imagesavealpha($destination_image_identifier, true);
								break;
			default:
					return false;
		}
		if ($how == 'cc') {
			@imagecopyresampled($destination_image_identifier, $source_image_identifier, 0, 0, ($source_width - $ideal_source_width) / 2, ($source_height - $ideal_source_height) / 2, $destination_width, $destination_height, $ideal_source_width, $ideal_source_height);
		} elseif ($how == 'thumb') {
			@imagecopyresampled($destination_image_identifier, $source_image_identifier, 0, 0, 0, 0, $ideal_source_width, $ideal_source_height, $source_width, $source_height);
		} elseif (in_array($how, array('1x1', '1x2', '1x3', '2x1', '2x2', '2x3', '3x1', '3x2', '3x3'))) {
			$destination_x = (-1 + intval($how[0])) * ($destination_width - $ideal_destination_width) / 2 ;
			$destination_y = (-1 + intval($how[2])) * ($destination_height - $ideal_destination_height) / 2 ;
			@imagecopyresampled($destination_image_identifier, $source_image_identifier, $destination_x, $destination_y, 0, 0, $ideal_destination_width, $ideal_destination_height, $source_width, $source_height);
		}
		else {
			return false;
		}
		$cd = $cd . $filename;
		switch($mime) {
			case "image/gif":
								@imagegif($destination_image_identifier, $cd);
								break;
			case "image/jpeg":
								@imagejpeg($destination_image_identifier, $cd);
								break;
			case "image/png":
								@imagepng($destination_image_identifier, $cd);
								break;
			default:
					return false;
		}
		return $this->__fetchURL($how, $destination_width, $destination_height, $filename);
	}
}
?>