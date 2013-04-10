var NUMBER_OF_STARS = 10;
var status;

function submitRating(evt) {
	var tmp = Event.element(evt).getAttribute('id').substr(5);
	var widgetId = tmp.substr(0, tmp.indexOf('_'));
	var starNbr = tmp.substr(tmp.indexOf('_')+1);
	new Ajax.Request('response-star-rating.php', {
		  method: 'get',
		  evalJs: true,
		  parameters: {ratingId: widgetId, value: starNbr},
		  onSuccess: function(transport) { 
			$("starRatingFeedback_"+widgetId).setStyle({visibility: 'visible'});
			new Effect.Opacity(
			   "starRatingFeedback_"+widgetId, { 
				  from: 0.0, 
				  to: 1.0,
				  duration: 1.0
			   }
			);
		  	$("starRatingFeedback_"+widgetId).update(transport.responseText);
			
		  }
    });
}

function init_rating() {
		
    var ratings = $$('div');
	
	
// doesn't work: ratings.cleanWhitespace();
	ratings.each(function(i) {
		
		if (i.className	!= 'rating') return
		
		// innerHTML was a convenience property introduced by Microsoft as a means of reading and writing the HTML content of an element
		// a) innerHTML is at least 200% slower on all 6 browsers tested (Firefox, Netscape 6+, Internet Explorer 6+, Opera 7+, Safari 2, Seamonkey 1) than modifying the nodeValue and
		// b) innerHTML is NOT a World Wide Web Consortium web standard DOM 1 attribute.
		var rating = i.firstChild.nodeValue;

		i.removeChild(i.firstChild);
//		i.remove DOESN'T wORK ???!!!
		
		if (rating > NUMBER_OF_STARS || rating < 0) return
		$R(1,NUMBER_OF_STARS).each(function(j) {
			var star = new Element('img');

			if (rating >= 1) {
                star.setAttribute('src', 'images/stars/rating_on.gif');
                star.className = 'on';
                rating--;
	        } else if(rating == 0.5) {
                star.setAttribute('src', 'images/stars/rating_half.gif');
                star.className = 'half';
                rating = 0;
			} else {
				star.className = 'off';
				star.setAttribute('src', 'images/stars/rating_off.gif');
            }
            var widgetId = i.identify().substr(7);
            star.writeAttribute('id', 'star_'+widgetId+'_'+j);
            star.onmouseover = new Function("evt", "displayHover("+widgetId+", "+j+");");
            star.onmouseout = new Function("evt", "displayNormal("+widgetId+", "+j+");");	
			i.appendChild(star);
		});

    });
	
    $$('.rating').each(function(n){
		n.immediateDescendants().each(function(c){
			Event.observe(c, 'click', submitRating);
		});
	});
}


function displayHover(ratingId, star) {
	$R(1,star).each(function(i) {
		$('star_'+ratingId+'_'+i).setAttribute('src', 'images/stars/rating_over.gif');
	});
}


function displayNormal(ratingId, star) {
	$R(1,star).each(function(i) {	
		status = $('star_'+ratingId+'_'+i).className;
		$('star_'+ratingId+'_'+i).setAttribute('src', 'images/stars/rating_'+status+'.gif');
	});
}
