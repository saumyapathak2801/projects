<html>
<head>
<script src="sm2/script/soundmanager2.js"></script>
<script>
	soundManager.setup({
  url: 'sm2/swf/',
  useHTML5Audio: true,
  preferFlash: false,
  useHighPerformance: true,
   onready: function() {
    var mySound = soundManager.createSound({
      id: 'raaz.mp3',

      url:  'raaz.mp3',

	   autoPlay: false
    });
    //mySound.play();
  },
  
	debugmode: true
  });
function play(name) {
    var mySound = soundManager.createSound({
      id: 'aSound',
      url: name,
	  autoPlay: false,
	  autoLoad: true
    });
	
  }
  function play22(){
  
 soundManager.setPosition('aSound',25000);
  soundManager.play('aSound');
  }


</script>
<body>
<button onclick="play('4.mp3')">play</button>
<button onclick="play22()">play22</button>
//<audio id="aasound" src="1.mp3" controls></audio>
<div id="sm2-container">see</div>
<div id="graphPixels">see2</div>
<h1>sm2</h1>
</body>
</html>

soundManager.createSound({
      id: list[current+1],
      url: list[current+1],
	  autoPlay: false,
	  autoLoad: true
    });