activeThumbnail = null;



$( document ).ready(function() {
	$('.alt-images li:first').addClass('active');
	activeThumbnail = $('.alt-images li:first').attr("id");
});



function swapImage(medImg,largeImg,thisImgID){
	document.getElementById("productImage").src = medImg;
	activeLargeImage = largeImg
	
	if(activeThumbnail != null){
		document.getElementById(activeThumbnail).className = ""
	}
	activeThumbnail = thisImgID
	document.getElementById(activeThumbnail).className = "active"
}

function enlargeImage(){
	doPopup(activeLargeImage,600,600)
}

function doPopup(URL,w,h){
	thisWindow = window.open(URL, "popWin", "toolbar=1, scrollbars=1, location=0, statusbar=0, menubar=0, resizable=1, width=" + w + ", height= " + h);
}


