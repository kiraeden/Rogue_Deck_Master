<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Rogue Deck Master</title>

		<!-- Bootstrap core CSS (Bootstrap Copyright 2014 to Twitter Inc.) -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="theme.css" rel="stylesheet">
	</head>
	
	<body>
		<!-- Fixed navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Rogue Deck Master</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li><a href="test.php">Home</a></li>
						<li><a href="about.html">About</a></li>
						<li><a href="contact.html">Contact</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="view.php">View Database</a></li>
								<li class="active"><a href="add.php">Add Item</a></li>
								<li><a href="edit.php">Edit Database</a></li>
							</ul>			
						</li>
					</ul>
					<form class="navbar-form navbar-right" role="form">
						<div class="form-group">
							<input type="text" placeholder="Email" class="form-control">
						</div>
						<div class="form-group">
							<input type="password" placeholder="Password" class="form-control">
						</div>
						<button type="submit" class="btn btn-success">Sign in</button>
					</form>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	
		<div class="container">
			<?php
				require_once "login.php";
					
				#login code for MySQL DB, login details set in "login.php" above.
				$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
				if(!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
				mysqli_select_db($db_server, $db_database)
					or die("Unable to select database: " . mysqli_error());
					
				// define variables and set to empty values
				$author = $name = $colors = $creatures = $spells = $land = $sideboard = $decknum = "";
				
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					$author = test_input($_POST["author"]);
					$name = test_input($_POST["name"]);
					$colors = test_input($_POST["colors"]);
					$creatures = test_input($_POST["creatures"]);
					$spells = test_input($_POST["spells"]);
					$land = test_input($_POST["land"]);
					$sideboard = test_input($_POST["sideboard"]);
					
					$query = "SELECT * FROM decknum";
					$result = mysqli_query($db_server, $query);
					$rows = mysqli_num_rows($result);
					
					$decknum .= 'deck_';
					$decknum .= $rows;
					$query = "CREATE TABLE $decknum(quantity VARCHAR(128), card_name VARCHAR(128), part VARCHAR(128))";
					mysqli_query($db_server, $query);
					
					$query = "INSERT INTO decknum(decknum, author, format, colors) VALUES ('$rows','$author','Standard','$colors')";
					mysqli_query($db_server, $query);
					
					deck_parse($creatures, "creatures", $decknum, $db_server);
					deck_parse($spells, "spells", $decknum, $db_server);
					deck_parse($land, "land", $decknum, $db_server);
					deck_parse($sideboard, "sideboard", $decknum, $db_server);
					
					//NOTES: It's not yet clear what exactly is happening to the data passed to deck_parse() but it's obviously malformed in some way. I suspect that either the POST is cutting out every bit of the entry after the first line.
					//To check this, I think I will output the raw text back to the webpage just to figure out what it looks like, then perhaps check the output of the deck_parse to see what that's doing before it tries to hit the database.
				}
				
				function deck_parse($data, $part, $decknum, $db_server) { // converts the raw decklist data from the text entry fields into individual cards for the decklist database
					$quantity = "";
					$card_name = "";
					$n = 0;
					$arr = str_split($data); //separate the raw text into the line-break string chunks.
				
					$len = sizeof($arr);
					for($i = 0; $i < $len; $i++){
						if(ctype_digit($arr[$i])){
							$n++;
							if($n == 2){
								$card_name = remove_leading_space($card_name);
								$query = "INSERT INTO $decknum(quantity, card_name, part) VALUES ('$quantity','$card_name','$part')"; //inserts the card into the decklist database
								mysqli_query($db_server, $query);
								$n = 1;
								$quantity = $arr[$i];
								$card_name = "";
							}
							else{
								$quantity = $arr[$i]; //separates the card quantity from the card name and stores it.
							}
						}
						else{
							$card_name .= $arr[$i]; //captures the rest of the card name.
						}
					}
					// this final database insertion query is to insert the final value into the card list that would be missed by the FOR loop.
					$query = "INSERT INTO $decknum(quantity, card_name, part) VALUES ('$quantity','$card_name','$part')";
					mysqli_query($db_server, $query);
				}
				
				function remove_leading_space($name){ //removes the leading space and possible trailing newline character from the card's name string
					$len = sizeof($name);
					$n = $len - 1;
					for($i = 0; $i < $len; $i++){
						if($name[0] == ' '){
							$name = substr($name, 1); // removes the leading space
						}
						if($name[$i] == '\n'){
							$name = substr($name, 0, -1); //removes the trailing newline character (if there is one)
						}
						if($name[$n] == ' '){
							$name = substr($name, 0, -1); //removes the trailing newline character (if there is one)
						}
					}
					return $name;
				}
				
				function test_input($data) {
				   $data = trim($data);
				   $data = stripslashes($data);
				   $data = htmlspecialchars($data);
				   return $data;
				}
			?>
		
			<!-- <div class="form-group">
				<form method="post" action="<?//php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<p>Item Name: <input type="text" placeholder="Item" name="name" class="form-control"></p>
					<p>Category: <input type="text" placeholder="Category" name="type" class="form-control"></p>
					<p>Quantity: <input type="text" placeholder="Quantity" name="quantity" class="form-control"></p>
					<p>Details: <textarea name="details" rows="5" cols="40" class="form-control" type="text"></textarea></p>
					<input class="btn btn-primary" type="submit" name="submit" value="Add Item">
				</form>
			</div> -->
			
			<div>
			<!-- Title Box here -->
			</div>
			<div class="form-group">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<p>Author: <input type="text" placeholder="Author" name="author" class="form-control"></p>
					<p>Deck Name: <input type="text" placeholder="Deck Name" name="name" class="form-control"></p>
					<p>Color(s): <input type="text" placeholder="Color(s)" name="colors" class="form-control"></p>
					<p>Creatures: <textarea name="creatures" rows="5" cols="5" class="form-control" type="text"></textarea></p>
					<p>Spells: <textarea name="spells" rows="5" cols="5" class="form-control" type="text"></textarea></p>
					<p>Land: <textarea name="land" rows="5" cols="5" class="form-control" type="text"></textarea></p>
					<p>Sideboard: <textarea name="sideboard" rows="5" cols="5" class="form-control" type="text"></textarea></p>
					<input class="btn btn-primary" type="submit" name="submit" value="Submit Decklist">
				</form>
			</div>

			<hr>

			<footer>
				<p>&copy; Rogue Deck Master</p>
			</footer>
		</div> <!-- /container -->


    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
</html>