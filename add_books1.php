<center><h3>ADD BOOKS INTO LIBRARY</h3></center>
<?php
$z = "3";
	require_once("header.php");
	if(!empty($_POST['isbn'])){
		$Isbn = "SELECT * FROM `books` WHERE `ISBN`= :isbn";
		$isbn= $conn->prepare($Isbn);
		$isbn->execute(array(
					':isbn'=>$_POST['isbn']
						));
		$resultbooks = $isbn->fetch(PDO::FETCH_OBJ);
		if($isbn->rowCount()){
			$book = $resultbooks->ISBN;
		} 
	} 
		$statement = $conn->prepare("SELECT id_publisher, Publisher FROM publisher ");
		$statement->execute();
		$publishers = $statement->fetchAll();

		$stmt = $conn->prepare("SELECT * FROM genre");
		$stmt->execute();
		$genres = $stmt->fetchAll();

	$err = "";
	if(isset($_POST['submit_add_new'])){
		// if(!empty($_POST['isbn'])){
		// 	$Isbn = "SELECT * FROM `books` WHERE `ISBN`= :isbn";
		// 	$isbn= $conn->prepare($Isbn);
		// 	$isbn->execute(array(
		// 				':isbn'=>$_POST['isbn']
		// 					));
			
		// 	if($isbn->rowCount()){
		// 		$err .="ISBN already exists, you can not add book with same ISBN! <br>";
		// 	} else {
		// 		$isbn = $_POST['isbn'];
		// 	}
		// } 
		$publisher_id=$_POST['cbx_publisher'];
		$genre=$_POST['cbx_genre'];
	
		if(!empty($_POST['title'])){
			$title = "SELECT * FROM `books` WHERE `Title`= :title";
			$users = $conn->prepare($title);
			$users->execute(array(
						':title' => $_POST['title']
							));
			$title = $_POST['title'];
		} else{
			$err .="- You must enter title of the book! <br>";
		}	
		if(!empty($_POST['author'])){
			$author = "SELECT * FROM `books` WHERE `Author`= :author";
			$users = $conn->prepare($author);
			$users->execute(array(
						':author' => $_POST['author']
							));
			$author = $_POST['author'];
		} else{
			$err .="- You must enter the author of the book! <br>";
		}
		if(!empty($_POST['published_on'])){
			$published_on = "SELECT * FROM `books` WHERE `Published_on`= :published_on";
			$users = $conn->prepare($published_on);
			$users->execute(array(
						':published_on' => $_POST['published_on']
							));
			$published_on = $_POST['published_on'];
		} else{
			$err .="- You must enter the release date of the book! <br>";
		}	
		if(!empty($_POST['isbn'])){
			$isbn = "SELECT * FROM `books` WHERE `ISBN`= :isbn";
			$users = $conn->prepare($isbn);
			$users->execute(array(
						':isbn' => $_POST['isbn']
							));
			$isbn = $_POST['isbn'];
		} else{
			$err .="- You must enter ISBN of the book! <br>";
		}
		if(!empty($_POST['number_of_pages'])){
			$number_of_pages = "SELECT * FROM `books` WHERE `Number_of_pages`= :number_of_pages";
			$users = $conn->prepare($number_of_pages);
			$users->execute(array(
						':number_of_pages' => $_POST['number_of_pages']
							));
			$number_of_pages = $_POST['number_of_pages'];
		} else{
			$err .="- You must enter the number of pages! <br>";
		}	
		if(!empty($_POST['number_of_copies'])){
			$number_of_copies = "SELECT * FROM `books` WHERE `Number_of_copies`= :number_of_copies";
			$users = $conn->prepare($number_of_copies);
			$users->execute(array(
						':number_of_copies' => $_POST['number_of_copies']
							));
			$number_of_copies = $_POST['number_of_copies'];
		} else{
			$err .="- You must enter the number of copies! <br>";
		}	
		if(!empty($_FILES['avatar']['tmp_name'])){
			// detektovanje imena slike i privremeni naziv
			$folder = "Pictures_add_books/";
			$folder = $folder . basename($_FILES['avatar']['name']);
			$tmpName = $_FILES['avatar']['tmp_name'];
			$part_name = pathinfo($_FILES['avatar']['name']);
			$extension = $part_name['extension'];
			//slucajni naziv slike
			$first =rand(1,100000);
			$second =rand(1,100000);
			$third =rand(1,100000);
			$random_name = $first ."-" .$second . "-" .$third .".".$extension;
			$final = "Pictures_add_books/" .$random_name;
			//$err .=$final;
		} else{
			$err .="- Picture of the book is not added! <br>";
		}
		if($err <> ""){
			?>
			<h4>
				<?php
				echo $err ;
				?>
			</h4>
			<?php
		} else {
			if(move_uploaded_file($tmpName, $final)){
					//ako je slika uspesno ucitana na sever
					$query = "INSERT INTO `books` 
							SET `Title`=:title,
							 `Author` =:author,
							 `Publisher` = :publisher,
							 `Published_on`=:published_on,
							 `Genre`=:genre,
							 `ISBN`=:isbn,
							 `Number_of_pages`=:number_of_pages,
							 `Number_of_copies`=:number_of_copies,
							 `Avaliable_books` =:avaliable_books,
							 `Avatar`=:avatar
					";
					$u = $conn->prepare($query);
					$u->execute(array(
							':title'=>$title,
							':author'=>$author,
							':publisher'=>$publisher_id,
							':published_on'=>$published_on,
							':genre'=>$genre,
							':isbn'=>$isbn,
							':number_of_pages'=>$number_of_pages,
							':number_of_copies'=>$number_of_copies,
							':avaliable_books' =>$number_of_copies,
							':avatar'=>$final
					));
				} else{
					//ako slika nije ucitana na sever
					$query = "INSERT INTO `books` 
							SET `Title`=:title,
							 `Author`=:author,
							 `Publisher`=:publisher,
							 `Published_on`=:published_on,
							 `Genre`=:genre,
							 `ISBN`=:isbn,
							 `Number_of_pages`=:number_of_pages,
							 `Number_of_copies`=:number_of_copies,
							 `Avaliable_books` =:avaliable_books,
							 `Avatar`=:avatar
					";
					$u = $conn->prepare($query);
					$u->execute(array(
                            ':title'=>$title,
                            ':author'=>$author,
                            ':publisher'=>$publisher_id,
                            ':published_on'=>$published_on,
                            ':genre'=>$genre,
                            ':isbn'=>$isbn,
                            ':number_of_pages'=>$number_of_pages,
                            ':number_of_copies'=>$number_of_copies,
							':avaliable_books' =>$number_of_copies,
							':avatar'=>"Pictures_add_books/default.png"
					));
				}
				echo "<h4>Book successfully added into library!</h4>";
				// header("Location:admin.php?action=add_books");
		}
	}
	
	?>
