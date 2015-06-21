<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Rogue Deck Master - Edit Deck List </title>

		<!-- Bootstrap core CSS (Bootstrap Copyright 2014 to Twitter Inc.) -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="test.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/redmond/jquery-ui.css">

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>
	</head>
	<!-- This document will be my reworking of the Deck.php code to turn it into a deck editor. I'm still not entirely sure what I want this page to look like and I should probably go look at other websites' solutions to get some ideas. -->
	<body>
		<?php
			require_once "main_navbar.php"; #Fixed navbar stored as a PHP document to simplify working on the nav bar itself. The navbar.php file is itself mostly just an HTML file, I'm doing this more for simplicity.
			require_once "login.php"; #login information for the database !!!!REMOVE BEFORE COMMIT!!!!
			
			#login code for MySQL DB, login details set in "login.php" above.
			$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
			if(!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
			mysqli_select_db($db_server, $db_database)
				or die("Unable to select database: " . mysqli_error());
			
			$user = "admin"; #temporary user value until the login system is implemented !!!REPLACE LATER!!!
			
			function test_input($data) { #this function is setup to remove the special characters from any input by the user, primarily to prevent SQL injections.
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}	
			
			if(!empty($_GET['decknum'])) {
				$decknum = test_input($_GET["decknum"]);
				
				$query = "SELECT * FROM decknum WHERE decknum='$decknum'"; #retrieves the deck information from the database
				$result = mysqli_query($db_server, $query);
				if(!$result){
					echo "<p>This deck is no longer in the database.</p>";
				}
				
				$row = mysqli_fetch_row($result);
				#the HTML and PHP below displays the decklist information from the database.
		?>
		
		<!-- Begin primary deck information display section -->
		
		<div class="container">
			<div class="page-header">
				<h1>Deck: <?php echo "$row[1]"; ?><small class="pull-right">Format: <?php echo "$row[3]"; ?></small></h1>
			</div>
			<div class="row">
				<div class="col-lg-3">
					<h4>Deck Author: <?php echo "$row[2]"; ?></h3>
				</div>
				<div class="col-lg-offset-1 col-lg-2">
					<h4>Colors: <?php echo "$row[4]"; ?></h3>
				</div>
				<div class="col-lg-offset-1 col-lg-5">
					<h4>Description:</h3>
					<p><?php echo "$row[5]"; ?></p>
				</div>
			</div>
		</div>
		
		<!-- End primary deck information display section -->
		
		<?php
			#this PHP segment is to retrieve and sort out the card information from the database as it's entered by the user.
			$query = "SELECT * FROM $decknum";
			$result = mysqli_query($db_server, $query);
			if(!$result) die("Database access failed: " . mysqli_error());
			$rows = mysqli_num_rows($result);
			
			$creatures = array();
			$lands = array();
			$spells = array();
			$sideb = array();
			$planeswalkers = array();
			
			#the following loop sorts the 5 card types of interest into their respective arrays by finding whether or not the type string is within the collapsed type array values.
			for($i = 0; $i < $rows; $i++){
				$row = mysqli_fetch_row($result);
				if((strpos($row[2], 'Creature') !== false) && ($row[3] == 'false')){
					$creatures[$row[1]] = $row[0];
				}
				elseif((strpos($row[2], 'Land') !== false) && ($row[3] == 'false')){
					$lands[$row[1]] = $row[0];
				}
				elseif((strpos($row[2], 'Planeswalker') !== false) && ($row[3] == 'false')){
					$planeswalkers[$row[1]] = $row[0];
				}
				elseif($row[3] == 'false'){
					$spells[$row[1]] = $row[0];
				}
				elseif($row[3] == 'true'){
					$sideb[$row[1]] = $row[0];
				}
			}
		?>
		
		<!-- Begin displaying card information from the database -->
		
		<div class="container">
			<!-- Thes PHP in this section sums the quantities of each of the cardtype arrays for each section, and then displays each card in <quantity> <cardname> pairs as they are paired in the array itself and the database. -->
			<div class="row">
				<div class="col-lg-4">
					<h3>Creatures (<?php echo array_sum($creatures); ?>)</h3>
					<ul>
						<?php
							foreach($creatures as $key => $val){
								echo "<li>$val <a href='#'>$key</a></li>";
							}
						?>
					</ul>
					<h3>Planeswalkers (<?php echo array_sum($planeswalkers); ?>)</h3>
					<ul>
						<?php
							foreach($planeswalkers as $key => $val){
								echo "<li>$val <a href='#'>$key</a></li>";
							}
						?>
					</ul>
					<h3>Lands (<?php echo array_sum($lands); ?>)</h3>
					<ul>
						<?php
							foreach($lands as $key => $val){
								echo "<li>$val <a href='#'>$key</a></li>";
							}
						?>
					</ul>
				</div>
				<div class="col-lg-offset-1 col-lg-4">
					<h3>Spells (<?php echo array_sum($spells); ?>)</h3>
					<ul>
						<?php
							foreach($spells as $key => $val){
								echo "<li>$val <a href='#'>$key</a></li>";
							}
						?>
					</ul>
					<h3>Sideboard (<?php echo array_sum($sideb); ?>)</h3>
					<ul>
						<?php
							foreach($sideb as $key => $val){
								echo "<li>$val <a href='#'>$key</a></li>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		
		<?php
			}
			else{ #wraps the html content, to be displayed only if this page is reached without a proper GET request.
		?>
		<p> You have reached this page in error. Please select a deck list from View Decks </p>
		
		<?php 
			} #end the GET failure message.
		?>
		<!-- END displaying card information from the database -->
		
		<footer class="blog-footer">
			<p>&copy; Rogue Deck Master 2015</p>
			<p>Magic: The Gathering&trade; is &copy; Wizards of the Coast, 2015</p>
		</footer>

    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>
</html>