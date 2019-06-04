<?php
// class.cropcanvas.php 

define("ccTOPLEFT",     0); 
define("ccTOP",         1); 
define("ccTOPRIGHT",    2); 
define("ccLEFT",        3); 
define("ccCENTRE",      4); 
define("ccCENTER",      4); 
define("ccRIGHT",       5); 
define("ccBOTTOMLEFT",  6); 
define("ccBOTTOM",      7); 
define("ccBOTTOMRIGHT", 8); 


function scale_to_width ($filename, $maxwidth, $curwidth, $curheight) {
 	$targetheight = ($curheight / $curwidth) * $maxwidth;
 	return ceil($targetheight);
}

function scale_to_height ($filename, $maxheight, $curwidth, $curheight) {
 	$targetwidth = ($curwidth / $curheight) * $maxheight;
 	return ceil($targetwidth);
}

// GD2 RESIZE IMAGE
function resizeimage($filename,$maxwidth,$maxheight,$qual = 100) 
{ 
	$img_details = getimagesize($filename);
	if($img_details[2] == '1') $src_img = imagecreatefromgif($filename);  // GIF
	else if($img_details[2] == '2') $src_img = imagecreatefromjpeg($filename);  // JPG
	else if($img_details[2] == '3') $src_img = imagecreatefrompng($filename);  // PNG
	else if($img_details[2] == '6') $src_img = imagecreatefrombmp($filename);  // BMP
	$curr_ratio = $img_details[0] / $img_details[1];
	$dest_ratio = $maxwidth / $maxheight;
	if($img_details[1] > $img_details[0] || $curr_ratio <= $dest_ratio){	// TALL IMAGE
		$dest_width = $maxwidth;
		$dest_height = scale_to_width($filename, $maxwidth, $img_details[0], $img_details[1]);
	} else {	// SQUARE OR WIDE IMAGE, LANDSCAPE
		$dest_width = scale_to_height($filename, $maxheight, $img_details[0], $img_details[1]);
		$dest_height = $maxheight;
	}
	$dst_img = imagecreatetruecolor($dest_width,$dest_height);
	imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $img_details[0], $img_details[1]);
	imagejpeg($dst_img, $filename, $qual);
	imagedestroy($src_img);
	imagedestroy($dst_img);
}

function resizeimageMax($filename,$maxwidth=0,$maxheight=0,$qual=100) 
{ 
	$img_details = getimagesize($filename);
	if($img_details[2] == '1') $src_img = imagecreatefromgif($filename);  // GIF
	else if($img_details[2] == '2') $src_img = imagecreatefromjpeg($filename);  // JPG
	else if($img_details[2] == '3') $src_img = imagecreatefrompng($filename);  // PNG
	else if($img_details[2] == '6') $src_img = imagecreatefrombmp($filename);  // BMP
	$curr_ratio = $img_details[0] / $img_details[1];
	if($maxheight == 0){
		$dest_width = $maxwidth;
		$dest_height = scale_to_width($filename, $maxwidth, $img_details[0], $img_details[1]);
	} else if($maxwidth == 0){
		$dest_width = scale_to_height($filename, $maxheight, $img_details[0], $img_details[1]);
		$dest_height = $maxheight;
	}
	$dst_img = imagecreatetruecolor($dest_width,$dest_height);
	imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $img_details[0], $img_details[1]);
	imagejpeg($dst_img, $filename, $qual);
	imagedestroy($src_img);
	imagedestroy($dst_img);
}

class canvasCrop 
{ 
    var $_imgOrig; 
    var $_imgFinal; 
    var $_debug; 
     
    function canvasCrop($debug = FALSE) 
    { 
        $this->_debug = ($debug ? TRUE : FALSE); 
    } 

    // 
    // User called functions 
    // 
	
	function addFrame($type,$w,$h)
	{
		// MERGE FRAME IMAGE
		if($type == 'news'){
			$frameimage = imagecreatefromGIF("../uploads/news/news_frame_vert.gif");
			imagecopymerge($this->_imgFinal, $frameimage, 0,0,0,0,$w,$h,99);	
		} else if($type == 'bios'){
			$frameimage = imagecreatefromGIF("../uploads/bios/bios_frame_vert.gif");
			imagecopymerge($this->_imgFinal, $frameimage, 0,0,0,0,$w,$h,99);	
		} else if($type == 'contest'){
			$frameimage = imagecreatefromGIF("../uploads/contest/contest_frame_horz.gif");
			imagecopymerge($this->_imgFinal, $frameimage, 0,0,0,0,$w,$h,99);	
		}
	}

    function loadImage($filename) 
    { 
        if (!file_exists($filename)) 
        { 
            $this->_debug('loadImage', "The supplied file name '$filename' does not point to a readable file."); 
            return FALSE; 
        } 
         
        $ext  = strtolower(substr($filename, (strrpos($filename,".") ? strrpos($filename,".") + 1 : strlen($filename)), strlen($filename))); 
        if ($ext == 'jpg') $ext = 'jpeg'; 
        $func = "imagecreatefrom$ext"; 
         
        if (!function_exists($func)) 
        { 
            $this->_debug('loadImage', "That file cannot be loaded with the function '$func'."); 
            return FALSE; 
        } 
         
        $this->_imgOrig = @$func($filename);
         
        if ($this->_imgOrig == NULL) 
        { 
            $this->_debug('loadImage', 'The image could not be loaded.'); 
            return FALSE; 
        } 
    } 
     
