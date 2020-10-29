<?php

if( $_SERVER['REQUEST_METHOD'] === 'POST' && us_level ){

	$p_title   = isset($_POST['title']) ? sc_sec($_POST['title'])     : '';
	$p_content = isset($_POST['content']) ? sc_sec($_POST['content']) : '';
	$p_review  = isset($_POST['rating']) ? (int)($_POST['rating'])    : 0;
	$p_id      = isset($_POST['id']) ? (int)($_POST['id'])            : 0;

	if(empty($p_title) || !$p_id || !$p_review){
		$alert = ["alert" => fh_alerts("All fields marked with * are required!"), "type" => "danger"];
	} elseif(!db_rows("orders WHERE item = '{$p_id}' && author = '".us_id."'")){
		$alert = ["alert" => fh_alerts("You cant add review to this item!"), "type" => "danger"];
	} elseif(db_rows("reviews WHERE item = '{$p_id}' && author = '".us_id."'")){
		$alert = ["alert" => fh_alerts("You already add a review to this item!"), "type" => "danger"];
	} else {

		$p_restaurant = db_get("items", "restaurant", $p_id);

		$data = [
			"title"      => $p_title,
			"content"    => $p_content,
			"stars"      => $p_review,
			"item"       => $p_id,
			"user"       => db_get("items", "author", $p_id),
			"restaurant" => $p_restaurant,
			"author"     => us_id,
			"created_at" => time()
		];

		db_insert('reviews', $data);
		db_update('restaurants', ['rating' => fh_stars($p_restaurant, 'restaurant', false)], $p_restaurant);

		$alert = ["alert" => fh_alerts("Success! all done!!", "success"), "type" => "success"];

	}

	echo json_encode($alert);
}
