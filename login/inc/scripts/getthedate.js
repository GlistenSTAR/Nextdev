function gettheDate(){
Todays = new Date();
TheDate = "" + Todays.getDate() + " / " + (Todays.getMonth() + 1) + " / " +
Todays.getYear()
document.clock.date.value = TheDate;
}
var timerID = null;
var timerRunning = false;
function stopclock (){
	if(timerRunning)
	clearTimeout(timerID);
	timerRunning = false;
}

function startclock2 () {
	stopclock();
	gettheDate()
	showtime();
}
function showtime () {
	var now = new Date();
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var seconds = now.getSeconds()
	var timeValue = "" + ((hours >12) ? hours -12 :hours)
	timeValue += ((minutes < 10) ? ":0" : ":") + minutes
	timeValue += ((seconds < 10) ? ":0" : ":") + seconds
	timeValue += (hours >= 12) ? " P.M." : " A.M."
	document.clock.face.value = timeValue;
	timerID = setTimeout("showtime()",1000);
	timerRunning = true;
}
document.write ('<form name="clock" onSubmit="0">')
document.write ('<input type="text" name="date" size="12" value>')
document.write ('<input type="text" name="face" size="12" value></form>')
startclock2();


