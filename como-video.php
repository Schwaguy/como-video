<?php
/*
Plugin Name: Como Video Embed
Plugin URI: http://www.comocreative.com/
Version: 1.2.2
Author: Como Creative LLC
Description: Plugin to enable and easy Video Embedding 
Shortcode example: [como-video id='' class='' controls='true/false' preload='' width='' height='' data-setup='' webm='full path' ogv='full path' mp4='full path' embed='embed code' poster='full path' title='' text='' placeholder='full path' aspect='wide/full' autoplay='true/false' modal='true/false' modalid=ID modal-title='' modal-link-text='' modal-link-class='' has-preview=true/false preview-webm='' preview-ogv='' preview-mp4='' template='' custom-controls=true/false custom-control-skin=control-trmplate-name]
Custom templates can be created in your theme in a folder named "como-video" 
*/
defined('ABSPATH') or die('No Hackers!');
// Include plugin updater.
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/updater.php' );
class Como_Video_Shortcode {
	static $add_script;
	static $add_style;
	static function init() {
		add_shortcode('como-video', array(__CLASS__, 'handle_shortcode'));
		add_action('init', array(__CLASS__, 'register_script'));
		add_action('wp_footer', array(__CLASS__, 'print_script'));
	}
	
	static function handle_shortcode($atts) {
		self::$add_style = true;
		self::$add_script = true;
		
		$output = '';
		
		$video['id'] = (isset($atts['id']) ? esc_html($atts['id']) : '');
		$video['class'] = (isset($atts['class']) ? esc_html($atts['class']) : '');
		$video['preload'] = (isset($atts['preload']) ? $atts['preload'] : '');
		$video['width'] = (isset($atts['width']) ? esc_html($atts['width']) : '');
		$video['height'] = (isset($atts['height']) ? esc_html($atts['height']) : '');
		$video['data-setup'] = (isset($atts['data-setup']) ? esc_html($atts['data-setup']) : '');
		$video['formats']['webm'] = (isset($atts['webm']) ? esc_url($atts['webm']) : '');
		$video['formats']['ogv'] = (isset($atts['ogv']) ? esc_url($atts['ogv']) : '');
		$video['formats']['mp4'] = (isset($atts['mp4']) ? esc_url($atts['mp4']) : '');
		$video['formats']['embed'] = (isset($atts['embed']) ? $atts['embed'] : '');
		$video['poster'] = (isset($atts['poster']) ? esc_url($atts['poster']) : '');
		$video['title'] = (isset($atts['title']) ? esc_attr($atts['title']) : ''); 
		$video['text'] = (isset($atts['text']) ? $atts['text'] : '');
		$video['placeholder'] = (isset($atts['placeholder']) ? esc_url($atts['placeholder']) : '');
		$video['aspect'] = (isset($atts['aspect']) ? esc_html($atts['aspect']) : 'wide');
		$video['autoplay'] = (isset($atts['autoplay']) ? esc_html($atts['autoplay']) : false);
		$video['controls'] = (isset($atts['controls']) ? esc_html($atts['controls']) : false);
		$video['playsinline'] = (isset($atts['playsinline']) ? esc_html($atts['playsinline']) : false);
		$video['loop'] = (isset($atts['loop']) ? esc_html($atts['loop']) : false);
		$video['muted'] = (isset($atts['muted']) ? esc_html($atts['muted']) : false);
		$video['has-preview'] = (isset($atts['has-preview']) ? esc_html($atts['has-preview']) : false);
		$video['preview']['webm'] = (isset($atts['preview-webm']) ? esc_url($atts['preview-webm']) : '');
		$video['preview']['ogv'] = (isset($atts['preview-ogv']) ? esc_url($atts['preview-ogv']) : '');
		$video['preview']['mp4'] = (isset($atts['preview-mp4']) ? esc_url($atts['preview-mp4']) : '');
		$video['custom-controls'] = (isset($atts['custom-controls']) ? esc_html($atts['custom-controls']) : false);
		$video['custom-control-skin'] = (isset($atts['custom-control-skin']) ? esc_html($atts['custom-control-skin']) : false);
		$video['modal'] = (isset($atts['modal']) ? esc_html($atts['modal']) : false);
		$video['modalid'] = (isset($atts['modalid']) ? esc_html($atts['modalid']) : '');
		$video['modal-title'] = (isset($atts['modal-title']) ? esc_attr($atts['modal-title']) : '');
		$video['modal-link-text'] = (isset($atts['modal-link-text']) ? $atts['modal-link-text'] : '');
		$video['modal-link-class'] = (isset($atts['modal-link-class']) ? esc_html($atts['modal-link-class']) : '');
		$video['hover-preview'] = (isset($atts['hover-preview']) ? esc_html($atts['hover-preview']) : false);
		$video['hover-preview-start'] = (isset($atts['hover-preview-start']) ? esc_html($atts['hover-preview-start']) : '');
		$video['hover-preview-speed'] = (isset($atts['hover-preview-speed']) ? esc_html($atts['hover-preview-speed']) : '');
		$video['template'] = (isset($atts['template']) ? esc_html($atts['template']) : '');
		
		$hasPreview = (($video['has-preview'] === 'true') ? true : false );
		$isEmbed = ((!empty($video['formats']['embed'])) ? true : false );
		//print_r($video);
		
		$videoSource = '';
		if ($isEmbed) {
			$videoSource = $video['formats']['embed'];
		} else {
			foreach ($video['formats'] as $k=>$v) {
				switch ($k) {
					case 'webm':
						$videoSource .= '<source src="'. $v .'" type="video/webm; codecs=vp8,vorbis" />';
						break;
					case 'ogv':
						$videoSource .= '<source src="'. $v .'" type="video/ogg; codecs=theora,vorbis" />';
						break;
					case 'mp4':
						$videoSource .= '<source src="'. $v .'" type="video/mp4; codecs=avc1.42E01E,mp4a.40.2" />';
						break;
				}
			}
		}
		$previewSource = '';
		if ($hasPreview) {
			foreach ($video['preview'] as $k=>$v) {
				switch ($k) {
					case 'webm':
						$previewSource .= '<source src="'. $v .'" type="video/webm; codecs=vp8,vorbis" />';
						break;
					case 'ogv':
						$previewSource .= '<source src="'. $v .'" type="video/ogg; codecs=theora,vorbis" />';
						break;
					case 'mp4':
						$previewSource .= '<source src="'. $v .'" type="video/mp4; codecs=avc1.42E01E,mp4a.40.2" />';
						break;
				}
			}
		}
		if (!empty($videoSource)) {
			$templateVersion = '';
			$templateVersion .= (($video['custom-controls'] === 'true') ? '-custom' : ''); // Check for custom controls
			$templateVersion .= (($isEmbed) ? '-embed' : ''); // Check for embed
			$templateVersion .= (($video['modal'] === 'true') ? '-modal' : ''); // Check for modal
			$templateVersion .= (($hasPreview) ? '-preview' : ''); // Check for preview
			if ($video['template']) {
				$temp = (is_child_theme() ? get_stylesheet_directory() : get_template_directory() ) . '/como-video/'. $video['template'] . $templateVersion .'.php';
				if (file_exists($temp)) {
					include($temp);
				} else {
					include(plugin_dir_path( __FILE__ ) .'templates/default'. $templateVersion .'.php');
				}
			} else {
				include(plugin_dir_path( __FILE__ ) .'templates/default'. $templateVersion .'.php');
			}
		} 
		if ($output) { return $output; }
	}
	
