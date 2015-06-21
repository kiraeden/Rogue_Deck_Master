<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Ethan Lockwood">

		<title>Rogue Deck Master</title>

		<!-- Bootstrap core CSS (Bootstrap Copyright 2015 to Twitter Inc.) -->
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
		
			$user = 'admin';  #temporary user value until the login system is implemented !!!REPLACE LATER!!!
		?>
    <div class="container">
		<div class="page-header">
			<h1>Your Collection</h1>
		</div>
		<?php
			require_once "collection_login.php";
			
			#login code for MySQL DB, login details set in "login.php" above.
			$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
			if(!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
			mysqli_select_db($db_server, $db_database)
				or die("Unable to select database: " . mysqli_error());
			
			$quantity = $cardname = $set_name = "";
			
			if(!empty($_POST['card-submit'])){
				$quantity = test_input($_POST["quantity"]);
				$cardname = test_input($_POST["cardname"]);
				
				/*
				$string = file_get_contents("AllCards.json");
				$json_a = json_decode($string, true);
				
				foreach ($json_a as $card => $value){
					if($cardname == test_input($card)){ #this is my version of input validation. I will re-compare the card as it's being entered into the database to ensure that only card data is entered into this field (and so that a mis-spelled card name can't occur either)
						$valid_card = true;
						break;
					} #There needs to be an additional validation notification if the data the user attempts to enter is not a part of the JSON card database file. But I think this could also be handled in the form by Javascript. need to investigate.
				}*/
				
				$query = "INSERT INTO $user(quantity, cardname, set_name) VALUES ('$quantity', '$cardname', '$set_name')";
				$result = mysqli_query($db_server, $query);
			}
			
			$query = "SELECT * FROM $user"; #need to make the database for the user's collection
			$result = mysqli_query($db_server, $query);
			
			$rows = 0;
			
			if(!$result){
				$query = "CREATE TABLE $user(quantity VARCHAR(128), cardname VARCHAR(128), set_name VARCHAR(128))";
				mysqli_query($db_server, $query);
			}
			else{
				$rows = mysqli_num_rows($result);
			}
			
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
		?>
		
		<!-- Begin Search and Entry Form for collection entry -->
		
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
					<div class="col-lg-1 col-lg-offset-1">
						<div class="form-group">
							<input class="btn btn-primary" type="submit" name="card-submit" value="Add Card"></input>
						</div>
					</div>
				</div>
			</form>
		</div>
		
		<!-- End Search and Entry Form for collection entry -->
		
		<!-- Begin collection table list. -->
		
		<div class="row">
			<table class="table table-striped">
            <thead>
              <tr>
                <th>Quantity</th>
                <th>Card</th>
                <th>Set</th>
              </tr>
            </thead>
            <tbody>
				<?php
					for($i=0; $i < $rows; $i++){
						$row = mysqli_fetch_row($result);
						echo "<tr>\n";
						echo "<td>$row[0]</td>\n";
						echo "<td>$row[1]</td>\n";
						echo "<td>$row[2]</td>\n";
						echo "</tr>\n";
					}
				?>
            </tbody>
          </table>
		  <p>
			<a href="add_cards.php"><button type="button" class="btn btn-primary">Add Item</button></a>
			<a href="edit_cards.php"><button type="button" class="btn btn-warning">Edit List</button></a>
		  </p>
        </div>

      <hr>

      <footer>
        <p>&copy; Rogue Deckmaster 2015</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.js"></script>
	
	<!-- The following basic piece of javascript corresponds to the main_navbar.php file allowing me to set the active link styling from Bootstrap to the navbar link in the menu for this specific page. It had to be placed at the bottom so it would load after and be applied correctly to the navbar. -->
	<script>
		document.getElementById("view_cards").className = "active";
	</script>
</html>