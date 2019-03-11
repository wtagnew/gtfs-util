
function init()
{
	home();
}

function home()
{
	reset();
	document.getElementById("content").style.visibility = "visible";
}

function reset()
{
	document.getElementById("content").style.visibility = "hidden";
	document.getElementById("import").style.visibility = "hidden";
	document.getElementById("help").style.visibility = "hidden";
}

function help()
{
	reset();
	document.getElementById("help").style.visibility = "visible";
}

function importGTFS()
{
	reset();
	document.getElementById("import").style.visibility = "visible";
}

function upload()
{
	alert("GTFS Uploaded.");
}