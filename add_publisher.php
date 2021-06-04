<center><h3>ADD NEW PUBLISHER</h3></center>
<?php
	require_once("header.php");
    $err = "";
    if(isset($_POST['submit_add'])){
		if(!empty($_POST['publisher'])){
			$qpublishers = "SELECT * FROM `publisher` WHERE `Publisher`= :publisher";
			$publishers= $conn->prepare($qpublishers);
			$publishers->execute(array(
						':publisher'=>$_POST['publisher']
							));
                if($publishers->rowCount()){
                    $err .="Publisher already exists! <br>";
                }else{
                    $newPublisher = $_POST['publisher'];
                }
        }else{
            $err .="- You must enter publisher! <br>";
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
            $query = "INSERT INTO `publisher` 
                                    SET `Publisher`=:publisher 
                                ";
                     $statement = $conn->prepare($query);
                     $statement->execute(array(
                               ':publisher'=>$newPublisher
                       ));
                     echo "<h4>Successfully added!</h4> ";
		}
    }
?>
<div class="container-fluid">
    <div class="jumbotron">
        <div class="row">
            <form method="POST", action="admin.php?action=add_publisher" enctype="multipart/form-data"> 
                <center><table class="table table-striped" style="width:auto;"></center>
                    <tr>
                        <td>
                            New publisher:
                        </td>
                        <td>
                            <input type="text" name="publisher"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit_add" class="btn btn-info" value="Add publisher" />
                        </td>
                    </tr>
            </form>
        </div>
    </div>
</div>