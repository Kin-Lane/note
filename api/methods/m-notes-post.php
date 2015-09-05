<?php
$route = '/notes/';
$app->post($route, function () use ($app){

 	$request = $app->request();
 	$param = $request->params();

	if(isset($param['title'])){ $title = $param['title']; } else { $title = 'No Title'; }
	if(isset($param['details'])){ $details = $param['details']; } else { $details = ''; }

	$post_date = date('Y-m-d H:i:s');
	$increment_date = date('m-d-Y');

  	$LinkQuery = "SELECT * FROM notes WHERE title = '" . $title . "'";
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

	if($LinkResult && mysql_num_rows($LinkResult))
		{

		$query = "INSERT INTO notes(";

		if(isset($title)){ $query .= "title,"; }
		if(isset($note)){ $query .= "note,"; }
		if(isset($post_date)){ $query .= "post_date"; }

		$query .= ") VALUES(";

		if(isset($title)){ $query .= "'" . mysql_real_escape_string($title) . " - " . $increment_date . "',"; }
		if(isset($note)){ $query .= "'" . mysql_real_escape_string($note) . "',"; }
		if(isset($post_date)){ $query .= "'" . mysql_real_escape_string($post_date) . "'"; }

		$query .= ")";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$note_id = mysql_insert_id();

    $host = $_SERVER['HTTP_HOST'];
  	$note_id = prepareIdOut($note_id,$host);

		$ReturnObject = array();
		$ReturnObject['message'] = "Note Added";
		$ReturnObject['note_id'] = $note_id;

		}
	else
		{

		$query = "INSERT INTO notes(";

		if(isset($title)){ $query .= "title,"; }
		if(isset($note)){ $query .= "note,"; }
		if(isset($post_date)){ $query .= "post_date"; }

		$query .= ") VALUES(";

		if(isset($title)){ $query .= "'" . mysql_real_escape_string($title) . "',"; }
		if(isset($note)){ $query .= "'" . mysql_real_escape_string($note) . "',"; }
		if(isset($post_date)){ $query .= "'" . mysql_real_escape_string($post_date) . "'"; }

		$query .= ")";

		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$note_id = mysql_insert_id();

    $host = $_SERVER['HTTP_HOST'];
  	$note_id = prepareIdOut($note_id,$host);
    
		$ReturnObject = array();
		$ReturnObject['message'] = "Note Added";
		$ReturnObject['note_id'] = $note_id;

		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));

	});
?>
