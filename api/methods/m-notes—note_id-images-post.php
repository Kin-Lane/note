<?php
$route = '/notes/:note_id/images/';
$app->post($route, function ($note_id)  use ($app){

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();
	if(isset($param['type']) && isset($param['path']) && isset($param['name']))
		{
		$type = trim(mysql_real_escape_string($param['type']));
		$path = trim(mysql_real_escape_string($param['path']));
		$name = trim(mysql_real_escape_string($param['name']));

		$query = "INSERT INTO note_image(note_id,type,image_name,image_url)";
		$query .= " VALUES(" . $note_id . ",'" . $type . "','" . $name . "','" . $path . "')";
		//echo $query;
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$image_id = mysql_insert_id();

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
