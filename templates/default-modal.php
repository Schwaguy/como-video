<?php // Default Video Template>
$modalID = (($video['modalid']) ? $video['modalid'] : 'modal-'. rand(10,10000));
$output .= '<a href="#'. $modalID .'" class="modal-link '. (($video['modal-link-class']) ? $video['modal-link-class'] : '') .'" data-toggle="modal" data-target="#'. $modalID .'" data-bs-toggle="modal" data-bs-target="#'. $modalID .'">'. (($video['modal-link-text']) ? $video['modal-link-text'] : 'View Video') .'</a>';
$modal = '<div class="modal fade video-modal" tabindex="-1" role="dialog" id="'. $modalID .'">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">'. (($video['modal-title']) ? $video['modal-title'] : '') .'</h5>
					<button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="video-wrapper">
						<div class="video-content embed-responsive '. (($video['aspect'] == 'full') ? 'embed-responsive-4by3' : 'embed-responsive-16by9') .'">
							<video id="'. $video['id'] .'" class="video-js embed-responsive-item '. (($video['aspect'] == 'full') ? 'vjs-4-3' : 'vjs-16-9') .' '. $video['class'] .' '. (($video['hover-preview'] == 'true') ? 'hover-preview' : '') .'" '. ($video['controls'] ? 'controls' : '') .' preload="'. ($video['preload'] ? $video['preload'] : 'auto') .'" width="'. ($video['width'] ? $video['width'] : '640') .'" height="'. ($video['height'] ? $video['height'] : '264') .'" poster="'. ($video['poster'] ? $video['poster'] : '') .'"  '. (($video['autoplay'] === 'true') ? 'autoplay="autoplay"' : '') .' '. ($video['playsinline'] ? 'playsinline="playsinline"' : '') .' '. ($video['loop'] ? 'loop="loop"' : '') .' '. ($video['muted'] ? 'muted="muted"' : '') .'>
								'. $videoSource .'
								<p class="vjs-no-js">
								  To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
								</p>
							  </video>
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