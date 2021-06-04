<?php
	require_once("header.php");
	$id_user =$_SESSION['id'];
?>
<?php
	$q = "SELECT id, Title FROM books ";
	$stmt = $conn->prepare($q);
	$stmt->execute();
	$books = $stmt->fetchAll();
	
	$qdate = "SELECT * FROM rent";
	$stmtdate = $conn->prepare($qdate);
	$stmtdate->execute();
	
	$datecurrent = date('Y-m-d');
	$date_for_return = date('Y-m-d', strtotime("+1 months", strtotime($datecurrent)));
    
	if(isset($_POST['submit'])){
    	$id_book = $_POST['cbx_books'];
		if($id_book == 0) {
			echo '<h4>You must select the book for rent!</h4>';
		}else {
		$q = "SELECT id, Title, Publisher, Number_of_copies, Rented, Avaliable_books FROM books WHERE id=:id_book"; 
		$qData = [
			":id_book"=>$id_book
		];
		$stmt = $conn->prepare($q);
		$stmt->execute($qData);
		$bookInfo = $stmt->fetch(PDO::FETCH_OBJ);

		$q2 = "SELECT SUM(number_rented_books) AS `total_rented` FROM `rent` WHERE `book_id`=:id_book";
		$stmt1=$conn->prepare($q2);
		$stmt1->execute(array(
			":id_book"=>$id_book
		));
		$resultRented = $stmt1->fetch();
		$alreadyRented = $resultRented[0];
		
		if($alreadyRented > $bookInfo->Number_of_copies){
			echo "<h4>You can't rent new books until you return the rented books!</h4>";
		} else{
			$newBooksToRent = $_POST['number_books'];
			
			if($newBooksToRent > $bookInfo->Number_of_copies - $alreadyRented){
				echo "<h4>There are not enough avaliabe books!</h4>";

			} else{
				$q1 = "SELECT `number_rented_books` FROM `rent` WHERE `user_id`= :user_id AND `book_id`=:book_id";
				$statement = $conn->prepare($q1);
				$statement->execute(array(
					":user_id"=>$id_user,
					":book_id"=>$id_book
				)); 
				$result = $statement->fetch(PDO::FETCH_OBJ);

				$q12 = "SELECT Rented, Avaliable_books FROM `books` WHERE `id`= :book_id";
				$statement12 = $conn->prepare($q12);
				$statement12->execute(array(
					
					":book_id"=>$id_book
				)); 
				$result12 = $statement12->fetch(PDO::FETCH_OBJ);
				
				
				if($result != false){
					$query = "UPDATE rent SET `number_rented_books` =:new_rent_number, `date_rent`=:date_rent
										WHERE `user_id`= :user_id 
										AND `book_id`=:book_id";
										$statement = $conn->prepare($query);
						$statement->execute(array(
									":new_rent_number"=>$newBooksToRent + $result->number_rented_books,
									":date_rent"=>$datecurrent,
									":user_id"=>$id_user,
									":book_id"=>$id_book
								));
				} else{
					$query = "INSERT INTO rent SET 
										`number_rented_books` =:new_rent_number,
										`user_id`= :user_id,
										`book_id`=:book_id,
										`date_rent`=:date_rent,
										`date_for_return`=:date_for_return";
					$statement = $conn->prepare($query);
					$statement->execute(array(
								":new_rent_number"=>$newBooksToRent,
								":user_id"=>$id_user,
								":book_id"=>$id_book,
								":date_rent"=>$datecurrent,
								":date_for_return"=>$date_for_return
					));
				}
				if($result12 != false){
					$query123 = "UPDATE books SET `Rented` =:rented, Avaliable_books=:avaliable_books
										WHERE  `id`=:book_id";
										$statement123 = $conn->prepare($query123);
						$statement123->execute(array(
									":rented"=>$newBooksToRent + $result12->Rented,
									":avaliable_books"=>$bookInfo->Number_of_copies - $newBooksToRent - $result12->Rented,
									":book_id"=>$id_book
								));
				} else{
					$query1234 = "INSERT INTO books SET 
										`Rented` =:rented,
										`id`=:book_id";
					$statement1234 = $conn->prepare($query1234);
					$statement1234->execute(array(
								":rented"=>$newBooksToRent,
								
								":book_id"=>$id_book
					));
				}
				echo "<h4>Rented successfully!</h4>";
		}
	}
}
	}	
?>
<div class="container-fluid">
<div class="jumbotron">
	<div class="row">
<center><h3>RENT A BOOK</h3></center>
<form method="POST" action="home.php?action=rent" enctype="multipart/form-data"> 
	<div class="form-group">Choose the book:
		<select id="cbx_books" name="cbx_books">
			<option value="0">Choose the book</option>
			<?php foreach ($books as $book){ ?>
				<option value="<?php echo $book['id']; ?>"><?php echo $book['Title']; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">How many books:
		<input type="text" name="number_books" value="0"> <br>
		<input type="submit" name="submit" class="btn btn-info" value="Rent a book">
	</div>
</form>
	</div>
</div>
</div>
<?php
require_once("recommended1.php");
require_once("footer.php");
?>