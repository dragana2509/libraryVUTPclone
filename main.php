<?php
	if(isset($_GET['action'])) {
		$file = $_GET['action'] . ".php";
		if(file_exists($file)) {
			include_once($file);
		} else{
?>
		<div class="alert-alert-warning">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>ERROR</strong> - Page does not exist !!!! <br> Please go back to <a href ="index.php" class="alert-link" >home page </a>
		</div>
	<?php
		}
	} else{
	?>
		<div style="margin-top:10px;" class="jumbotron">
			<h2>Home page</h2>
			<p>Welcome to online library. If you want to use our services, please <a style="text-decoration: underline; color: #5bc0de;" href="index.php?action=register">sign in</a> 
			 </p>
			 <h3>About us</h3>
<p style="font-size:20px;">One web page for every book ever published. It's a lofty but achievable goal.

To build Open Library, we need hundreds of millions of book records, 
a wiki interface, and lots of people who are willing to contribute their time and effort to building the site.
To date, we have gathered over 20 million records from a variety of large catalogs as well as single contributions, 
with more on the way.</p>
<?php
include_once('carousel.php');
?>
		</div>
	<?php
	}
	