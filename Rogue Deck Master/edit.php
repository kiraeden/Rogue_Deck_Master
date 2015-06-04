<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Harbor Nautical Antiques</title>

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
            <li><a href="test.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="view.php">View Database</a></li>
					<li><a href="add.php">Add Item</a></li>
					<li class="active"><a href="edit.php">Edit Database</a></li>
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
		</br>
		<div class="page-header">
			<h1>Database List</h1>
		</div>
      <!-- Example row of columns -->
		<div class="row">
			<div class="form-group">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><input type="checkbox" name="all" value=""></th>
								<th>#</th>
								<th>Item Name</th>
								<th>Category</th>
								<th>Quantity #</th>
								<th>Details</th>
								<th>Image Source</th>
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
								
								// define variables and set to empty values
								$value = "";
								
								//Need to figure out how to upload a file and pass the file name along to the imagesrc value in the SQL query
								
								if ($_SERVER["REQUEST_METHOD"] == "POST") {

									$delete[] = $_POST['selection'];
									
									foreach($delete as list($value)){
										//$query = "DELETE FROM inventory WHERE item='$value'";
										//mysqli_query($db_server, $query);
										
										echo "<p>$value</p>";
										$value = "";
									}
								}

								function test_input($data) {
								   $data = trim($data);
								   $data = stripslashes($data);
								   $data = htmlspecialchars($data);
								   return $data;
								}
								
								$query = "SELECT * FROM inventory";
								$result = mysqli_query($db_server, $query);
								if(!$result) die("Database access failed: " . mysqli_error());
								$rows = mysqli_num_rows($result);
								
								for($i = 0; $i < $rows; $i++){
									$row = mysqli_fetch_row($result);
									echo "<tr>\n";
									echo "<td><input type='checkbox' name='selection[]' value='$row[0]'></td>\n";
									$n = $i+1;
									echo "<td>$n</td>\n";
									echo "<td><input type='text' placeholder='$row[0]' name='item' class='form-control'></td>\n";
									echo "<td><input type='text' placeholder='$row[1]' name='type' class='form-control'></td>\n";
									echo "<td><input type='text' placeholder='$row[2]' name='quantity' class='form-control'></td>\n";
									echo "<td><input type='text' placeholder='$row[3]' name='details' class='form-control'></td>\n";
									echo "<td><input type='text' placeholder='$row[4]' name='imagesrc' class='form-control'></td>\n";
									echo "</tr>\n";
								}
							?>
						</tbody>
					</table>
					<input class="btn btn-primary" type="submit" name="submit" value="Delete Selected">
				</form>
			</div>
        </div>

      <hr>

      <footer>
        <p>&copy; Harbor Nautical 2014</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
</html>