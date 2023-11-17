<?php // Default Video Template>
$output = '<div class="video-wrapper">
	<div class="video-content embed-responsive '. (($video['aspect'] == 'full') ? 'embed-responsive-4by3' : 'embed-responsive-16by9') .'">
		<video id="'. $video['id'] .'" class="video-js embed-responsive-item '. (($video['aspect'] == 'full') ? 'vjs-4-3' : 'vjs-16-9') .' '. $video['class'] .' '. (($video['hover-preview'] == 'true') ? 'hover-preview' : '') .'" '. (($video['hover-preview-start']) ? 'data-preview-start="'. $video['hover-preview-start'] .'"' : '') .' '. (($video['hover-preview-speed']) ? 'data-preview-speed="'. $video['hover-preview-speed'] .'"' : '') .' '. (($video['controls'] !== 'false') ? 'controls' : '') .' preload="'. ($video['preload'] ? $video['preload'] : 'auto') .'" width="'. ($video['width'] ? $video['width'] : '640') .'" height="'. ($video['height'] ? $video['height'] : '264') .'" poster="'. ($video['poster'] ? $video['poster'] : '') .'"  '. (($video['autoplay'] === 'true') ? 'autoplay="autoplay"' : '') .' '. ($video['playsinline'] ? 'playsinline="playsinline"' : '') .' '. ($video['loop'] ? 'loop="loop"' : '') .' '. ($video['muted'] ? 'muted="muted"' : '') .'>
			'. $videoSource .'
			<p class="vjs-no-js">
			  To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
			</p>
		  </video>
	</div>
</div>';