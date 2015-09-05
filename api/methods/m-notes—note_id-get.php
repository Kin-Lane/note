<?php
$route = '/notes/:note_id/';
$app->get($route, function ($note_id)  use ($app){

	$host = $_SERVER['HTTP_HOST'];
	$note_id = prepareIdIn($note_id,$host);

	$ReturnObject = array();

	$Query = "SELECT * FROM notes WHERE note_id = " . $note_id;
	//echo $Query . "<br />";

	$notesResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($notes = mysql_fetch_assoc($notesResult))
		{

		$note_id = $notes['note_id'];
		$title = $notes['title'];
		$details = $notes['details'];
		$post_date = $notes['post_date'];

		$TagQuery = "SELECT t.tag_id, t.tag from tags t";
		$TagQuery .= " INNER JOIN note_tag_pivot npt ON t.tag_id = npt.tag_id";
		$TagQuery .= " WHERE npt.note_ID = " . $note_id;
		$TagQuery .= " ORDER BY t.tag DESC";
		$TagResult = mysql_query($TagQuery) or die('Query failed: ' . mysql_error());

		while ($Tag = mysql_fetch_assoc($TagResult))
			{
			$thistag = $Tag['tag'];

			$T = array();
			$T = $thistag;
			array_push($F['tags'], $T);
			//echo $thistag . "<br />";
			if($thistag=='Archive')
				{
				$archive = 1;
				}
			}

		// manipulation zone

		$host = $_SERVER['HTTP_HOST'];
		$note_id = prepareIdOut($note_id,$host);

		$F = array();
		$F['note_id'] = $note_id;
		$F['title'] = $title;
		$F['details'] = $details;
		$F['post_date'] = $post_date;
		$F['tags'] = array();

		$ReturnObject = $F;
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
