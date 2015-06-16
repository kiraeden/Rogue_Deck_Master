	<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" > <!-- add a piece of PHP in this line to hide the navbar when a user isn't logged in: (php) if(!$login){echo("style='display:none;'")}-->
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="Index.html">Rogue Deck Master</a> <!-- need to come up with a good name for this site -->
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li id="index"><a href="index.php">Home</a></li>
				<li id="about"><a href="about.php">About</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Collection<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li id="view_cards"><a href="collection.php">My Collection</a></li>
						<li id="add_cards"><a href="add_cards.php">Add Cards</a></li>
						<li id="edit_cards"><a href="edit_cards.php">Edit Collection</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Decks<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li id="view_decks"><a href="view_decks.php">View Your Decks</a></li>
						<li id="add_deck"><a href="add_deck.php">Add Deck</a></li>
						<li id="edit_decks"><a href="edit_deck.php">Edit Decks</a></li>
					</ul>
				</li>
				<li id="forum"><a href="#">Forum</a></li>
				<li id="contact"><a href="#">Contact</a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>