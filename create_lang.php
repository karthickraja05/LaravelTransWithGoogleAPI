<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Success</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
	<?php

	include('LangCreator.php');
	include('Config.php');


	$data = $_POST['lang'];

	if(count($data)){
		foreach ($data as  $value) {
			$obj = new LangCreator('en',$value);
			$obj->creator();
		}
	}

	?>
	<h1>Created Successfully</h1>
	<p>
		<a href="index.php"><button class="btn btn-primary">Main Page</button></a>
		<a href="final_result"><button class="btn btn-primary">Output Folder</button></a>
	</p>
	
	</div>
</body>
</html>