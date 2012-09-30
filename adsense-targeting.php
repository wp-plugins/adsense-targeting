<?php
/*
Plugin Name: AdSense Targeting
Plugin URI: http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/adsense-targeting
Description: This plugin wraps your content in Google AdSense Tags for better ad targeting. While editing your posts, you will have however the possibility to wrap part of your content in ignore tags.
Version: 1.2
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

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) die('Sorry, you don&#39;t have direct access to this page.');

// get the tinymce plugin

define( 'AT_PATH', plugin_dir_path(__FILE__) );

if (!class_exists('A5_AddMceButton')) require_once AT_PATH.'tinymce/A5_MCEButtonClass.php';
		
// AdSenseTargeting begin of class

class AdSenseTargeting {
	
	static $language_file = 'adsense-targeting';
	
	function AdSenseTargeting() {

	// import laguage files
	
	load_plugin_textdomain(self::$language_file, false , basename(dirname(__FILE__)).'/languages');
	
	add_filter('plugin_row_meta', array($this, 'at_register_links'),10,2);
	add_shortcode( 'at_ignore_tag', array($this, 'at_wrap_ignore'));
	add_filter('the_content', array($this, 'at_set_tags'));
	add_filter('the_excerpt', array($this, 'at_set_tags'));
	add_action( 'wp_head', array($this, 'at_header'), 1000);
	
	$tinymce_button = new A5_AddMceButton ('adsense-targeting', 'GoogleIgnoreTags', 'mce_buttons_2');
	
	}
	
	// Selbstbeweihräucherung
	
	function at_header() {
		
		echo "<!-- Google AdSense Tags powered by Waldemar Stoffel's AdSense Targeting http://wasistlos.waldemarstoffel.com/plugins-fur-wordpress/adsense-targeting -->\r\n";
		
	}	
	
	//Additional links on the plugin page
	
	function at_register_links($links, $file) {
		
		$base = plugin_basename(__FILE__);
		
		if ($file == $base) :
			
			$links[] = '<a href="http://wordpress.org/extend/plugins/adsense-targeting/faq/" target="_blank">'.__('FAQ', self::$language_file).'</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GTBQ93W3FCKKC" target="_blank">'.__('Donate', self::$language_file).'</a>';
		
		endif;
		
		return $links;
	
	}
	
	// adding short code
	
	function at_wrap_ignore($atts, $content = null){
		
		$eol = "\r\n";
		
		return $eol.'<!-- google_ad_section_end -->'.$eol.'<!-- google_ad_section_start(weight=ignore) -->'.$eol.do_shortcode($content).$eol.'<!-- google_ad_section_end -->'.$eol.'<!-- google_ad_section_start -->'.$eol;
	}
	
	// wrapping the content into adsense tags
	
	function at_set_tags($content) {
		
		$eol = "\r\n";
		
		return $eol.'<!-- google_ad_section_start -->'.$eol.$content.$eol.'<!-- google_ad_section_end -->'.$eol;
	
	}
	
} // end of class

$adsensetargeting = new AdSenseTargeting;

?>