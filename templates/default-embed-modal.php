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
							'. $videoSource .'
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