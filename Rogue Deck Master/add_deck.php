<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Rogue Deck Master - Add Deck</title>

		<!-- Bootstrap core CSS (Bootstrap Copyright 2014 to Twitter Inc.) -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="test.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/redmond/jquery-ui.css">

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>
		<script type="text/javascript" src="app1.js"></script>
		<script type="text/javascript">

		</script>
	</head>
	
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
			
			$title = $author = $format = $desc = $colors = '';
			
			$decknum = '';
			
			$display_field = true;
			
			if (!empty($_POST['info-submit'])) { #this is the POST check for the basic deck information
				$title = test_input($_POST["title"]);
				$author = test_input($_POST["author"]);
				$format = test_input($_POST["format"]);
				$description = test_input($_POST["desc"]);
				foreach($_POST['color'] as $color){ #the checkbox for colors is returned as an array of the color values, so I create the final color-set string via this foreach loop on that array, appending the values to a single string.
					$colors .= $color;
				}
				
				#this query sequence is to figure out how many decks are in the system already so I can sequentially number the new deck information about to be entered.
				$query = "SELECT * FROM decknum";
				$result = mysqli_query($db_server, $query);
				$rows = mysqli_num_rows($result);
				
				$decknum .= 'deck_';
				$decknum .= $rows;
				
				$query = "INSERT INTO decknum(decknum, title, author, format, colors, description, user) VALUES ('$decknum', '$title', '$author', '$format', '$colors', '$description', '$user')"; #this query inserts the deck information into the database.
				mysqli_query($db_server, $query);
				
				$query = "CREATE TABLE $decknum(quantity INT(128), cardname VARCHAR(128), type VARCHAR(128), sideboard VARCHAR(128))"; #I created the deck-number reference value and table here to be passed along in a hidden form-field via POST.
				mysqli_query($db_server, $query);
				
				$display_field = false; #once this POST is complete, I hide the entry form and instead display the deck entry field, with the previous form information displayed above it.
			}
			
			$cardname = $type = $sideboard = $sb = '';
			$quantity = 0;
			
			if(!empty($_POST['card-submit'])) {
				$cardname = test_input($_POST["cardname"]);
				$quantity = test_input($_POST["quantity"]);
				foreach($_POST['sideboard'] as $sideboard){ #checkbox fields are returned as arrays, even if the array only represents a singular value.
					$sb .= $sideboard;
				}
				$decknum = test_input($_POST["database_name"]);
				
				$string = file_get_contents("AllCards.json");
				$json_a = json_decode($string, true);
				
				$valid_card = false;
				$display_field = false; #because I have two separate forms as well as displays for the values entered in those forms in a single document, I have to maintain that those forms remain hidden once completed.
				
				foreach ($json_a as $card => $value){
					if($cardname == test_input($card)){ #this is my version of input validation. I will re-compare the card as it's being entered into the database to ensure that only card data is entered into this field (and so that a mis-spelled card name can't occur either)
						$valid_card = true;
						$type = $value['types']; #Creature types such as Enchantment Creature appear together in the type section of the JSON doc, so to make them appear correctly, I may have to do some parsing of the 'types' to check for the Creature type specifically.
						break;
					} #There needs to be an additional validation notification if the data the user attempts to enter is not a part of the JSON card database file. But I think this could also be handled in the form by Javascript. need to investigate.
				}
				
				if($valid_card){
					$type = implode($type); #the type values retrieved from the JSON file are in an array, so I have to collapse the array.
					$cardname = mysqli_real_escape_string($db_server, $cardname); #card values also can have single quotes/apostrophes in them so I have to escape those before the string can enter the database.
					
					$query = "INSERT INTO $decknum(quantity, cardname, type, sideboard) VALUES ('$quantity', '$cardname', '$type', '$sideboard')";
					mysqli_query($db_server, $query);
				}
			}
			
			function test_input($data) { #this function is setup to remove the special characters from any input by the user, primarily to prevent SQL injections.
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}	
		?>
		
		<?php
			if($display_field){ #This is used to hide the entire deck information form once that data has been entered.
		?>
		<!-- Begin primary deck information entry form-->
		<div class="container">
			<div class="page-header">
				<h1>The Deck Builder</h1>
			</div>
			<div style="background-color: #CCCCCC; border-radius: 5px; padding: 20px;">
				<form role="form" method="post">
					<div class="row">
						<div class="col-lg-4">
							<!-- title field for the user to name their deck -->
							<label>Deck Name:</label>
							<div class="form-group">
								<input type="text" class="form-control" name="title" placeholder="Enter Deck Name">
							</div><!-- /input-group -->
						</div><!-- /.col-lg-4 -->
						<div class="col-lg-4">
							<!-- Field for the user to identify who created the deck, either themselves or another -->
							<label>Author:</label>
							<div class="form-group">
								<input type="text" class="form-control" name="author" placeholder="Enter Deck Author">
							</div><!-- /input-group -->
						</div><!-- /.col-lg-4 -->
						<div class="col-lg-4">
							<div class="form-group">
								<!-- This is the selection field for the FORMAT of the deck -->
								<label for="sel1">Format:</label>
								<select class="form-control" id="format" name="format">
									<option>Standard</option>
									<option>Modern</option>
									<option>Legacy</option>
									<option>Vintage</option>
									<option>Commander</option>
									<option>Tiny Leader</option>
									<option>Casual</option>
									<option>Other</option>
								</select>
							</div>
						</div><!-- /.col-lg-4 -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-lg-4">
							<br>
							<!-- checkbox field for deck color information -->
							<label>Color(s):</label>
							<div class="form-group">
								<label class="checkbox-inline">
									<input type="checkbox" name="color[]" id="color" value="W">White
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="color[]" id="color" value="U">Blue
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="color[]" id="color" value="B">Black
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="color[]" id="color" value="R">Red
								</label>
								<label class="checkbox-inline">
									<input type="checkbox" name="color[]" id="color" value="G">Green
								</label>
							</div>
						</div>
						<div class="col-lg-8">
							<br>
							<!-- field for the user to add details about the deck -->
							<label>Description:</label>
							<div class="form-group">
								<input type="text" class="form-control" name="desc" placeholder="Enter Description"></input>
							</div><!-- /input-group -->
						</div> <!-- /.col-lg-8 -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-lg-10">
						</div>
						<div class="col-lg-2">
							<br>
							<div class="form-group">
								<input class="btn btn-primary" type="submit" name="info-submit" value="Next >>">
							</div>
						</div>
					</div>
				</form>
			</div>
			<hr>
		</div> <!-- /container -->
		<!-- END primary deck information entry form -->
		<?php
			}
			if(!$display_field) {
				$query = "SELECT * FROM decknum WHERE decknum='$decknum'"; #retrieves the deck information from the database
				$result = mysqli_query($db_server, $query);
				if(!$result) die("Database access failed: " . mysqli_error());
				
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
		
		<!-- Begin autocomplete form field for card entry -->
		
		<div class="container">
			<div class="search-background">
				<form id="searchform" method="post" role="form">
					<div class="row">
						<div class="col-lg-1">
							<div class="form-group">
								<input class="form-control" type="text" name="quantity" placeholder="#"></input>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="form-group">
								<input class="form-control" type="text" id="autocomplete" name="cardname"></input>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="radio-inline">
									<input checked="true" type="radio" name="sideboard[]" id="sideboard" value="false">Mainboard
								</label>
								<label class="radio-inline">
									<input type="radio" name="sideboard[]" id="sideboard" value="true">Sideboard
								</label>
							</div>
						</div>
						<div class="col-lg-1 col-lg-offset-1">
							<div style="visibility: hidden; display: none;">
									<input class="form-control" name="database_name" type="text" value="<?php echo "$decknum"; ?>">
							</div>
							<div class="form-group">
								<input class="btn btn-primary" type="submit" name="card-submit" value="Add Card"></input>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<!-- END autocomplete form field for card entry -->
		
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
	
	<!-- The following basic piece of javascript corresponds to the main_navbar.php file allowing me to set the active link styling from Bootstrap to the navbar link in the menu for this specific page. It had to be placed at the bottom so it would load after and be applied correctly to the navbar. -->
	<script>
		document.getElementById("add_deck").className = "active";
	</script>
</html>