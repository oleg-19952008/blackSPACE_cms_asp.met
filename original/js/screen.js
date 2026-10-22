function send_screen(url) {
/*
not setup headers !
*/
var xhtr = new XMLHttpRequest();
xhtr.open("POST", "/" + url);
xhtr.send("");
}
