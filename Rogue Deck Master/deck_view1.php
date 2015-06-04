<!DOCTYPE html>
<html lang="en">
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
		<link href="blog.css" rel="stylesheet">
	</head>

	<body>

		<div class="blog-masthead">
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
		</div>

		<div class="container">

			<div class="blog-header">
				<?php 
					require_once "login.php";
						
					#login code for MySQL DB, login details set in "login.php" above.
					$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
					if(!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
					mysqli_select_db($db_server, $db_database)
						or die("Unable to select database: " . mysqli_error());
					
					$deckname = "Deck Name"; //placeholder for the actual deck name supplied for a give deck in the database
					$author = "Default";
					
					echo("<h1 class='blog-title'>$deckname</h1>");
				?>
			</div>

			<div class="row">

				<div class="col-sm-8 blog-main">

					<div class="blog-post">
						<h2 class="blog-post-title">Deck Name : Colors - URWBG</h2>
						<p class="blog-post-meta">Author: <a href="#">Mark</a></p>
						
						<div class="row">
							<div class="col-xs-6 col-sm-5">
								<h3>Creatures (#)</h3>
								<ol class="list-unstyled">
									<li><a href="#">Card 1</a></li>
									<li><a href="#">Card 2</a></li>
									<li><a href="#">Card 3</a></li>
									<li><a href="#">Card 4</a></li>
									<li><a href="#">Card 5</a></li>
									<li><a href="#">Card 6</a></li>
									<li><a href="#">Card 7</a></li>
									<li><a href="#">Card 8</a></li>
								</ol>
							</div>
							<div class="col-xs-4 col-sm-5">
								<h3>Spells (#)</h3>
								<ol class="list-unstyled">
									<li><a href="#">Card 1</a></li>
									<li><a href="#">Card 2</a></li>
									<li><a href="#">Card 3</a></li>
									<li><a href="#">Card 4</a></li>
									<li><a href="#">Card 5</a></li>
									<li><a href="#">Card 6</a></li>
									<li><a href="#">Card 7</a></li>
									<li><a href="#">Card 8</a></li>
								</ol>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-5">
								<h3>Lands (#)</h3>
								<ol class="list-unstyled">
									<li><a href="#">Card 1</a></li>
									<li><a href="#">Card 2</a></li>
									<li><a href="#">Card 3</a></li>
									<li><a href="#">Card 4</a></li>
									<li><a href="#">Card 5</a></li>
									<li><a href="#">Card 6</a></li>
									<li><a href="#">Card 7</a></li>
									<li><a href="#">Card 8</a></li>
								</ol>
							</div>
							<div class="col-xs-4 col-sm-5">
								<h3>Sideboard</h3>
								<ol class="list-unstyled">
									<li><a href="#">Card 1</a></li>
									<li><a href="#">Card 2</a></li>
									<li><a href="#">Card 3</a></li>
									<li><a href="#">Card 4</a></li>
									<li><a href="#">Card 5</a></li>
									<li><a href="#">Card 6</a></li>
									<li><a href="#">Card 7</a></li>
									<li><a href="#">Card 8</a></li>
								</ol>
							</div>
						</div>
					</div><!-- /.blog-post -->

					<div class="blog-post">
						<fieldset disabled>
							<div class="col-sm-8">
								<div class="row">
									<h2>Comments</h2>
									<textarea name="comment" rows="5" cols="20" class="form-control disabled" type="text"></textarea>
								</div>
								<div class="row">
									</br>
									<input class="btn btn-primary" type="submit" name="submit" value="Submit">
								</div>
							</div>
						</fieldset>
					</div><!-- /.blog-post -->

				</div><!-- /.blog-main -->

				<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
					<div class="sidebar-module sidebar-module-inset">
						<h4>About</h4>
						<p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
					</div>
					<div class="sidebar-module">
						<h4>Archives</h4>
						<ol class="list-unstyled">
							<li><a href="#">March 2014</a></li>
							<li><a href="#">February 2014</a></li>
							<li><a href="#">January 2014</a></li>
							<li><a href="#">December 2013</a></li>
							<li><a href="#">November 2013</a></li>
							<li><a href="#">October 2013</a></li>
							<li><a href="#">September 2013</a></li>
							<li><a href="#">August 2013</a></li>
							<li><a href="#">July 2013</a></li>
							<li><a href="#">June 2013</a></li>
							<li><a href="#">May 2013</a></li>
							<li><a href="#">April 2013</a></li>
						</ol>
					</div>
					<div class="sidebar-module">
						<h4>Elsewhere</h4>
						<ol class="list-unstyled">
							<li><a href="#">GitHub</a></li>
							<li><a href="#">Twitter</a></li>
							<li><a href="#">Facebook</a></li>
						</ol>
					</div>
				</div><!-- /.blog-sidebar -->

			</div><!-- /.row -->

		</div><!-- /.container -->

		<footer class="blog-footer">
				<p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
				<p>&copy; Rogue Deckmaster 2015</p>
				<p>Magic: The Gathering&trade; is &copy; Wizards of the Coast 2015</p>
		</footer>

		<!-- Bootstrap core JavaScript ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/docs.min.js"></script>
	</body>
</html>
