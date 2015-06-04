<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Magic Group Collection</title>

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
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Harbor Nautical Antiques</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="test.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="view.php">View Database</a></li>
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

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Welcome to Harbor Nautical</h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <p><a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
		<?php
			require_once "login.php";
			
			#login code for MySQL DB, login details set in "login.php" above.
			$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
			if(!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
			mysqli_select_db($db_server, $db_database)
				or die("Unable to select database: " . mysqli_error());
			
			$query = "SELECT * FROM inventory";
			$result = mysqli_query($db_server, $query);
			if(!$result) die("Database access failed: " . mysqli_error());
			$rows = mysqli_num_rows($result);
			
			for($i = 0; $i < $rows; $i++){
				$row = mysqli_fetch_row($result);
				if($row[2] > 0){
					echo "<div class='col-md-2'>";
					echo "<h2>$row[0]</h2>";
					echo "<img src='$row[4]' class='img-thumbnail' alt=''>"; // Need to add the image location to the database table.
					echo "<p><a class='btn btn-default' href='#' role='button'>View details &raquo;</a></p>"; // Need to add the details text and price details to the database table as well.
					echo "</div>";
				}
			}
			
			//need the ability to sort by category of items, category listings should be based on the categories available in the database.
			//also need an option to hide out-of-stock items.
		?>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
</html>