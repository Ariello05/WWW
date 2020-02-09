
/*function highlight(item, index)
{
	item.onmouseover = function(event){
		this.style.backgroundImage = "linear-gradient(#FF4444,#343431)";
	}
}*/

var panels = document.getElementsByClassName('panel')

for (i=0;i<panels.length; ++i) {
	panels[i].onmouseover = function(event){
		this.style.backgroundImage = "linear-gradient(#444449,#343439)";
	}
	panels[i].onmouseout = function(event){
		this.style.backgroundImage = "linear-gradient(#343431,#333333)";
	}
}





		