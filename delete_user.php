<div class="jumbotron">
<center><h3><b>DELETE USER</b></h3></center>
<?php	
	include_once("conn.php");
	include_once("header.php");
?>
<hr>
<?php
	$id_edit = $_GET['id'];
	$query = "SELECT * FROM `users` WHERE `id` = :id";
	$user = $conn->prepare($query);
	$user->execute([
		":id"=>$id_edit,
	]);	
	$u = $user->fetch(PDO::FETCH_OBJ);
		$username = $u->username;

		$queryUs = "SELECT user_id, number_rented_books FROM rent WHERE user_id=:user_id";
		$stmt = $conn->prepare($queryUs);
		$stmt->execute([
			":user_id"=>$id_edit
		]);
		$row = $stmt->fetch(PDO::FETCH_OBJ);
			
			if(isset($_POST['delete'])) {
				if($username == "admin"){
					echo "<h4>You can not delete admin!</h4> <br>";
					echo "<a href='admin.php?action=show_user_admin'>Back to list of users </a>";
				}elseif(!empty($row)){
						echo "<h4> You can not delete user $username, he/she has books to return! </h4> <br>";
						echo "<a href='admin.php?action=show_user_admin'>Back to list of users </a>";
				}else{
					$query = "DELETE FROM `users` WHERE id = $id_edit";
					$result = $conn->prepare($query);
					$result->execute(array(":id"=>$id_edit));
					echo "<h4>Successfully deleted user $username!</h4>";
					echo "<a href='admin.php?action=show_user_admin'>Back to list of users </a>";
				?>
			
				 <?php
				 die();
				}
			}elseif(isset($_POST['cancel'])) {
			 	?>
				 	<meta http-equiv="refresh" content="0;url='admin.php?action=show_user_admin'"/>
			<?php
			 die();
			 ?>
			<a href="admin.php?action=show_user_admin">List of users</a>
		<?php
			} else{
		?>
		<div class="panel panel-default">

			<form action="delete_user.php?id=<?php echo $id_edit; ?>" method="POST">
					<?php
					echo "<h2>Are you sure you want to delete user $username ?</h2>  <br>";
					?>
				<input type="submit" name="delete" class="btn btn-info" value="Delete"> <input type="submit" name="cancel" class="btn btn-info" value="Cancel">
			</form>
			</div>
<?php
	}
?>