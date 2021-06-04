<div class="jumbotron">
<center><h3><b>UPDATE RENTED BOOKS</b></h3></center>
<?php	
	include_once("conn.php");
	include_once("header.php");
    
?>
<hr>
<?php
    $id_user = $_GET['userId'];
    $query = "SELECT * FROM `users` WHERE `id` = :id";
	$user = $conn->prepare($query);
	$user->execute([
		":id"=>$id_user,
	]);	
    
    $qus = "SELECT b.*, r.* FROM `books` b
            RIGHT JOIN rent r ON b.id=r.book_id
            WHERE r.user_id=$id_user";
    $statement = $conn->prepare($qus);
    $statement->execute();
    $resultUser = $statement->fetch(PDO::FETCH_OBJ);
    $id_book = $resultUser->book_id;
    

    $qus = "SELECT b.*, r.* FROM `books` b
            RIGHT JOIN rent r ON b.id=r.book_id
            WHERE b.id=$id_book";
    $statement = $conn->prepare($qus);
    $statement->execute();
    $resultUser = $statement->fetch(PDO::FETCH_OBJ);
    $id_book1 = $resultUser->id;
   
    
    $qus = "SELECT u.*, b.*, r.user_id, r.book_id, r.number_rented_books, r.date_rent, r.date_for_return FROM `users` u
            LEFT JOIN rent r ON u.id=r.user_id
            LEFT JOIN books b
            ON b.id = r.book_id WHERE r.user_id=$id_user 
                                AND r.book_id=$id_book";
    $statement = $conn->prepare($qus);
    $statement->execute();
    $resultUser = $statement->fetch(PDO::FETCH_OBJ);

	$queryUs = "SELECT user_id, number_rented_books FROM rent WHERE user_id=:user_id";
	$stmt = $conn->prepare($queryUs);
	$stmt->execute([
		":user_id"=>$id_user
	]);
    $resultRentedBooks = $stmt->fetch(PDO::FETCH_OBJ);
    $rentedBooks = $resultRentedBooks->number_rented_books;
    
    $query1 = "SELECT Number_of_copies, Rented, Avaliable_books FROM books WHERE id=:book_id";
	$statement1 = $conn->prepare($query1);
	$statement1->execute([
		":book_id"=>$id_book1
	]);
	$resultRentedBooks1 = $statement1->fetch(PDO::FETCH_OBJ);
    $currentlyRented1 = $resultRentedBooks1->Rented;
			
	        if(isset($_POST['update'])) {
				    $query = "DELETE FROM rent
                                WHERE user_id =:user_id
                                AND book_id =:book_id"; 
                    $params =[
                        ':user_id'=>$id_user,
                        ':book_id'=>$id_book,
                    ];
                    $result = $conn->prepare($query);
                    $result->execute($params);

                    $query1 = "UPDATE books
							    SET `Rented` =:rented_books,
									`Avaliable_books`=:avaliable_books
							    WHERE id =$id_book1"; 
					$params1 = [
						':rented_books'=>($currentlyRented1 - $rentedBooks),
						':avaliable_books'=>$resultRentedBooks1->Number_of_copies -  ($currentlyRented1 - $rentedBooks)
							
					];
					$result1 = $conn->prepare($query1);
					$result1->execute($params1);
			?>
				<meta http-equiv="refresh" content="0;url='admin.php?action=show_users'"/>
			<?php
			    die();
				
			}else{
		 
		?>
		<div class="panel panel-default">

			<form action="update_books.php?userId=<?php echo $id_user; ?>" method="POST">
					<?php
					echo "<h2>Update $resultUser->username rented books?</h2>  <br>";
					?>
				<input type="submit" name="update" class="btn btn-info" value="Update">
			</form>
			</div>
<?php
	}
?>