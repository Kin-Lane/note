<?php
$route = '/notes/:note_id/images/:note_image_id';
$app->put($route, function ($note_id,$note_image_id)  use ($app){

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['path']))
		{
		$type = trim(mysql_real_escape_string($param['type']));
		$path = trim(mysql_real_escape_string($param['path']));
		$name = trim(mysql_real_escape_string($param['name']));

		$query = "UPDATE note_image SET type = '" . $type . "', image_url = '" . $path . "', image_name = '" . $name . "' WHERE note_image_id = " . $note_image_id;
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$image_ID = mysql_insert_id();

		$F = array();
		$F['image_id'] = $image_id;
		$F['name'] = $name;
		$F['path'] = $path;
		$F['type'] = $type;

		array_push($ReturnObject, $F);

		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>
