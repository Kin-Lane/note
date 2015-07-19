<?php
$route = '/notes/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	$request = $app->request();
 	$param = $request->params();

	if(isset($param['query'])){ $query = trim(mysql_real_escape_string($param['query'])); } else { $query = '';}
	if(isset($param['page'])){ $page = trim(mysql_real_escape_string($param['page'])); } else { $page = 0;}
	if(isset($param['count'])){ $count = trim(mysql_real_escape_string($param['count'])); } else { $count = 250;}
	if(isset($param['sort'])){ $sort = trim(mysql_real_escape_string($param['sort'])); } else { $sort = 'modified_date';}
	if(isset($param['order'])){ $order = trim(mysql_real_escape_string($param['order'])); } else { $order = 'DESC';}
	//echo "query: " . $query . "<br />";
	$Query = "SELECT DISTINCT n.note_id,n.title,n.details,n.post_date,n.modified_date FROM notes n";
	//$Query .= " INNER JOIN note_tag_pivot npt ON n.note_id = npt.note_id";
	//$Query .= " INNER JOIN tags t ON npt.tag_id = t.tag_id";
	$Query .= " WHERE n.note_id is not null";
	if($query!='')
		{
		$Query .= " AND (n.title LIKE '%" . $query . "%' OR n.details LIKE '%" . $query . "%')";
		}
	$Query .= " ORDER BY n." . $sort . " " . $order . " LIMIT " . $page . "," . $count;
	//echo $Query . "<br />";

	$notesResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	while ($notes = mysql_fetch_assoc($notesResult))
		{

		$archive = 0;
		$note_id = $notes['note_id'];
		$title = $notes['title'];
		$details = $notes['details'];
		$post_date = $notes['post_date'];
		$modified_date = $notes['modified_date'];

		// manipulation zone

		$F = array();
		$F['note_id'] = $note_id;
		$F['title'] = $title;
		$F['details'] = $details;
		$F['post_date'] = $post_date;
		$F['modified_date'] = $modified_date;
		$F['tags'] = array();

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

		if($archive==0)
			{
			array_push($ReturnObject, $F);
			}
		}

		$app->response()->header("Content-Type", "application/json");
		echo format_json(json_encode($ReturnObject));
	});
?>
