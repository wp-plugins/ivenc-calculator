<?php
/*
Plugin Name: IVENC Calculator
Plugin URI: http://www.ivenc.com/ru/m-ivenc-online-calc
Description: IVENC Calculator is flexible tool for create different calculators through customize xml-file
Version: 1.0
Author: IVENC LLC, Ilya Protasov
Author URI: http://www.ivenc.com/


    Copyright 2010  IVENC LLC  (email: calc@ivenc.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define("CALC_WIDTH", 400);
define("CALC_HEIGHT", 400);

function iv_calc_substitute(&$match) {
    $len = count( $match );
    $str = "";

	$width =  ($match['width'] != "") ?  $match['width'] : CALC_WIDTH;
	$height = ($match['height'] != "") ? $match['height'] : CALC_HEIGHT;
	$xml = 	  ($match['xml'] != "") ? 	 $match['xml'] : 'widget-calc-data.xml';
	
	$str = $str.'width='.$width.';';
	$str = $str.'height='.$height.';';
	$str = $str.'xml='.$xml.'.';
	
	$flash_vars = '<param name="FlashVars" value="xmlcalc='.$xml.'&cachexml=cache" />';
	$embed_vars = ' FlashVars="xmlcalc='.$xml.'&cachexml=cache" ';
	if ( function_exists('plugins_url') ) { 
		$movie = plugins_url('ivenc-calculator/').'ivenc_calculator_1.0.0.swf';
	} else {
		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/ivenc-calculator/ivenc_calculator_1.0.0.swf";
	}
	return '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$width.'" height="'.$height.'" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0"><param name="src" value="'.$movie.'" />'.$flash_vars.'<embed type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" src="'.$movie.'" '.$embed_vars.' > </embed></object>';
}

function iv_calc_before_filter( $content ) {
    return preg_replace_callback(
        "/\s*\[iv-calc\](?:width:(?P<width>\d*%?);|height:(?P<height>\d*%?);|xml:(?P<xml>.*);|\s)*\[\/iv-calc\]\s*/siU",
        "iv_calc_substitute",
        $content
    );
}

add_filter( 'the_content', 'iv_calc_before_filter', 99 );
?>
