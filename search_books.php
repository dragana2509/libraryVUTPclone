<?php
require_once("header.php");
?>
<br>
<div class="container-fluid">
<div class="jumbotron">
	<hr>
		<center><h2>Search for the book</h2></center> <br><br>
	<hr>
		<form method="post" action="admin.php?action=search_books">
			<label>
				<select name="column">
					<option value="choose">Choose type of search</option>
                    <option value="select">Select all</option>
					<option value="Title" >By title</option>
					<option value="Author">By author</option>
					<option value="Publisher">By publisher</option>
					<option value="Genre">By genre</option>
				</select>
			</label>
			<label>
				<input name="key_word" type="text" size="80" style="height:25px;" />
			</label>
			<label>
				<input type="submit" name="search_book" class="btn btn-info" value="Search" style="margin-top:-5px;"/>
			</label>
		</form>
</div>
</div>
<div class="container-fluid">
    <div class="jumbotron">
    <h2>Search results</h2>
        <?php
            if(isset($_POST['search_book'])){
                $column = $_POST['column'];

                if($column == "choose"){
                    echo "You must select type of search!";
                }else{
                        if($column == "select"){
                            $books = "SELECT * FROM `books`";
                            $statement = $conn->prepare($books);
                            $statement->execute();
                            if($statement->rowCount()>0){
                                ?>
                                    <table class="table table-hover" style="background-color:#fff;">
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Publisher</th>
                                            <th>Published on</th>
                                            <th>Genre</th>
                                            <th>ISBN</th>
                                            <th>Number of pages</th>
                                            <th>Number of copies in library</th>
                                            <th>Rented books</th>	
                                            <th>Avaliable books</th>
                                        </tr>
                                    <?php
                                        while($row = $statement->fetch()){
                                    ?>
                                            <tr>
                                                <td><?php echo $row['Title'] ?></td>
                                                <td><?php echo $row['Author'] ?></td>
                                                <td><?php echo $row['Publisher'] ?></td>
                                                <td><?php echo $row['Published_on'] ?></td>
                                                <td><?php echo $row['Genre'] ?></td>
                                                <td><?php echo $row['ISBN'] ?></td>
                                                <td><?php echo $row['Number_of_pages'] ?></td>
                                                <td><?php echo $row['Number_of_copies'] ?></td>
                                                <td><?php echo $row['Rented'] ?></td>
                                                <td><?php echo $row['Avaliable_books'] ?></td>
                                            </tr>
                                    <?php
                                        }
                                        echo "</table>";
                                    }else {
                                        echo "No results!";
                                    }
                                }elseif(empty($_POST['key_word'])){
                                        echo "You must enter key word for search!";
                                    }else{
                                        $key_word = $_POST['key_word'];
                                        $query = "SELECT * FROM `books` WHERE ".$column." LIKE :search_word"; 
                                        $statement = $conn->prepare($query);
                                        $data =['search_word'=>'%'.$key_word.'%'];
                                        $statement->execute($data);
                                        if($statement->rowCount()>0){
                                        ?>
                                            <table class="table table-hover" style="background-color:#fff;">
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Author</th>
                                                    <th>Publisher</th>
                                                    <th>Published on</th>
                                                    <th>Genre</th>
                                                    <th>ISBN</th>
                                                    <th>Number of pages</th>
                                                    <th>Number of copies in library</th>
                                                    <th>Rented books</th>	
                                                    <th>Avaliable books</th>
                                                </tr>
                                            <?php
                                                while($row = $statement->fetch()){
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row['Title'] ?></td>
                                                        <td><?php echo $row['Author'] ?></td>
                                                        <td><?php echo $row['Publisher'] ?></td>
                                                        <td><?php echo $row['Published_on'] ?></td>
                                                        <td><?php echo $row['Genre'] ?></td>
                                                        <td><?php echo $row['ISBN'] ?></td>
                                                        <td><?php echo $row['Number_of_pages'] ?></td>
                                                        <td><?php echo $row['Number_of_copies'] ?></td>
                                                        <td><?php echo $row['Rented'] ?></td>
                                                        <td><?php echo $row['Avaliable_books'] ?></td>
                                                    </tr>
                                            <?php
                                            }
                                            echo "</table>";
                                    }else{
                                            echo "No results!";
                                        }
        }	
            }
    }
    
    ?> 
    <br>
    </div>
</div>
