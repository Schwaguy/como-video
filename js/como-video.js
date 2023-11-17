jQuery.noConflict(); 
(function($) { 
    "use strict"; 
	
	// Stop video PLayback on modal close
	$('body').on('hidden.bs.modal', '.video-modal', function () { 
		$('.video-modal').find('video').trigger('pause'); 
	});
	
	// Add / Remove "Playing Class" to video wrapper
	$('video').on('play', function () {
		$(this).parents('.video-wrapper').addClass('playing');
	});
	$('video').on('pause ended', function () {
		$(this).parents('.video-wrapper').removeClass('playing');
	});
	
	$('.player').each(function() {
		 var player = $(this).get(0);
		 var video = player.querySelector('.viewer');
		 var toggle = player.querySelector('.toggle');
		 var skipButtons = player.querySelectorAll('[data-skip]');
		 var ranges = player.querySelectorAll('.player__slider');
		 var progress = player.querySelector('.progress-range');
		 var progressBar = player.querySelector('.progress-bar');
		 var currentTime = player.querySelector('.time-elapsed');
		 var duration = player.querySelector('.time-duration');
		 var videoTime = player.querySelector('.videoTime');
		 var loadingIndicator = player.querySelector('.loading_indicator');
		 var playBtn = player.querySelector('.play-btn');
		 var stopBtn = player.querySelector('.stop');
		 var skipButtons = player.querySelectorAll('[data-skip]');
		 var pictureInpicture = player.querySelector('.pictureInPicture');
		 var speakerIcon = player.querySelector('.speaker_icon');
		 var ranges = player.querySelectorAll('.player_slider');
		 var speaker = player.querySelector('.speaker');
		 var volInput = player.querySelector('input[name="volume"]')
		 /* Build out functions */
		 function togglePlay() {
			 const method = video.paused ? 'play' : 'pause';
			 video[method]();
		 }
		 function stopVideo() {
			 video.currentTime = 0;
			 video.pause();
		 }
		 function updateButton() {
			 if (this.paused) {
				 showPlayIcon();
			 } else {
				 showPauseIcon();
			 }
		 }
		 function showPlayIcon() {
			 playBtn.classList.replace('fa-pause', 'fa-play');
			 playBtn.setAttribute('title', 'Play');
		 }
		 function showPauseIcon() {
			 playBtn.classList.replace('fa-play', 'fa-pause');
			 playBtn.setAttribute('title', 'Pause');
		 }
		 function skip() {
			 video.currentTime += parseFloat(this.dataset.skip);
		 }
		 function handleRangeUpdate() {
			 video[this.name] = this.value;
		 }
		 function handleProgress() {
			 const percent = (video.currentTime / video.duration) * 100;
			 progressBar.style.flexBasis = `${percent}%`;
		 }
		 function scrub(e) {
			 const scrubTime = (e.offsetX / progress.offsetWidth) * video.duration;
			 video.currentTime = scrubTime;
		 }
		 //Display loading spinner when video is loading
		 video.addEventListener('waiting', () => {
			 loadingIndicator.style.display = 'block';
		 });
		 video.addEventListener('canplay', () => {
			 loadingIndicator.style.display = 'none';
		 });
		 /* Hook up the event listners */
		 video.addEventListener('click', togglePlay);
		 video.addEventListener('play', updateButton);
		 video.addEventListener('pause', updateButton);
		 video.addEventListener('timeupdate', handleProgress);
		 speaker.addEventListener('click', mute);
		 video.addEventListener('keydown', (event) => event.keyCode === 32 && togglePlay());
		 stopBtn.addEventListener('click', stopVideo);
		 toggle.addEventListener('click', togglePlay);
		 skipButtons.forEach(button => button.addEventListener('click', skip));
		 ranges.forEach(range => range.addEventListener('change', handleRangeUpdate));
		 ranges.forEach(range => range.addEventListener('mousemove', handleRangeUpdate));
		 let mousedown = false;
		 progress.addEventListener('click', scrub);
		 progress.addEventListener('mousemove', (e) => mousedown && scrub(e));
		 progress.addEventListener('mousedown', () => mousedown = true);
		 progress.addEventListener('mouseup', () => mousedown = false);
		 let muted = false;
		 function mute() {
			if (!muted) {
				video['volume'] = 0;
				volInput.value = 0;
				speakerIcon.className = "fa fa-volume-off"
				muted = true;
			} else {
				video['volume'] = 1;
				volInput.value = 1;
				muted = false;
				speakerIcon.className = "fa fa-volume-up"
			}
		 }
		 video.addEventListener('timeupdate', updateProgress);
		 video.addEventListener('canplay', updateProgress);
		 progress.addEventListener('click', setProgress);
		 function updateProgress() {
			 progressBar.style.width = `${(video.currentTime / video.duration) * 100}%`;
			 currentTime.textContent = `${displayTime(video.currentTime)} /`;
			 duration.textContent = `${displayTime(video.duration)}`;
		 }
		 function displayTime(time) {
			 var minutes = Math.floor(time / 60);
			 let seconds = Math.floor(time % 60);
			 seconds = seconds > 9 ? seconds : `0${seconds}`;
			 return `${minutes}:${seconds}`;
		 }
		 function setProgress(e) {
			 const newTime = e.offsetX / progress.offsetWidth;
			 progressBar.style.width = `${newTime * 100}%`;
			 video.currentTime = newTime * video.duration;
		 }
		 // progress bar controls
		 let mouseDown = false;
		 progress.addEventListener('click', scrub);
		 progress.addEventListener('mousemove', (event) => mouseDown && scrub(event));
		 progress.addEventListener('mousedown', () => mouseDown = true);
		 progress.addEventListener('mouseup', () => mouseDown = false);
		 progress.addEventListener('mousemove', (e) => {
			 let progressWidthvalue = progress.clientWidth + 2;
			 let x = e.offsetX;
			 let videoDuration = video.duration;
			 let progressTime = Math.floor((x / progressWidthvalue) * videoDuration);
			 let currentVideoMinute = Math.floor(progressTime / 60);
			 let currentVideoSeconds = Math.floor(progressTime % 60);
			 videoTime.style.setProperty("--x", `${x}px`);
			 videoTime.style.display = "block";
			 if (x >= progressWidthvalue - 80) {
				 x = progressWidthvalue - 80;
			 } else if (x <= 75) {
				 x = 75;
			 } else {
				 x = e.offsetX;
			 }
			 // if the seconds are less then 10 then add 0 at the beginning
			 currentVideoSeconds < 10
				 ? (currentVideoSeconds = "0" + currentVideoSeconds)
				: currentVideoSeconds;
			 videoTime.innerHTML = `${currentVideoMinute} : ${currentVideoSeconds}`;
		 });
		 progress.addEventListener('mouseleave', (e) => {
			 videoTime.style.display = "none";
		 });
		 // Spacebar used to play and pause
		 document.body.onkeyup = function (e) {
			 if (e.keyCode == 32) {
				 togglePlay();
			 }
		 }
		 //fullscreen mode 
		 var screen_size = player.querySelector('.screenSize');
		 var controls = player.querySelector('.player_controls');
		 var screenSize_icon = player.querySelector('.screenSize_icon');
		 function changeScreenSize() {
			if (player.mozRequestFullScreen) {
				player.mozRequestFullScreen();
				//change icon
				screenSize_icon.className = "fa fa-compress";
				// control panel once fullscreen
				video.addEventListener('mouseout', () => controls.style.transform = 'translateY(100%) translateX(-5px)');
				video.addEventListener('mouseover', () => controls.style.transform = 'translateY(0)');
				controls.addEventListener('mouseover', () => controls.style.transform = 'translateY(0)');
				screen_size.addEventListener('click', () => {
					if (document.exitFullscreen) {
						document.exitFullscreen();
					} else if (document.mozCancelFullScreen) {
						document.mozCancelFullScreen();
						screenSize_icon.className = "fa fa-expand";
					}
				});
			} else if (player.webkitRequestFullScreen) {
				player.webkitRequestFullScreen();
				screenSize_icon.className = "fa fa-compress";
				video.addEventListener('mouseout', () => controls.style.transform = 'translateY(100%) translateX(-5px)');
				video.addEventListener('mouseover', () => controls.style.transform = 'translateY(0)');
				controls.addEventListener('mouseover', () => controls.style.transform = 'translateY(0)');
				screen_size.addEventListener('click', () => {
					if (document.exitFullscreen) {
						document.exitFullscreen();
					} else if (document.webkitExitFullscreen) {
						document.webkitExitFullscreen();
						screenSize_icon.className = "fa fa-expand";
					}
				});
			}
		}
		screen_size.addEventListener('click', changeScreenSize);
		// Picture in picture mode
		pictureInpicture.addEventListener('click', () => {
			video.requestPictureInPicture();
		});
	});
})(jQuery);
/*
document.querySelectorAll('.hover-preview').forEach(function(vid) {
	vid.onmouseover = function() {
		var previewSpeed = this.getAttribute('data-preview-speed');
		previewSpeed = ((previewSpeed !== null) ? previewSpeed : 0.5);
		var previewStart = this.getAttribute('data-preview-start');
		previewStart = ((previewStart !== null) ? previewStart : 1);
		this.muted = true;
		this.currentTime = previewStart;
		this.playbackRate = previewSpeed;
		this.play();
	}
	vid.onmouseout = function() {
		this.load(); // stop and show poster
	}
});
*/