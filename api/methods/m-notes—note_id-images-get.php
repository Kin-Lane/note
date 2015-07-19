<?php
$route = '/notes/:note_id/images/';
$app->get($route, function ($note_id)  use ($app){

	$ReturnObject = array();

	$Query = "SELECT * FROM note_image ls";
	$Query .= " WHERE ls.note_id = " . $note_id;

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$note_image_id = $Database['note_image_id'];
		$path = $Database['image_url'];
		$name = $Database['image_name'];
		$type = $Database['type'];
		$width = $Database['width'];

		$F = array();
		$F['note_image_id'] = $note_image_id;
		$F['name'] = $name;
		$F['path'] = $path;
		$F['type'] = $type;
		$F['width'] = $width;

		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});	
?>