	// Register & Print Scripts
	static function register_script() {
		wp_register_style('como_video_stylesheet', plugins_url('css/como-video.min.css', __FILE__), '', '1.0', 'all');
		wp_register_script('como_video_script', plugins_url('js/como-video.min.js', __FILE__), array('jquery'), '1.0', true);
	}
	
	static function print_script() {
		
		if ( ! self::$add_style )
			return;
		wp_enqueue_style('como_video_stylesheet');
		
		if ( ! self::$add_script )
			return;
		wp_print_scripts('como_video_script');
	}
}
Como_Video_Shortcode::init();
/********* TinyMCE Button Add-On ***********/
add_action( 'after_setup_theme', 'comovideo_button_setup' );
if (!function_exists('comovideo_button_setup')) {
    function comovideo_button_setup() {
        add_action( 'init', 'comovideo_button' );
    }
}
if ( ! function_exists( 'comovideo_button' ) ) {
    function comovideo_button() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }
        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }
        add_filter( 'mce_external_plugins', 'comovideo_add_buttons' );
        add_filter( 'mce_buttons', 'comovideo_register_buttons' );
    }
}
if ( ! function_exists( 'comovideo_add_buttons' ) ) {
    function comovideo_add_buttons( $plugin_array ) {
        $plugin_array['comoVideoButton'] = plugin_dir_url( __FILE__ ) .'js/tinymce_button.js';
        return $plugin_array;
    }
}
if ( ! function_exists( 'comovideo_register_buttons' ) ) {
    function comovideo_register_buttons( $buttons ) {
        array_push( $buttons, 'comoVideoButton' );
        return $buttons;
    }
}
add_action ( 'after_wp_tiny_mce', 'comovideo_tinymce_extra_vars' );
if ( !function_exists( 'comovideo_tinymce_extra_vars' ) ) {
	function comovideo_tinymce_extra_vars() { 
		// Get Templates
		$videoTemplates[] = array('value'=>'default','text'=>'Default');
		$templateDir = (is_child_theme() ? get_stylesheet_directory() : get_template_directory() ) . '/como-video/';
		if (($templateDir !== false) && is_dir($templateDir)) {
			if ($handle = opendir($templateDir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$videoTemplates[] = array('value'=>basename($entry, '.php'),'text'=>basename($entry, '.php'));
					}
				}
				closedir($handle);
			}
		}
		$videoTemplates = json_encode($videoTemplates);
		?>
		<script type="text/javascript">
			var tinyMCE_video = <?php echo json_encode(
				array(
					'button_name' => esc_html__('Embed Video', 'comovideo'),
					'button_title' => esc_html__('Embed Video', 'comovideo'),
					'video_template_select_options' => $videoTemplates
				)
			);
			?>;
		</script><?php
	} 	
}