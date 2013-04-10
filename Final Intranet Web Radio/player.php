<script type="text/javascript" src="jwplayer/jwplayer.js"></script>
<script type="text/javascript">
jwplayer("myElement").setup({
	file: "http://10.4.2.27:8000/mpd.mp3",
//		image: "jwplayer/12.gif",
		//                     plugins: {'revolt-1': {} },

		events: {
			onPause: function() {
				jwplayer().stop();
			}
		}
	controls:"false",
	autoplay:"true";
});
</script>


<div style="position: absolute; z-index: 1; visibility: show;" id="myElement"> </div>

