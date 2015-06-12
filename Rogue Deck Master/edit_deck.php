<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Rogue Deck Master - Edit Decks</title>

		<!-- Bootstrap core CSS (Bootstrap Copyright 2014 to Twitter Inc.) -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="theme.css" rel="stylesheet">
	</head>
	
	<body>
		<!-- Fixed navbar -->
    <?php
		require_once "main_navbar.php"; #Fixed navbar stored as a PHP document to simplify working on the nav bar itself. The navbar.php file is itself mostly just an HTML file, I'm doing this more for simplicity.
		
		$user = 'admin';
	?>
	
    <div class="container">
		</br>
		<div class="page-header">
			<h1>Select Deck to Edit:</h1>
		</div>
      <!-- Example row of columns -->
		<div class="row">
			<div class="form-group">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><input class="selectall" type="checkbox" name="all" value=""> Select All</th>
								<th>#</th>
								<th>Deck Name</th>
								<th>Deck Author</th>
								<th>Format</th>
								<th>Colors</th>
							</tr>
						</thead>
						<tbody>
							<?php
								require_once "login.php";
								
								#login code for MySQL DB, login details set in "login.php" above.
								$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
								if(!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
								mysqli_select_db($db_server, $db_database)
									or die("Unable to select database: " . mysqli_error());
								
								if(!empty($_POST['delete_decks'])){
									foreach($_POST['deck'] as $deck){ #the checkbox for colors is returned as an array of the color values, so I create the final color-set string via this foreach loop on that array, appending the values to a single string.
										$query = "DELETE FROM decknum WHERE decknum='$deck'";
										mysqli_query($db_server, $query);
										
										$query = "DROP TABLE $deck";
										mysqli_query($db_server, $query);
									}
								}
								
								$query = "SELECT * FROM decknum WHERE user = '$user'";
								$result = mysqli_query($db_server, $query);
								$rows = mysqli_num_rows($result);
								
								for($i = 0; $i < $rows; $i++){
									$row = mysqli_fetch_row($result);
									echo "<tr>\n";
									echo "<td><input class='deckcheck' type='checkbox' name='deck[]' id='deck' value='$row[0]'></td>\n";
									$n = $i+1;
									echo "<td>$n</td>\n";
									echo "<td><a href='deck.php?decknum=$row[0]'>$row[1]</a></td>\n";
									echo "<td>$row[2]</td>\n";
									echo "<td>$row[3]</td>\n";
									echo "<td>$row[4]</td>\n";
									echo "</tr>\n";
								}
								
								function test_input($data) {
								   $data = trim($data);
								   $data = stripslashes($data);
								   $data = htmlspecialchars($data);
								   return $data;
								}
							?>
						</tbody>
					</table>
					<input class="btn btn-primary" type="submit" name="delete_decks" value="Delete Selected">
				</form>
			</div>
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
	
	<script>
		$(document).ready(function() {
			$('.selectall').click(function(event) {  //on click
				if(this.checked) { // check select status
					$('.deckcheck').each(function() { //loop through each checkbox
						this.checked = true;  //select all checkboxes with class "checkbox1"              
					});
				}else{
					$('.deckcheck').each(function() { //loop through each checkbox
						this.checked = false; //deselect all checkboxes with class "checkbox1"                      
					});        
				}
			});

		});
	</script>
	
	<!-- The following basic piece of javascript corresponds to the main_navbar.php file allowing me to set the active link styling from Bootstrap to the navbar link in the menu for this specific page. It had to be placed at the bottom so it would load after and be applied correctly to the navbar. -->
	<script>
		document.getElementById("edit_decks").className = "active";
	</script>
</html>