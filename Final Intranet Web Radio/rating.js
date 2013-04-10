function CRgetRating()	{
	var CRcurrentDate = new Date();
	CRcurrentTimestamp = CRcurrentDate.getTime();
	
	// Fetch the element pointed to by the id. If it exists, we destroy it so we can create a new one.
	oScript = document.getElementById("script_get_rating");
	
	// Point at the script tag, if it exists
	var head = document.getElementsByTagName("head").item(0);
	 // Destroy the tag, if it exists
	if (oScript) {
		// Destory object
		head.removeChild(oScript);
	}   
	// Create the new script tag
	oScript = document.createElement("script");
	
	// Setup the src attribute of the script tag
	oScript.setAttribute("src", "http://www.citricle.com/rateback/get_server.php?company_id=1&company_code=&get=rating&time=" + CRcurrentTimestamp);
	
	// Set the id attribute of the script tag
	oScript.setAttribute("id","script1");
	
	// Create the new script tag which causes the proxy to be called
	head.appendChild(oScript);
}

function CRsetCommentVote(cursorLocation)	{
	document.getElementById("cr_rating").value = cursorLocation;
}

function	CRanimateCommentRating(cursorLocation)	{
	//document.getElementById('cr_comment_stars').innerHTML = '<span style="float: left;">Your rating:&nbsp;</span>';
	for(i=1;i<=5;i++)	{
    	var starId = 'cr_comment_star_' + i;
    	var el = document.getElementById(starId)
		if(i <= cursorLocation)	{
        	el.className = "cr_star_full";
		}
		else	{
			el.className = "cr_star_empty";
		}

	}
}


