<?php // Default Video Template>
$output = '<div class="video-wrapper">
	<div class="video-content embed-responsive '. (($video['aspect'] == 'full') ? 'embed-responsive-4by3' : 'embed-responsive-16by9') .'">'. $videoSource .'</div>
</div>';