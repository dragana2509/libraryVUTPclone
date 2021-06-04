<?php
	require_once("header.php");
	$id_user = $_SESSION['id'];
?>
<?php
	$qBook = "SELECT id, Title FROM books";
	$stmtBook = $conn->prepare($qBook);
	$stmtBook->execute();
	$books = $stmtBook->fetchAll();	

	$qdate = "SELECT * FROM rent";
	$stmtdate = $conn->prepare($qdate);
	$stmtdate->execute();
	
	$todayDate = date('Y-m-d');
	
	if(isset($_POST['submit'])){
    	$id_book = $_POST['cbx_books'];
		if($id_book == 0) {
			echo '<h4>You must select the book for return!</h4>';
		}else {
		$numberBooksForReturn = $_POST['number_books'];

		$qus = "SELECT b.*, r.* FROM `books` b
                RIGHT JOIN rent r ON b.id=r.book_id
                WHERE r.user_id=$id_user AND r.book_id=$id_book";
		$statementDate = $conn->prepare($qus);
		$statementDate->execute();
			$resultDate = $statementDate->fetch(PDO::FETCH_OBJ);
			// print_r($resultDate);
			if(!empty ($resultDate)) {
				$dateForReturn = $resultDate->date_for_return;
			}
	
		$query = "SELECT number_rented_books FROM rent WHERE book_id=:book_id AND user_id=:user_id";
		$statement = $conn->prepare($query);
		$statement->execute([
			":book_id"=>$id_book,
			":user_id"=>$id_user,
		]);
		$resultRentedBooks = $statement->fetch(PDO::FETCH_OBJ);
		
		$query1 = "SELECT Number_of_copies, Rented, Avaliable_books FROM books WHERE id=:book_id";
		$statement1 = $conn->prepare($query1);
		$statement1->execute([
			":book_id"=>$id_book
		]);
		$resultRentedBooks1 = $statement1->fetch(PDO::FETCH_OBJ);

if($resultRentedBooks1 != false && $resultRentedBooks == false){
	echo "<h4>You have not rented this book!</h4>";
	}else{
	$currentlyRented = $resultRentedBooks->number_rented_books;
	$currentlyRented1 = $resultRentedBooks1->Rented;
			// $resultDateReturn = $resultRentedBooks->date_for_return;
				if($todayDate > $dateForReturn){
					echo " <h4>You have exceeded the date for returning the book <br> and you can not return the books,
							<a href='index.php?action=contact'>please contact admin!</a></h4>";
				}else{
	if ($numberBooksForReturn > $currentlyRented1 && $numberBooksForReturn > $currentlyRented){ 
		echo "You can not return more books than you rented!";
				}elseif($numberBooksForReturn < $currentlyRented1){
							$qRent1 = "UPDATE books
											SET `Rented` =:rented_books,
											`Avaliable_books`=:avaliable_books
											WHERE id =$id_book"; 
							$params1 = [
								':rented_books'=>($currentlyRented1 - $numberBooksForReturn),
								':avaliable_books'=>$resultRentedBooks1->Number_of_copies -  ($currentlyRented1 - $numberBooksForReturn)	
							];
							$stmt1 = $conn->prepare($qRent1);
							$stmt1->execute($params1);


							$qRent = "UPDATE rent
											SET `number_rented_books` =:number_rented_books
											WHERE user_id =:user_id
											AND book_id =:book_id"; 
							$params = [
								':number_rented_books'=>($currentlyRented - $numberBooksForReturn),
								':user_id'=>$id_user,
								':book_id'=>$id_book
							];
							$stmt = $conn->prepare($qRent);
							$stmt->execute($params);
							echo "<h4>Thank you, you have " . ($currentlyRented - $numberBooksForReturn) . " more book(s) to return!</h4>";
					}else{
						$qRent2 =  "UPDATE books
										SET `Rented` =:rented_books,
										`Avaliable_books`=:avaliable_books
										WHERE id =$id_book"; 
						$params2 = [
							':rented_books'=>($currentlyRented1 - $numberBooksForReturn),
							':avaliable_books'=>$resultRentedBooks1->Number_of_copies -  ($currentlyRented1 - $numberBooksForReturn)
							
						];
						$stmt2 = $conn->prepare($qRent2);
						$stmt2->execute($params2);


						$qRent = "DELETE FROM rent
						WHERE user_id =:user_id
										AND book_id =:book_id"; 
						$params =[
							':user_id'=>$id_user,
							':book_id'=>$id_book,
						];
						$stmt = $conn->prepare($qRent);
						$stmt->execute($params);
						echo "<h4>Thank you for returning all the books!</h4>";
					} 
	}
}
}

}


?>
<div class="container-fluid">
	<div class="jumbotron">
		<div class="row">
	<center><h3>RETURN A BOOK</h3></center>
		<form method="POST" action="home.php?action=return" enctype="multipart/form-data"> 
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
					<input type="submit" name="submit" class="btn btn-info" value="Return books">
				</div>
		</form>
		</div>
	</div>
</div>
<?php
require_once("recommended1.php");
require_once("footer.php");
?>