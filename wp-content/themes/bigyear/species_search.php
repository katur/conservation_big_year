<?php
	include("katherine_connect.php");
	/*
	Template Name: Species Search
	Copyright (c) 2013 Katherine Erickson
	*/
	get_header(); 
?>

<h1 id="species-title">Big Year Species Log</h1>
<div class="species-section">
	Select filters below to narrow search.
	Click a species name to see its page.
</div>

<div class="species-section">
	<h2 class="species-subtitle">Filters</h2>
	<div class="filter-subsection">
		<a class="filter-name" href="./">Clear Filter</a>
	</div>
		
	<div class="filter-subsection">
		<a href="./?in_conservation_list=1">In conservation list</a>
	</div>
	
	<div class="filter-subsection">
		<span class="filter-name">ESA status:</span>
		<a href="./?esa_status=1">Endangered</a>
		<a href="./?esa_status=2">Threatened</a>
		<a href="./?esa_status=3">Candidate</a>
	</div>

	<div class="filter-subsection">
		<span class="filter-name">ABC status:</span>
		<a href="./?abc_status=1">
			Red (Highest Continental Concern)
		</a>
		<a href="./?abc_status=2">
			Yellow (Declining or Rare Continental Species)
		</a>
	</div>
			
	<div class="filter-subsection">
		<a href="./?is_lifer=1">Lifer for Laura</a>
	</div>
</div>

<div class="species-section">
	<?php
		// see if there is a filter term in the url
		$in_conservation_list = mysql_real_escape_string($_GET["in_conservation_list"]);
		$esa_status = mysql_real_escape_string($_GET["esa_status"]);
		$abc_status = mysql_real_escape_string($_GET["abc_status"]);
		$is_lifer = mysql_real_escape_string($_GET["is_lifer"]);
		
		// start building query
		$query = "SELECT common_name, url_common_name FROM species_list";

		// if there is a filter term, add condition
		if ($in_conservation_list)
			$query = $query . " WHERE in_conservation_list = $in_conservation_list";
		if ($esa_status)
			$query = $query . " WHERE esa_status = $esa_status";
		else if ($abc_status)				
			$query = $query . " WHERE abc_status = $abc_status";	
		else if ($is_lifer)
			$query = $query . " WHERE is_lifer = $is_lifer";

		// order by aou_list id
		$query = $query . " ORDER BY id";

		// run query
		$result = mysql_query($query) or die(mysql_error());

		echo "<h2 class='species-subtitle'>" . mysql_numrows($result) . " Species</h2>
			<div class='species-list'>	
		";
		
		// fetch results
		while ($row = mysql_fetch_assoc($result)) {
			$common_name = $row["common_name"];
			$url_common_name = $row["url_common_name"];
			echo "<a href = '/species/?common_name=$url_common_name'>$common_name</a>";

			// if logged in, show links to edit
			if ($_SESSION["logged_in"]) {
				echo "<a href = '/edit/$url_common_name'>Edit</a>";
			}
		}
	?>
		</div>
	</div>

<?php get_footer(); ?>
