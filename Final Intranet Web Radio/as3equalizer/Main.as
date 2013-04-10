package {
	import flash.media.*;
	import flash.net.*;
	import flash.display.*;
	import flash.events.*;
	
	import com.everydayflash.equalizer.*;
	import com.everydayflash.equalizer.color.*;
	
	public class Main extends Sprite{
		public function Main() {
			var s:Sound = new Sound(new URLRequest("track.mp3"));
			s.play(0, 100, new SoundTransform(1, 0));
			
			var es:EqualizerSettings = new EqualizerSettings();
			es.numOfBars = 32;
			es.height = 64;
			es.barSize = 2;
			es.vgrid = true;
			es.hgrid = 2;
			es.colorManager = new SolidBarColor(0xffff4444);
			es.effect = EqualizerSettings.FX_REFLECTION;
			
			var e:Equalizer = new Equalizer();
			e.update(es);
			e.x = 100;
			e.y = 100;
			addChild(e);
			
			addEventListener(Event.ENTER_FRAME, e.render);
		}
	}
}