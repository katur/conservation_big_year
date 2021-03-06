<?php
	include("katherine_connect.php");
	/*
	Template Name: Process Species Info
	Copyright (c) 2013 Katherine Erickson
	*/

	// get the common name from the GET variable (visible in the url).
	$url_common_name = mysql_real_escape_string($_GET['common_name']);

	// grab variables from POST variable
	$seen_in_refuge = $_POST['seen_in_refuge'];
	$seen_only_in_refuge = $_POST['seen_only_in_refuge'];
	$flickr_code = $_POST['flickr_code'];
	$cornell_map = $_POST['cornell_map'];
	$ebird_map = $_POST['ebird_map'];
	$essay = $_POST['essay'];
	$sighting_info = $_POST['sighting_info'];
	if ($flickr_code) {
		$src = preg_replace("/.+src=\"(.+?)\".+/", "$1", stripcslashes($flickr_code));
		$width = preg_replace("/.+width=\"(.+?)\".+/", "$1", stripcslashes($flickr_code));
		$height = preg_replace("/.+height=\"(.+?)\".+/", "$1", stripcslashes($flickr_code));
		$query = "UPDATE species_list
			SET flickr_code='$flickr_code', flickr_src='$src',
			flickr_width='$width', flickr_height='$height', essay='$essay',
			sighting_info='$sighting_info',
			ebird_map='$ebird_map', cornell_map='$cornell_map',
			seen_in_refuge='$seen_in_refuge', seen_only_in_refuge='$seen_only_in_refuge'
			WHERE url_common_name='$url_common_name'
		";
	} else {
		$query = "UPDATE species_list
			SET flickr_code=NULL, flickr_src=NULL,
			flickr_width=NULL, flickr_height=NULL, essay='$essay',
			sighting_info='$sighting_info',
			ebird_map='$ebird_map', cornell_map='$cornell_map',
			seen_in_refuge='$seen_in_refuge', seen_only_in_refuge='$seen_only_in_refuge'
			WHERE url_common_name='$url_common_name'
		";
	}


	$result = mysql_query($query) or die(mysql_error());

	// set the header to redirect to VIEW page
	wp_redirect("/species/?common_name=$url_common_name");
?>
