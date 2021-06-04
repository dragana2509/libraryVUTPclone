<center><h3>ADD NEW GENRE</h3></center>
<?php
	require_once("header.php");
    $err = "";
    if(isset($_POST['submit_add'])){
		if(!empty($_POST['genre'])){
			$qgenre = "SELECT * FROM `genre` WHERE `Genre`= :genre";
			$genres= $conn->prepare($qgenre);
			$genres->execute(array(
						':genre'=>$_POST['genre']
							));
                if($genres->rowCount()){
                    $err .="Genre already exists! <br>";
                }else{
                    $newGenre = $_POST['genre'];
                }
        }else{
            $err .="- You must enter genre! <br>";
        }
        if($err <> ""){
            ?>
			<h4>
				<?php
				echo $err ;
				?>
			</h4>
			<?php
		}else{
            $query = "INSERT INTO `genre` 
                                    SET `Genre`=:genre 
                                ";
                     $statement = $conn->prepare($query);
                     $statement->execute(array(
                         
                               ':genre'=>$newGenre
                                
                       ));
                     echo "<h4>Successfully added!</h4> ";
		}
    }
?>
<div class="container-fluid">
    <div class="jumbotron">
        <div class="row">
            <form method="POST", action="admin.php?action=add_genre" enctype="multipart/form-data"> 
                <center><table class="table table-striped" style="width:auto;"></center>
                    <tr>
                        <td>
                            New genre:
                        </td>
                        <td>
                            <input type="text" name="genre"/>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit_add" class="btn btn-info" value="Add genre" />
                        </td>
                    </tr>
            </form>
        </div>
    </div>
</div>