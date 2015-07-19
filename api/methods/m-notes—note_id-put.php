<?php
$route = '/notes/:note_id/';
$app->put($route, function ($note_id) use ($app){

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['title'])){ $title = $param['title']; } else { $title = 'No Title'; }
	if(isset($param['details'])){ $details = $param['details']; } else { $details = ''; }

  	$LinkQuery = "SELECT * FROM notes WHERE note_id = " . $note_id;
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{
		$query = "UPDATE notes SET ";

		if(isset($title))
			{
			$query .= "title='" . mysql_real_escape_string($title) . "'";
			}
		if(isset($note))
			{
			$query .= ",note='" . mysql_real_escape_string($note) . "'";
			}

		$query .= " WHERE note_id = " . $note_id;

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());

		$ReturnObject = array();
		$ReturnObject['message'] = "Note Updated!";
		$ReturnObject['note_id'] = $note_id;

		}
	else
		{
		$Link = mysql_fetch_assoc($LinkResult);

		$ReturnObject = array();
		$ReturnObject['message'] = "notes Doesn't Exist!";
		$ReturnObject['note_id'] = $note_id;

		}

	$app->response()->header("Content-Type", "application/json");
	echo format_json(json_encode($ReturnObject));

	});
?>