    function loadImageFromString($string) 
    { 
        $this->_imgOrig = @ImageCreateFromString($string); 
        if (!$this->_imgOrig) 
        { 
            $this->_debug('loadImageFromString', 'The image could not be loaded.'); 
            return FALSE; 
        } 
    } 
     
    function saveImage($filename, $quality = '100') 
    { 
        if ($this->_imgFinal == NULL) 
        { 
            $this->_debug('saveImage', 'There is no processed image to save.'); 
            return FALSE; 
        } 

        $type = $this->_getExtension($filename); 
        $func = "image$type"; 
         
        if (!function_exists($func)) 
        { 
            $this->_debug('saveImage', "That file cannot be saved with the function '$func'."); 
            return FALSE; 
        } 

        if ($type == 'png') $saved = $func($this->_imgFinal, $filename); 
        if ($type == 'jpeg') $saved = $func($this->_imgFinal, $filename, $quality); 
        if ($saved == FALSE) 
        { 
            $this->_debug('saveImage', "Could not save the output file '$filename' as a $type."); 
            return FALSE; 
        } 
        else 
        { 
            return TRUE; 
        } 
    } 

    function cropBySize($x, $y, $position = ccCENTRE) 
    { 
        $nx = @ImageSX($this->_imgOrig) - $x; 
        $ny = @ImageSY($this->_imgOrig) - $y; 
        return ($this->_cropSize(0, 0, $nx, $ny, $position, 'cropBySize')); 
    } 

    function cropToSize($x, $y, $position = ccCENTRE) 
    { 
        return ($this->_cropSize(0, 0, $x, $y, $position, 'cropToSize')); 
    } 

    function cropToDimensions($sx, $sy, $ex, $ey) 
    { 
        $nx = abs($ex - $sx); 
        $ny = abs($ey - $sy); 
        return ($this->_cropSize($sx, $sy, $nx, $ny, $position, 'cropToDimensions')); 
    } 

    function cropByPercent($percentx, $percenty, $position = ccCENTRE) 
    { 
        $nx = @ImageSX($this->_imgOrig) - (($percentx / 100) * @ImageSX($this->_imgOrig)); 
        $ny = @ImageSY($this->_imgOrig) - (($percenty / 100) * @ImageSY($this->_imgOrig)); 
        return ($this->_cropSize(0, 0, $nx, $ny, $position, 'cropByPercent')); 
    } 

    function cropToPercent($percentx, $percenty, $position = ccCENTRE) 
    { 
        $nx = ($percentx / 100) * @ImageSX($this->_imgOrig); 
        $ny = ($percenty / 100) * @ImageSY($this->_imgOrig); 
        return ($this->_cropSize(0, 0, $nx, $ny, $position, 'cropByPercent')); 
    } 

    function flushImages() 
    { 
        @ImageDestroy($this->_imgOrig); 
        @ImageDestroy($this->_imgFinal); 
    } 
	 
    // 
    // Internal functions 
    // 

    function _cropSize($ox, $oy, $nx, $ny, $position, $function) 
    { 
        if ($this->_imgOrig == NULL) 
        { 
            $this->_debug($function, 'The original image has not been loaded.'); 
            return FALSE; 
        } 
        if (($nx <= 0) || ($ny <= 0)) 
        { 
            $this->_debug($function, 'The image could not be cropped because the size given is not valid.'); 
            return FALSE; 
        } 
        if (($nx >= @ImageSX($this->_imgOrig)) || ($ny >= @ImageSY($this->_imgOrig))) 
        { 
            $this->_debug($function, 'The image could not be cropped because the size given is larger than the original image.'); 
            return FALSE; 
        } 
        $this->_imgFinal = @ImageCreateTrueColor($nx, $ny); 
        if (!$ox || !$oy) 
        { 
            list($ox, $oy) = $this->_getCopyPosition($nx, $ny, $position); 
        } 
        ImageCopyResampled($this->_imgFinal, $this->_imgOrig, 0, 0, $ox, $oy, $nx, $ny, $nx, $ny); 
    } 

    function _getCopyPosition($nx, $ny, $position) 
    { 
        $ox = @ImageSX($this->_imgOrig); 
        $oy = @ImageSY($this->_imgOrig); 
         
        switch($position) 
        { 
            case ccTOPLEFT: 
                return array(0, 0); 
            case ccTOP: 
                return array(ceil(($ox - $nx) / 2), 0); 
            case ccTOPRIGHT: 
                return array(($ox - $nx), 0); 
            case ccLEFT: 
                return array(0, ceil(($oy - $ny) / 2)); 
            case ccCENTRE: 
                return array(ceil(($ox - $nx) / 2), ceil(($oy - $ny) / 2)); 
            case ccRIGHT: 
                return array(($ox - $nx), ceil(($oy - $ny) / 2)); 
            case ccBOTTOMLEFT: 
                return array(0, ($oy - $ny)); 
            case ccBOTTOM: 
                return array(ceil(($ox - $nx) / 2), ($oy - $ny)); 
            case ccBOTTOMRIGHT: 
                return array(($ox - $nx), ($oy - $ny)); 
        } 
    } 
     
    function _getExtension($filename) 
    { 
        $ext  = strtolower(substr($filename, (strrpos($filename, ".") ? strrpos($filename, ".") + 1 : strlen($filename)), strlen($filename))); 
        if ($ext == 'jpg') $ext = 'jpeg'; 
        return $ext; 
    } 

    function _debug($function, $string) 
    { 
        if(SHOWDEVHTML){
        	echo "<p><strong style=\"color:#FF0000\">Error in function $function:</strong> $string</p>\n"; 
    	}
    } 
} 
?>
