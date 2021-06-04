<?php 
require_once("header.php");
require_once("user_menu.php");
	$qBooks = "SELECT * FROM `books`";
	$books = $conn->query($qBooks);
	$fBooks = $books->fetchAll(PDO::FETCH_OBJ);
?>
<div class="container-fluid">
	<table class="table table-hover" style="background-color:#fff;border-radius:5px">
		<tr>
			<th>ID</th>
			<th>TITLE</th>
			<th>AUTHOR</th>
			<th>PUBLISHER</th>
			<th>PUBLISHED ON</th>
			<th>GENRE</th>
			<th>ISBN</th>
			<th>NUMBER OF PAGES</th>
			<th>NUMBER OF COPIES</th>
			<th>PICTURE</th>
		</tr>
	<?php
		foreach ($fBooks as $book) {
	?>
		<tr>
			<td>
				<?php echo $book->id;?>
			</td>
			<td>
				<?php 
				echo "<a href='rent-input.php?bookId=$book->id'>$book->Title</a> <br>"
				 ?>
						
			</td>
			<td>
				<?php echo $book->Author;?>
			</td>
			<td>
				<?php echo $book->Publisher;?>
			</td>
			<td>
				<?php echo $book->Published_on;?>
			</td>
			<td>
				<?php echo $book->Genre;?>
			</td>
			<td>
				<?php echo $book->ISBN;?>
			</td>
			<td>
				<?php echo $book->Number_of_pages;?>
			</td>
			<td>
				<?php echo $book->Number_of_copies;?>
			</td>
			<td>
				<a href="home.php?action=rent"><?php echo "<img src='". $book->Avatar ."' width='200'> <br>";?></a>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>	
			
