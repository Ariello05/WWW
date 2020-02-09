var mediumbutton = document.getElementById("button_language_medium");
mediumbutton.style.display="inline-block";
mediumbutton.onclick = function(event){
	var lang = document.getElementById("language_medium")
	if(lang.style.display === "" || lang.style.display === "none"){
		lang.style.display="block";
	}
	else{
		lang.style.display="none";
	}
}

var juniorbutton = document.getElementById("button_language_junior");
juniorbutton.style.display="inline-block";
juniorbutton.onclick = function(event){
	var lang = document.getElementById("language_junior")
	if(lang.style.display === "" || lang.style.display === "none"){
		lang.style.display="block";
	}
	else{
		lang.style.display="none";
	}
}
