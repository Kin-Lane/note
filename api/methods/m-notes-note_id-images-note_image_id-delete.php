<?php
$route = '/notes/:note_id/images/:note_image_id';
$app->delete($route, function ($note_id,$note_image_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$note_id = prepareIdIn($note_id,$host);
	$note_image_id = prepareIdIn($note_image_id,$host);

	$ReturnObject = array();

 	$request = $app->request();
 	$param = $request->params();

	$DeleteQuery = "DELETE FROM note_image WHERE note_image_id = " . $note_image_id;
	$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());

	$note_image_id = prepareIdOut($note_image_id,$host);

	$F = array();
	$F['note_image_id'] = $note_image_id;

	array_push($ReturnObject, $F);

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));

	});
?>
