<?php // Default Video Template>
$modalID = (($video['modalid']) ? $video['modalid'] : 'modal-'. rand(10,10000));
$controlSkin = ((!empty($video['custom-control-skin'])) ? $video['custom-control-skin'] : 'default');
$controlSkinFile = (is_child_theme() ? get_stylesheet_directory() : get_template_directory() ) . '/como-video/controls/'. $controlSkin .'.php';
if (file_exists($controlSkinFile)) {
	include($controlSkinFile);
} else {
	include(plugin_dir_path( __FILE__ ) .'controls/'. $controlSkin .'.php');
}
$output .= '<a href="#'. $modalID .'" class="modal-link '. (($video['modal-link-class']) ? $video['modal-link-class'] : '') .'" data-toggle="modal" data-target="#'. $modalID .'" data-bs-toggle="modal" data-bs-target="#'. $modalID .'">'. (($video['modal-link-text']) ? $video['modal-link-text'] : 'View Video') .'</a>';
$modal = '<div class="modal fade video-modal" tabindex="-1" role="dialog" id="'. $modalID .'">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">'. (($video['modal-title']) ? $video['modal-title'] : '') .'</h5>
					<button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="video-wrapper '. $controlSkin .'">
						<div class="video-content embed-responsive player '. (($video['aspect'] == 'full') ? 'embed-responsive-4by3' : 'embed-responsive-16by9') .'">
							<video id="'. $video['id'] .'" class="video-js embed-responsive-item viewer '. (($video['aspect'] == 'full') ? 'vjs-4-3' : 'vjs-16-9') .' '. $video['class'] .'" preload="'. ($video['preload'] ? $video['preload'] : 'auto') .'" width="'. ($video['width'] ? $video['width'] : '640') .'" height="'. ($video['height'] ? $video['height'] : '264') .'" poster="'. ($video['poster'] ? $video['poster'] : '') .'"  '. (($video['autoplay'] === 'true') ? 'autoplay="autoplay"' : '') .' '. ($video['playsinline'] ? 'playsinline="playsinline"' : '') .' '. ($video['loop'] ? 'loop="loop"' : '') .' '. ($video['muted'] ? 'muted="muted"' : '') .'>
								'. $videoSource .'
								<p class="vjs-no-js">
								  To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
								</p>
							  </video>
							  '. $playerControls .'
						</div>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>'; 
if (!isset($GLOBALS['page-modals'])) { $GLOBALS['page-modals'] = ''; }
$GLOBALS['page-modals'] .= $modal;