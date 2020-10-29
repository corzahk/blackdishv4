<?php

if($_SERVER['REQUEST_METHOD'] === 'POST' && us_level == 6){

	$pg_title    = sc_sec($_POST['pg_title']);
	$pg_sort     = (int)($_POST['pg_sort']);
	$pg_id       = (int)($_POST['id']);
	$pg_footer   = (isset($_POST['footer']) ? 1 : 0);
	$pg_content  = sc_sec($_POST['pg_content'], true);

	if(empty($pg_title) || empty($pg_content)){
		$alert = [
			'type'  =>'danger',
			'alert' => fh_alerts($lang['alerts']['required'])
		];
	} else {
		$data = [
			'title'      => $pg_title,
			'sort'       => $pg_sort,
			'footer'     => $pg_footer,
			'content'    => $pg_content
		];
		if($pg_id){
			$data['updated_at'] = time();
			db_update('pages', $data, $pg_id);
		} else {
			$data['created_at'] = time();
			db_insert( 'pages', $data );
		}

		$alert = [
			'type'  =>'success',
			'alert' => fh_alerts('Page has sended successfully.', 'success')
		];
	}
	echo json_encode($alert);
}
