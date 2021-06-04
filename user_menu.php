<ul class="nav nav-tabs">
	<li role="presentation"
		<?php 
			if(!isset($_GET['action']) || $_GET['action']=="gallery_selection"){
				echo "class='active'";
			}
		?>
	>
		<a href="home.php?action=gallery_selection">Gallery and selection of books</a>
	</li>
	<li role="presentation"
		<?php 
			if(isset($_GET['action']) AND $_GET['action']=="rent"){
				echo "class='active'";
			}
		 ?>
	>
		<a href="home.php?action=rent">Rent a book</a>
	</li>
	<li role="presentation"
		<?php 
			if(isset($_GET['action']) AND $_GET['action']=="return"){
				echo "class='active'";
			}
		 ?>
	>
		<a href="home.php?action=return">Return book</a>
	</li>
	<li role="presentation"
		<?php 
			if(isset($_GET['action']) AND $_GET['action']=="user_profile"){
				echo "class='active'";
			}
		 ?>
	>
		<a href="home.php?action=user_profile">My profile</a>
	</li>
	<li role="presentation"
		<?php 
			if(isset($_GET['action']) AND $_GET['action']=="search"){
				echo "class='active'";
			}
		 ?>
	>
		<a href="home.php?action=search">Search</a>
	</li>
	<li role="presentation">
		<a href="logout.php">Log out</a>
	</li>
</ul>