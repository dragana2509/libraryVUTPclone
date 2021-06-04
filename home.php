<?php
	session_start();
	require_once("conn.php");
	require_once("header.php");
	if(!isset($_SESSION['username']) || $_SESSION['username'] == 'admin') {
		header('Location:index.php');
	}
?>
	<div class="container-fluid">
			<div class="row">
				<div class="col-md-12" style="margin-bottom: 10px;">
					<center><h1>LIBRARY</h1></center>
	<?php
		echo "You are logged in as:";
			$qUs = "SELECT * FROM `users` WHERE `id` = :user";
			$profile = $conn->prepare($qUs);
			$profile->execute(array(
				':user'=>$_SESSION['id'] 
			));
				if(isset($_SESSION['id'])){
					if($profile->rowCount()){
						$fetchProf = $profile->fetchAll(PDO::FETCH_OBJ);
							foreach ($fetchProf as $p) {
								echo "<h3>". $p->Name ." ".$p->Surname ."</h3>";
								echo "<img src='". $p->avatar ."' width='70' . ' height='70'> <br> <br>";		
							}
					} 
						require_once("user_menu.php");
				}
	?>	
				</div>
			</div>
	<div class="row">
		<?php 
			if(empty($_GET['action'])){
				include 'gallery_selection.php';
			} else{
				$file = $_GET['action'] . ".php";
				include $file;
			}
		?>
	</div>
<?php 
require_once("footer.php");
 ?>