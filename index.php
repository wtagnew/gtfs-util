<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="keywords"
	content="GTFS, Google Transit Feed Specification, GTFS Editor, GTFS GUI, MyMetro, computer science, Oxford, Oxford Ohio, Oxford OH, Miami University, Ohio">
<title>Easy GTFS Editor</title>
<script src="gtfs.js"></script>
<link rel="stylesheet" href="FullDesignArial.css" type="text/css">
<?php require "gtfs.php";?>
</head>
<body onload="init();">
	<div class="title" align="center">
		<h2>Easy GTFS Editor</h2>
		MyMetro Bus System, Miami University
	</div>

	<div id="sidebar" class="sidebar">
		<font size="+1"><strong>Action: </strong> </font> <a
			href="javascript:home();">Home | &nbsp;</a> <a
			href="javascript:importGTFS();">Import GTFS | &nbsp;</a> <a
			href="./gtfs.zip">Download GTFS | &nbsp;</a> <a
			href="javascript:help();">Help</a>
	</div>

	<div id="import" class="sidebarFooter">
		<form action="javascript:upload();" method="post"
			enctype="multipart/form-data">
			<label for="file">Filename:</label> <input type="file" name="file"
				id="file"><br> <input type="submit" name="submit" value="Submit">
		</form>
	</div>

	<div id="content">
		<div id="menuGTFS">
			<a href="">Agency</a>&nbsp; <a href="">Route</a>&nbsp; <a href="">Calendar</a>&nbsp;
			<a href="">Fares</a>&nbsp;
			<br><br>
			
		</div>
		<div id="agency">
			<?php agency();?>
		</div>
		<div id="help">
			<img src="./img/GTFS_Schema.png" width="1400px">
		</div>
	</div>

	<!-- <div id="footer" class="footer">
    MyMetro Senior Capstone
    <div id="legal" class="legal">
      &copy; 2013 Miami University
    </div>
  </div> -->

</body>
</html>
