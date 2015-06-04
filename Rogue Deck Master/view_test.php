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
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Decks <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class="active"><a href="view.php">View Database</a></li>
					<li><a href="add.php">Add Item</a></li>
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
		<div class="page-header">
			<h1>Deck Lists</h1>
		</div>
		
      <!-- Example row of columns -->
      <div class="row">
			<table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Author</th>
                <th>Format</th>
                <th>Color(s)</th>
				<th>Deck Name</th>
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
					
					$query = "SELECT * FROM decknum";
					$result = mysqli_query($db_server, $query);
					if(!$result) die("Database access failed: " . mysqli_error());
					$rows = mysqli_num_rows($result);
					
					for($i = 0; $i < $rows; $i++){
						$row = mysqli_fetch_row($result);
						echo "<tr>";
						echo "<td>$row[0]</td>";
						echo "<td>$row[1]</td>";
						echo "<td>$row[2]</td>";
						echo "<td>$row[3]</td>";
						echo "</tr>";
					}
				?>
            </tbody>
          </table>
		  <p>
			<a href="add.php"><button type="button" class="btn btn-primary">Add Item</button></a>
			<a href="edit.php"><button type="button" class="btn btn-warning">Edit List</button></a>
		  </p>
        </div>

      <hr>

      <footer>
        <p>&copy; Rogue Deckmaster 2015</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
</html>