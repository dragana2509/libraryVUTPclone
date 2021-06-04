<center><h3>ADD BOOKS INTO LIBRARY</h3></center>
<?php
	require_once("header.php");
		$statement = $conn->prepare("SELECT id_publisher, Publisher FROM publisher ");
		$statement->execute();
		$publishers = $statement->fetchAll();

		$stmt = $conn->prepare("SELECT * FROM genre");
		$stmt->execute();
		$genres = $stmt->fetchAll();

		$author = filter_input(INPUT_POST,'author',FILTER_SANITIZE_STRING);
	$err = "";
	if(isset($_POST['submit_add'])){
		if(!empty($_POST['isbn'])){
			$Isbn = "SELECT * FROM `books` WHERE `ISBN`= :isbn";
			$isbn= $conn->prepare($Isbn);
			$isbn->execute(array(
						':isbn'=>$_POST['isbn']
							));
			
			if($isbn->rowCount()){
				$err .="ISBN already exists, you can not add book with same ISBN! <br>";
			} else {
				$isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_NUMBER_INT);
			}
		} 
		$publisher_id=filter_input(INPUT_POST,'cbx_publisher',FILTER_SANITIZE_STRING);
		$genre=filter_input(INPUT_POST,'cbx_genre',FILTER_SANITIZE_STRING);
	
		if(!empty($_POST['title'])){
			$title = "SELECT * FROM `books` WHERE `Title`= :title";
			$users = $conn->prepare($title);
			$users->execute(array(
						':title' => $_POST['title']
							));
			$title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING);
		} else{
			$err .="- You must enter title of the book! <br>";
		}	
		if(empty($_POST['author'])){
			$err .="- You must enter author of the book! <br>";
		}else{
            if (!preg_match("/^[a-zA-Z-' ]*$/",$author)) {
                $err .= "Author->Only letters and white space allowed <br>";
            }else{
				$queryAuthor = "SELECT * FROM `books` WHERE `Author`= :author";
				$users = $conn->prepare($queryAuthor);
				$users->execute(array(
							':author' => $_POST['author']
								));
		} 
	}
		if(!empty($_POST['published_on'])){
			$published_on = "SELECT * FROM `books` WHERE `Published_on`= :published_on";
			$users = $conn->prepare($published_on);
			$users->execute(array(
						':published_on' => $_POST['published_on']
							));
			$published_on = filter_input(INPUT_POST,'published_on',FILTER_SANITIZE_STRING);
		} else{
			$err .="- You must enter the release date of the book! <br>";
		}	
		if(!empty($_POST['number_of_pages'])){
			$number_of_pages = "SELECT * FROM `books` WHERE `Number_of_pages`= :number_of_pages";
			$users = $conn->prepare($number_of_pages);
			$users->execute(array(
						':number_of_pages' => $_POST['number_of_pages']
							));
			$number_of_pages = filter_input(INPUT_POST, 'number_of_pages', FILTER_SANITIZE_NUMBER_INT);
		} else{
			$err .="- You must enter the number of pages! <br>";
		}	
		if(!empty($_POST['number_of_copies'])){
			$number_of_copies = "SELECT * FROM `books` WHERE `Number_of_copies`= :number_of_copies";
			$users = $conn->prepare($number_of_copies);
			$users->execute(array(
						':number_of_copies' => $_POST['number_of_copies']
							));
			$number_of_copies = filter_input(INPUT_POST, 'number_of_copies', FILTER_SANITIZE_NUMBER_INT);
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
		}
	}
	
	?>
<div class="container-fluid">
<div class="jumbotron">	
		<form method="POST", action="admin.php?action=add_books" enctype="multipart/form-data"> 
	<center><table class="table table-striped" style="width:auto;"></center>
			<tr>
				<td>
					Title of the book:
				</td>
				<td>
					<input type="text" name="title"/>
				</td>
			</tr>
			<tr>
				<td>
					Author:
				</td>
				<td>
					<input style="text-transform:capitalize;" type="text" name="author"/>
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
					<input type="date" name="published_on"/>
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
					ISBN:
				</td>
				<td>
					<input type="number" name="isbn"/>
				</td>
			</tr>
			<tr>
				<td>
					Number of pages:
				</td>
				<td>
					<input type="number" name="number_of_pages"/>
				</td>
			</tr>
			<tr>
				<td>
					Number of copies:
				</td>
				<td>
					<input type="number" name="number_of_copies"/>
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
					<input type="submit" name="submit_add" class="btn btn-info" value="Add book into library" />
				</td>
			</tr>
		</table>
	</form>
</div>





	