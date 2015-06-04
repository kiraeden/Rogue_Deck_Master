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
	
    <div class="container">
		<div class="page-header">
			<?php 
				require_once "login.php";
					
				#login code for MySQL DB, login details set in "login.php" above.
				$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
				if(!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
				mysqli_select_db($db_server, $db_database)
					or die("Unable to select database: " . mysqli_error());
				
				$deckname = "Deck Name"; //placeholder for the actual deck name supplied for a give deck in the database
				$author = "Default";
				
				echo("<h1><span class='label label-default'>$deckname</span></h1>");
				echo("<h3><span class='label label-primary'>Author: $author</span></h3>");
			?>
		</div>
		
		<div class="col-sm-8 blog-main">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-xs-6 col-sm-6">
						<h4>Creatures (#)</h4>
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
					<div class="col-xs-4 col-sm-6">
						<h4>Spells (#)</h4>
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
					<div class="col-xs-8 col-sm-6">
						<h4>Lands (#)</h4>
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
					<div class="col-xs-4 col-sm-6">
						<h4>Sideboard</h4>
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
			</div>
			<div class="col-sm-4" style="padding-top: 2em; text-align: center;">
				<img src="Images/MTG_Card_Back.jpg" alt="default MTG card place holder">
				<div style="padding-top: 30px;">
					<p>
						<a href="add.php"><button type="button" class="btn btn-primary">Edit Deck</button></a>
						<a href="edit.php"><button type="button" class="btn btn-danger">Delete Deck</button></a>
					</p>
				</div>
			</div>

		</div>
		
		<div class="col-sm-3 col-sm-offset-1 blog-main">
				<div class="sidebar-module sidebar-module-inset">
					<h4>Note:</h4>
					<p>Want a quick way to install most of the applications I've named here? Try <a href="https://ninite.com">Ninite</a> and select everything you need! Provides a quick installation and setup without the software bloat!</p>
				</div>
				<div class="sidebar-module">
					<h2>Dynamic Tabs</h2>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#menu1">Standard</a></li>
						<li><a data-toggle="tab" href="#menu2">Other</a></li>
					</ul>

					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<h3>HOME</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
						<div id="menu1" class="tab-pane fade">
							<h3>Menu 1</h3>
							<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
						</div>
						<div id="menu2" class="tab-pane fade">
							<h3>Menu 2</h3>
							<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
						</div>
						<div id="menu3" class="tab-pane fade">
							<h3>Menu 3</h3>
							<p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
						</div>
					</div>
				</div>
				<div class="sidebar-module sidebar-module-inset">
					<h4>Disclaimer:</h4>
					<p>I do not own or claim to own any part of the programs listed here. These programs are listed here for the convenience of my clients.</p>
				</div>
				
		</div><!-- /.blog-sidebar -->
	  
		<div class="col-sm-8 blog-main" style="margin-bottom: 20px;">
			<fieldset disabled>
					<h2>Comments</h2>
					<textarea name="comment" rows="5" cols="5" class="form-control" type="text" placeholder="Comments Disabled"></textarea>
					</br>
					<input class="btn btn-primary" type="submit" name="submit" value="Submit">
			</fieldset>
			</br>
		</div>
		</br>
    </div> <!-- /container -->

	<div class="blog-footer">
        <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
		<p>&copy; Rogue Deckmaster 2015</p>
		<p>Magic: The Gathering&trade; is &copy; Wizards of the Coast 2015</p>

    </div>

    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
</html>