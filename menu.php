<ul class="nav nav-tabs">
	<li role="presentation" 
		<?php 
			if(!isset($_GET['action'])){
				echo "class='active'";
			}
		 ?>
	 >
		<a href="index.php">Home</a>
	</li>
	<li role="presentation"
		<?php 
			if(isset($_GET['action']) and $_GET['action']=="register"){
				echo "class='active'";
			}
		 ?>
	>
		<a href="index.php?action=register">Registration</a>
	</li>
</ul>
