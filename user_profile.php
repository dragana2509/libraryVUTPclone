<center><h3>PROFILE</h3></center>
<?php	
    $id_user = $_SESSION['id'];
	$query = "SELECT * FROM `users`  WHERE `id` = $id_user";
	$user = $conn->query($query);
	$u = $user->fetch(PDO::FETCH_OBJ);
	
    $qus = "SELECT u.*, b.*, r.* FROM `users` u
                RIGHT JOIN rent r ON u.id=r.user_id
                RIGHT JOIN books b
                ON b.id = r.book_id WHERE r.user_id=$id_user";
    $statement = $conn->prepare($qus);
    $statement->execute();
    ?>
    <div class="container-fluid">
        <table class="table table-hover" style="background-color:#fff;border-radius:5px;">
            <tr>
                <th>BOOK</th>
                <th>RENTED BOOKS</th>
                <th>DATE RENTED</th>
                <th>DATE FOR RETURN</th>
            </tr>
    <?php
        while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
            $todayDate= date('Y-m-d');
		    $dateReturn=$row->date_for_return;

		if($dateReturn <= $todayDate) {
			$tdStyle='color:red;';
		}else{
			$tdStyle='color:green;';
		}
    ?>
        <tr>
            <td>
                <?php echo $row->Title;?>
            </td>
            <td>
                <?php echo $row->number_rented_books;?>
            </td>
            <td>
                <?php echo $row->date_rent;?>
            </td>
            <td style=<?php echo $tdStyle;?>>
                <?php echo $row->date_for_return;?>
            </td>
        </tr>
    <?php
        }
    
    ?>
    </table>
</div>

