<?php
include 'Calendar.php';
$calendar = new Calendar('2024-10-12');
$calendar->add_event('Birthday', '2024-10-03', 1, 'green');
$calendar->add_event('Doctors', '2024-10-04', 1, 'red');
$calendar->add_event('Holiday', '2024-10-16', 3);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Event Calendar</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link href="calendar.css" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	</head>
	<body>
	    <nav class="navtop">
	    	<div>
	    		<h1>Event Calendar</h1>
	    	</div>
	    </nav>
        <div class="col">
            <div class="col-4">
            <label for="">Event name</label>
            <input type="text" class="">
            </div>
            <div class="col-4">
            <label for="" class="m3">Event type</label>
            <input type="text" class="p5">
            </div>
            <div class="col-4">
            <label for="">Event title</label>
            <input type="text" class="p5">
            </div>
        </div>
		<div class="content home">
			<?=$calendar?>
		</div>
	</body>
</html>