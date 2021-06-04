<center><h3>SHOW USERS FROM LIBRARY</h3></center>
<?php	
	$qus = "SELECT u.*, b.*, r.user_id, r.book_id, r.number_rented_books, r.date_rent, r.date_for_return FROM `users` u
			LEFT JOIN rent r ON u.id=r.user_id
			LEFT JOIN books b
			ON b.id = r.book_id WHERE r.number_rented_books>0";
	$statement = $conn->prepare($qus);
	$statement->execute();
?>

<div class="container-fluid">
	<table class="table table-hover" style="background-color:#fff;border-radius:5px;">
		<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>NAME</th>
			<th>SURNAME</th>
			<th>EMAIL</th>
			<th>BOOK NAME</th>
			<th>RENTED BOOKS</th>
			<th>DATE RENTED</th>
			<th>DATE FOR RETURN</th>
			<th></th>
		</tr>
<?php
	while ($u = $statement->fetch(PDO::FETCH_OBJ)) {
		$todayDate= date('Y-m-d');
		$dateReturn=$u->date_for_return;
		
		if($dateReturn <= $todayDate) {
			$tdStyle='color:red;';
		}else{
			$tdStyle='color:green;';
		}
?>
	<tr>
		<td>
			<a href="admin.php?action=profile&pid=
				<?php echo $u->user_id; ?>">
				<?php echo $u->user_id;?>
			</a>
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
			<?php echo $u->Title;?>
		</td>
		<td>
			<?php echo $u->number_rented_books;?>
		</td>
		<td>
			<?php echo $u->date_rent;?>
		</td>
		<td style=<?php echo $tdStyle;?>>
			<?php echo $dateReturn;?>
		</td>
		<td>
		<?php
			if($dateReturn <= $todayDate) {
				?>
				<a href="update_books.php?userId=<?php echo $u->user_id?>">
					<button>update</button>
				</a>
				<?php
			}else{
				?>
					<button disabled="true">update</button>
				<?php
		}
		?>
		</td>
	</tr>
<?php
	}
?>
</table>
</div>

