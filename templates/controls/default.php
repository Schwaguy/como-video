<?php
$playerControls = '<div class="loading_indicator"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>
<div class="videoTime">0:00</div>
<div class="player_controls">
	 <div class="progress-range" title="Jump-to">
		 <div class="progress-bar"></div>
	 </div>
	 <div class="left-controls">
		 <button class="player_button toggle" title="Toggle Play"><i class="play-btn fa fa-play" title="Play"></i></button>
		 <button class="player_button stop" title="Start over"><i class="stop-btn fa fa-stop" title="Play"></i></button>
		 <button class="player_button speaker"><i class="speaker_icon fa fa-volume-up" aria-hidden="true"></i></button>
		 <input type="range" name="volume" class="player_slider" min="0" max="1" step="0.05" value="1"></input>
	</div>
	<div class="right-controls">
		<!--<button class="player_button rate_icon"><i class="fa fa-spinner" aria-hidden="true"></i></button>
		<input type="range" name="playbackRate" class="player_slider" min="0.5" max="2" step="0.1" value="1"></input>-->
		<button data-skip="-10" class="player_button"><i class="fa fa-fast-backward" aria-hidden="true"></i></button>
		<button data-skip="10" class="player_button"><i class="fa fa-fast-forward" aria-hidden="true"></i></button>
		<div class="time">
			<span class="time-elapsed">00:00 / </span>
			<span class="time-duration">00:00</span>
		</div>
		<button class="player_button pictureInPicture"><i class="fa fa-external-link pip_icon" aria-hidden="true"></i></button>
		<button class="player_button screenSize"><i class="fa fa-expand screenSize_icon" aria-hidden="true"></i></button>
	</div>
</div>';