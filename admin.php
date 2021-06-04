<?php
	require_once("header.php");
?>
		<center> <h2>ADMIN HOME PAGE</h2></center>
<?php
	session_start();
	require_once("conn.php");
	if(!isset($_SESSION['id']) || $_SESSION['username'] != "admin"){
		header('Location:index.php');
	}
?>
<div class="container-fluid">
	<ul class="nav nav-tabs">
		<li role="presentation" <?php 
					if(!isset($_GET['action']) || $_GET['action']=="add_books"){
						echo "class='active'";
					}
			?>
			>
			<a href="admin.php?action=add_books">ADD BOOKS</a>
		</li>
		<li role="presentation" <?php 
				if(isset($_GET['action']) && $_GET['action']=="show_books"){
					echo "class='active'";
				}
			?>
			>
			<a href="admin.php?action=show_books">SHOW BOOKS</a>
		</li>
		<li role="presentation" <?php 
				if(isset($_GET['action']) && $_GET['action']=="search_books"){
					echo "class='active'";
				}
			?>
			>
			<a href="admin.php?action=search_books">SEARCH BOOKS</a>
		</li>
		<li role="presentation" <?php 
				if(isset($_GET['action']) && $_GET['action']=="add_genre"){
					echo "class='active'";
				}
			?>
			>
			<a href="admin.php?action=add_genre">ADD NEW GENRE</a>
		</li>
		<li role="presentation" <?php 
				if(isset($_GET['action']) && $_GET['action']=="add_publisher"){
					echo "class='active'";
				}
			?>
			>
			<a href="admin.php?action=add_publisher">ADD NEW PUBLISHER</a>
		</li>
		<li role="presentation" <?php 
				if(isset($_GET['action']) && $_GET['action']=="show_users"){
					echo "class='active'";
				}
			?>
			>
			<a href="admin.php?action=show_users">SHOW USERS</a>
		</li>
		<li role="presentation" <?php 
				if(isset($_GET['action']) && $_GET['action']=="show_user_admin"){
					echo "class='active'";
				}
			?>
			>
			<a href="admin.php?action=show_user_admin">EDIT AND/OR DELETE USER</a>
		</li>
		<li role="presentation" <?php 
				if(isset($_GET['action']) && $_GET['action']=="profile"){
					echo "class='active'";
				}
			?>
			>
			<a href="admin.php?action=profile">PROFILE</a>
		</li>
		<li role="presentation" >
			<a href="logout.php">LOG OUT</a>
		</li>
	</ul>	
</div>
<?php
	if(empty($_GET['action'])){
		include 'add_books.php';
	}else{
		$file = $_GET['action'] . ".php";
		include $file;
	} 
?>
