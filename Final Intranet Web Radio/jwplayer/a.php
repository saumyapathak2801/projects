<head>
<script  src="jwplayer/jwplayer.js"></script>
<script>jwplayer.key="3ylbwl3L71XPIY1AHuOdI99kzT+6nWmuObGasA=="</script>
</head>
<body>
assa</br>

<div id='my-video'></div>
<script type='text/javascript'>
    jwplayer('my-video').setup({
         file: "http://10.4.2.27:8000/mpd.mp3",

		'plugins': {'revolt-1': {}  },
		//'plugins': {'spectrumvisualizer-1': {}  },
		events: {
			onPause: function() {
				jwplayer().stop();
					}
				}
		
    });
</script>
 image: "lol.png",
 
		'plugins': {
       'subeq-1': {
           'soundonly': 'false'
       }
    },
</body>