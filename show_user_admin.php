<center><h3>EDIT AND/OR DELETE USER</h3></center>
<?php
	require_once("conn.php");
	require_once("header.php");

		$qUs = "SELECT * FROM `users`";
		$user = $conn->query($qUs);
		$fUs = $user->fetchAll(PDO::FETCH_OBJ);
?>
<div class="container-fluid">
			<table class="table table-hover" style="background-color:#fff;border-radius:5px;">
				<tr>
					<th>ID</th>
					<th>USERNAME</th>
					<th>NAME</th>
					<th>SURNAME</th>
					<th>EMAIL</th>
					<th>EDIT</th>
					<th>DELETE</th>
				</tr>
				<?php
					foreach ($fUs as $u) {
					?>
						<tr>
							<td>
								<?php echo $u->id;?>
							</td>
							<td>
								<?php echo $u->username;?>
							</td>
							<td>
								<?php echo $u->Name;?>
							</td>
							<td>
								<?php echo $u->Surname;?>
							</td>
							<td>
								<?php echo $u->eMail;?>
							</td>
							<td>
								<?php
									echo "<a href='edit_user.php?id=$u->id'>Edit</a> <br>";
								?>
							</td>
							<td>
								<?php
									echo "<a href='delete_user.php?id=$u->id'>Delete</a> <br>";
								?>
							</td>
						</tr>
				<?php
					}
				?>
			</table>
		</div>
