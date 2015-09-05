<?php
$route = '/notes/:note_id/';
$app->delete($route, function ($note_id) use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$note_id = prepareIdIn($note_id,$host);
	
	$ReturnObject = array();

	$query = "DELETE FROM notes WHERE note_id = " . $note_id;
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());

	$ReturnObject = array();
	$ReturnObject['message'] = "Note Deleted!";
	$ReturnObject['note_id'] = $note_id;

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_enode($ReturnObject)));

	});
?>
