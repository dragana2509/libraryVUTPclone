<?php
	require_once("header.php");
    require_once("conn.php");
	session_start();
	$id_user =$_SESSION['id'];
?>
<?php
    $id_book = $_GET['bookId'];
   
	$q = "SELECT * FROM books WHERE `id`= :id_book";
	$stmt = $conn->prepare($q);
	$stmt->execute(array(
		":id_book"=>$id_book
	));
	$books = $stmt->fetch(PDO::FETCH_OBJ);
	$idBook = $books->id;

	$qdate = "SELECT * FROM rent";
	$stmtdate = $conn->prepare($qdate);
	$stmtdate->execute();
	$datecurrent = date('Y-m-d');
	$date_for_return = date('Y-m-d', strtotime("+1 months", strtotime($datecurrent)));
	
	if(isset($_POST['submit'])){
		$q2 = "SELECT SUM(number_rented_books) AS `total_rented` FROM `rent` WHERE `book_id`=:id_book";
		$stmt1=$conn->prepare($q2);
		$stmt1->execute(array(
			":id_book"=>$id_book
		));
		$resultRented = $stmt1->fetch();
		$alreadyRented = $resultRented[0];
		
		if($alreadyRented > $books->Number_of_copies){
			echo "<h4>You can't rent new books until you return the rented books!</h4>";
		} else{
			$newBooksToRent = $_POST['number_books'];
			
			if($newBooksToRent > $books->Number_of_copies - $alreadyRented){
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
									":avaliable_books"=>$books->Number_of_copies - ($newBooksToRent + $result12->Rented),
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
?>
<div class="container-fluid">
<div class="jumbotron">
	<div class="row">
<h3><a href="home.php?action=gallery_selection">Back to gallery</a></h3> 
<center><h3>RENT A BOOK</h3></center>
<form method="POST" action="rent-input.php?bookId=<?php echo $id_book?>" enctype="multipart/form-data"> 
    <div class="form-group">Book for rent:
		<input type="text" name="name_books" value="<?php echo $books->Title?>" class="form-control input-sm">
      
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