<div class="container-fluid">
<div class="jumbotron">	
		<form method="POST", action="admin.php?action=add_books1" enctype="multipart/form-data"> 
	<center><table class="table table-striped" style="width:auto;"></center>
			<tr>
				<td>
					ISBN:
				</td>
				<td>
					<input id="isbn" type="text" name="isbn" onblur="newFunction()"/>
				</td>
			</tr>
			<tr>
				<td>
					Title of the book:
				</td>
				<td>
					<input id="title" type="text" name="title"/>
				</td>
			</tr>
			<tr>
				<td>
					Author:
				</td>
				<td>
					<input id="author" type="text" name="author"/>
				</td>
			</tr>
			<tr>
				<td>
					Publisher:
				</td>
				<td>
					<select id="cbx_publisher" name="cbx_publisher">
						<option value="0">Choose the publisher</option>
						<?php foreach ($publishers as $publisher){ ?>
							<option value="<?php echo $publisher['Publisher'];  ?>"><?php echo $publisher['Publisher']; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Published on:
				</td>
				<td>
					<input id="published_on" type="date" name="published_on"/>
				</td>
			</tr>
			<tr>
				<td>
					Genre:
				</td>
				<td>
					<select id="cbx_genre" name="cbx_genre">
					<option value="0">Choose the genre</option>
					<?php foreach ($genres as $genre){ ?>
						<option value="<?php echo $genre['Genre'];  ?>"><?php echo $genre['Genre']; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
					Number of pages:
				</td>
				<td>
					<input id="number_of_pages" type="number" name="number_of_pages"/>
				</td>
			</tr>
			<tr>
				<td>
					Number of copies:
				</td>
				<td>
					<input id="number_of_copies" type="number" name="number_of_copies"/>
				</td>
			</tr>
			<tr>
				<td>
					Picture of the book:
				</td>
				<td>
					<input type="file" name="avatar" id="avatar"/>
				</td>
			</tr>
			<tr>
				<td>
					<input id="submit_add_new" type="submit" name="submit_add_new" class="btn btn-info" value="Add new book into library"/>
				</td>
			</tr>
			<tr>
				<td>
					<input id="submit_update" type="submit" name="submit_update" class="btn btn-info" value="Update books in library" disabled="true"/>
				</td>
			</tr>
		</table>
	</form>
</div>

<script language="JavaScript" type="text/javascript">
function myFunction() {
  document.getElementById("title").disabled = true;
  document.getElementById("author").disabled = true;
  document.getElementById("cbx_publisher").disabled = true;
  document.getElementById("published_on").disabled = true;
  document.getElementById("cbx_genre").disabled = true;
  document.getElementById("number_of_pages").disabled = true;
  document.getElementById("avatar").disabled = true;
}
function newFunction() {
	var x = document.getElementById("isbn").value;
	// var y = Number(x);
	
    if (x === "<?php echo $book?>"){
        myFunction();
    }
}
</script>




	