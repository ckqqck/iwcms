<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! function_exists('showImage'))
{
  function showImage($data = '', $img_path ='', $img_url = '', $font_path = null,$codeNum = ''){
    	   $defaults = array(
    	    		'word' => '',
    	    		'img_path'  => '',
    	    		'img_url'   => '',
    	    		'font_path' => '',
    	    		'img_width' => 150,
    	    		'img_height'    => 35,
    	    		'expiration'    => 7200,
    	    		'codeNum'   => 4,
    	    		'font_size' => 16,
    	    		'img_id'    => 'Imageid',
    	    		'pool'      => '23456789abcdefghjklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ'
    	    );
    	    foreach ($defaults as $key => $val)
    	    {
    	    	if ( ! is_array($data) && empty($$key))
    	    	{
    	    		$$key = $val;
    	    	}
    	    	else
    	    	{
    	    		$$key = isset($data[$key]) ? $data[$key] : $val;
    	    	}
    	    }
    	    if ($img_path === '' OR $img_url === ''
    	    		OR ! is_dir($img_path) OR ! is_really_writable($img_path)
    	    		OR ! extension_loaded('gd'))
    	    {
    	    	return FALSE;
    	    }
    	    // -----------------------------------
    	    // 删除就图片
    	    // -----------------------------------
    	    
    	    $now = microtime(TRUE);
    	    
    	    $current_dir = @opendir($img_path);
    	    while ($filename = @readdir($current_dir))
    	    {
    	    	if (substr($filename, -4) === '.jpg' && (str_replace('.jpg', '', $filename) + $expiration) < $now)
    	    	{
    	    		@unlink($img_path.$filename);
    	    	}
    	    }
    	    
    	    @closedir($current_dir);
    	    
    		//创建图像资源
    		$image = function_exists('imagecreatetruecolor')
    		? imagecreatetruecolor($img_width, $img_height)
    		: imagecreate($img_width, $img_height);
    		//随机创建背景色
    		 $i=rand(0, 5);
    		switch ($i){
    			case 0:$backColor=imagecolorallocate($image, 251, 234,243);
    		           imagefill($image, 0, 0, $backColor);
    		           //画出矩形边框
    		           $border=imagecolorallocate($image,250, 215,230);
    		           imagerectangle($image, 0, 0, $img_width-1, $img_height-1, $border);
    		           //字体颜色
    		           $fontcolor=imagecolorallocate($image, 250, 100, 100);
    		    break;
    			case 1:$backColor=imagecolorallocate($image, 250, 230,250);
    				   imagefill($image, 0, 0, $backColor);
    				   //画出矩形边框
    				   $border=imagecolorallocate($image,250, 200,250);
    				   imagerectangle($image, 0, 0, $img_width-1, $img_height-1, $border);
    				   //字体颜色
    				   $fontcolor=imagecolorallocate($image, 250, 100, 250);
    				break;
    			case 2:$backColor=imagecolorallocate($image, 230, 230,250);
    				   imagefill($image, 0, 0, $backColor);
    				   //画出矩形边框
    				   $border=imagecolorallocate($image,210, 210,255);
    				   imagerectangle($image, 0, 0, $img_width-1, $img_height-1, $border);
    				   //字体颜色
    				   $fontcolor=imagecolorallocate($image, 100, 100, 255);
    				break;
    			case 3:$backColor=imagecolorallocate($image, 230, 250,250);
    				   imagefill($image, 0, 0, $backColor);
    				   //画出矩形边框
    				   $border=imagecolorallocate($image,200, 240,250);
    				   imagerectangle($image, 0, 0, $img_width-1, $img_height-1, $border);
    				   //字体颜色
    				   $fontcolor=imagecolorallocate($image, 100, 140, 250);
    				break;
    			case 4:$backColor=imagecolorallocate($image, 240, 255,245);
    				   imagefill($image, 0, 0, $backColor);
    				   //画出矩形边框
    				   $border=imagecolorallocate($image,220, 255,230);
    				   imagerectangle($image, 0, 0, $img_width-1, $img_height-1, $border);
    				   //字体颜色
    				   $fontcolor=imagecolorallocate($image, 50, 180, 130);
    				break;
    			default:$backColor=imagecolorallocate($image, 240, 240,240);
    				   imagefill($image, 0, 0, $backColor);
    				   //画出矩形边框
    				   $border=imagecolorallocate($image,190, 140,140);
    				   imagerectangle($image, 0, 0, $img_width-1, $img_height-1, $border);  
    				   //字体颜色及狐度
    				   $fontcolor=imagecolorallocate($image, 180, 33, 30);
    		}
    		
    		$word =$defaults['word'];
    		
    		if ($word == '')
	        {
    		        $string='';
    		        for ($i=0;$i< $codeNum; $i++){
    			           $cher=$pool{rand(0,	strlen($pool)-1)};
    			           $string.=$cher;
    		        }
    		        
    		        $word = $string;
    		}
    		
    		// -----------------------------------
    		// Determine angle and position
    		// -----------------------------------
    		$length	= strlen($word);
    		$angle	= ($length >= 6) ? mt_rand(-($length-6), ($length-6)) : 0;
    		//增加字符弧度
    		//$angle	= rand(-20,20);
    		$x_axis	= mt_rand(6, (360/$length)-16);
    		$y_axis = ($angle >= 0) ? mt_rand($img_height, $img_width) : mt_rand(6, $img_height);
    		
    		// -----------------------------------
    		//  创建干扰码
    		// -----------------------------------
    		$theta		= 1;
    		$thetac		= 7;
    		$radius		= 16;
    		$circles	= 20;
    		$points		= 32;
    		
    		for ($i = 0, $cp = ($circles * $points) - 1; $i < $cp; $i++)
    		{
    			$theta += $thetac;
    			$rad = $radius * ($i / $points);
    			$x = ($rad * cos($theta)) + $x_axis;
    			$y = ($rad * sin($theta)) + $y_axis;
    			$theta += $thetac;
    			$rad1 = $radius * (($i + 1) / $points);
    			$x1 = ($rad1 * cos($theta)) + $x_axis;
    			$y1 = ($rad1 * sin($theta)) + $y_axis;
    			imageline($image, $x, $y, $x1, $y1, $fontcolor);
    			$theta -= $thetac;
    		}
    		// -----------------------------------
    		//  写字
    		// -----------------------------------
    		
    		$use_font = ($font_path !== '' && file_exists($font_path) && function_exists('imagettftext'));
    		if ($use_font === FALSE)
    		{
    			($font_size > 5) && $font_size = 5;
    			$x = mt_rand(0, $img_width / ($codeNum / 3));
    			$y = 0;
    		}
    		else
    		{
    			($font_size > 30) && $font_size = 30;
    			$x = mt_rand(0, $img_width / ($codeNum / 1.5));
    			$y = $font_size + 2;
    		}
    		
    		for ($i = 0; $i < $codeNum; $i++)
    		{
    			if ($use_font === FALSE)
    			{
    				$y = mt_rand(0 , $height / 2);
    				//imagestring($image, $font_size, $x, $y, $word[$i], $fontcolor);
    				imagechar($image, $font_size, $x, $y, $word{$i}, $fontcolor);
    				$x += ($font_size * 2);
    			}
    			else
    			{
    				$y = mt_rand($img_height / 2, $img_height - 3);
    				imagettftext($image, $font_size, $angle, $x, $y, $fontcolor, $font_path, $word[$i]);
    				$x += $font_size;
    			}
    		}
    		
    	    list($usec, $sec) = explode(" ", microtime());
    	    $now = ((float)$usec + (float)$sec);
    	   
    		// -----------------------------------
    		//  Generate the image
			/*
    	    $img_name = $now.'.jpg';
    	    
    	    if (imagetypes() & IMG_GIF){
    	    	imagegif($image, $img_path.$img_name);
    	    }else if(imagetypes() & IMG_JPG){
    	    	imagejpeg($image, $img_path.$img_name);
    	    }else if(imagetypes() & IMG_PNG){
    	    	imagepng($image, $img_path.$img_name);
    	    }else{
    	    	return FALSE;
    	    }
    	    */
    		$img_url = rtrim($img_url, '/').'/';
    		
    		if (function_exists('imagejpeg'))
    		{
    			$img_name = $now.'.jpg';
    			imagejpeg($image, $img_path.$img_name);
    		}
    		elseif (function_exists('imagepng'))
    		{
    			$img_name = $now.'.png';
    			imagepng($image, $img_path.$img_name);
    		}
    		else
    		{
    			return FALSE;
    		}
    		$img = '<img '.($img_id === '' ? '' : 'id="'.$img_id.'"').' src="'.$img_url.$img_name.'" style="width: '.$img_width.'; height: '.$img_height .'; border: 0;" alt=" " title="点击刷新" onclick="ckimg();"/>';
			imagedestroy($image);   
    		
    		return array('word' => $word, 'time' => $now, 'image' => $img, 'filename' => $img_url.$img_name);
  }
}
?>
