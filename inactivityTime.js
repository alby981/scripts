 function inactivityTime() {
    var t;
    window.onload = resetTimer;
    window.onmousemove = resetTimer; // catches mouse movements
    window.onmousedown = resetTimer; // catches mouse movements
    window.onclick = resetTimer;     // catches mouse clicks
    window.onscroll = resetTimer;    // catches scrolling
    window.onkeypress = resetTimer;  //catches keyboard actions
    window.touchmove = resetTimer;  //catches keyboard actions
    window.touchend = resetTimer;  //catches keyboard actions
    var xhttp = new XMLHttpRequest();
    var page = '';
    xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			page = this.responseText;
		}
	};
	xhttp.open("GET", "getPage.php", true);
	xhttp.send();
	var rand = Math.floor(Math.random() * 24123) + 45121;
	console.log(rand);
	console.log(page);
    function logout() {
        window.location.href = page;  //Adapt to actual logout script
    }
	function resetTimer() {
        clearTimeout(t);
        t = setTimeout(logout, rand);  // time is in milliseconds (1000 is 1 second)
    }
}
inactivityTime();
