<?php
/*
Plugin Name: AdSense Targeting
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/adsense-targeting
Description: This plugin wraps your content in Google AdSense Tags for better ad targeting. While editing your posts, you will have however the possibility to wrap part of your content in ignore tags.
Version: 1.0
Author: Waldemar Stoffel
Author URI: http://www.waldemarstoffel.com
License: GPL3
Text Domain: adsense-targeting
*/

/*  Copyright 2011  Waldemar Stoffel  (email : stoffel@atelier-fuenf.de)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/


/* Stop direct call */

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die(__('Sorry, you don&#39;t have direct access to this page.'));

// import laguage files

load_plugin_textdomain('adsense-targeting', false , basename(dirname(__FILE__)).'/languages');

//Additional links on the plugin page

add_filter('plugin_row_meta', 'at_register_links',10,2);

function at_register_links($links, $file) {
	
	$base = plugin_basename(__FILE__);
	if ($file == $base) :
		
		$links[] = '<a href="http://wordpress.org/extend/plugins/adsense-targeting/faq/" target="_blank">'.__('FAQ','adsense-targeting').'</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=W4ZPZHXCBEGE6" target="_blank">'.__('Donate','adsense-targeting').'</a>';
	
	endif;
	
	return $links;

}

// adding short code 

add_shortcode( 'at_ignore_tag', 'at_wrap_ignore');

function at_wrap_ignore($atts, $content = null){
	
	$eol = "\r\n";
	
	return $eol.'<!-- google_ad_section_end -->'.$eol.'<!-- google_ad_section_start(weight=ignore) -->'.$eol.do_shortcode($content).$eol.'<!-- google_ad_section_end -->'.$eol.'<!-- google_ad_section_start -->'.$eol;
}

// get the tinymce plugin

include_once('tinymce/tinymce.php');

// wrapping the content into adsense tags

add_filter('the_content', 'at_set_tags');
add_filter('the_excerpt', 'at_set_tags');

function at_set_tags($content) {
	
	$eol = "\r\n";
	
	return $eol.'<!-- google_ad_section_start -->'.$eol.$content.$eol.'<!-- google_ad_section_end -->'.$eol;

}

?>