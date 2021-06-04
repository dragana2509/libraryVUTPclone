<?php 
$err = "";
    if(isset($_POST['submit'])){
        // $message=$_POST['message'];
		if(!empty($_POST['username']) && ($_POST['username']!="admin") && !empty($_POST['email'])){
			$totalUsers = "SELECT * FROM `users` WHERE `username`= :username AND `eMail`=:email";
			$users= $conn->prepare($totalUsers);
			$users->execute(array(
						':username'=>$_POST['username'],
						':email'=>$_POST['email']
							));
			if($users->rowCount()){
				$username = $_POST['username'];
				$eMail = $_POST['email'];
			} else{
				$err .="<h4>Your username and email does not match, please try again!</h4> <br>";
			}
		} else{
			$err .="<h4>You must enter your username/email!</h4><br>";
		}	
      
        if($err <> ""){
			echo $err ;
		} else{
		
			if(!empty($_POST['message-pass'])){
            $queryUsers = "INSERT INTO `contactus` 
							SET `username`=:username,
							 `eMail`=:email,
							 `message`=:message
					";
					$statement = $conn->prepare($queryUsers);
					$statement->execute(array(
							':username'=>$username,
							':email'=>$eMail,
							':message'=>$_POST['message-pass']
					));
                    echo "<h4>Successfully sent!</h4>";
        }

		if(!empty($_POST['messageBook'])){
			

			$qus = "SELECT u.*, r.* FROM `users` u
			LEFT JOIN rent r ON u.id=r.user_id
			WHERE u.username=:username";
			
			$statement = $conn->prepare($qus);
			$statement->execute(array(
				':username'=>$username
			));
			
			// while ($resultRentedBooks = $statement->fetch(PDO::FETCH_OBJ)){
			// 	echo $resultRentedBooks'date_for_return'];
				
			// }
		
			$count = 0;
			while ($u = $statement->fetch(PDO::FETCH_OBJ)) {
				$todayDate= date('Y-m-d');
				$dateReturn=$u->date_for_return;
				if($todayDate>$dateReturn) {
					$count = $count + 1;
				}
			}
				if($count==0){
					echo '<h4>You have not exceed date for return!</h4>';
				}else{
					$queryUsers = "INSERT INTO `contactus` 
						SET `username`=:username,
						`eMail`=:email,
						`message`=:message
				";
					$statement = $conn->prepare($queryUsers);
					$statement->execute(array(
							':username'=>$username,
							':email'=>$eMail,
							':message'=>$_POST['messageBook']
					));
					echo "<h4>Successfully sent!</h4>";
				}


		
			// foreach ($resultRentedBooks as $book) {
				// echo $book;
				
			// 	if($todayDate<$returnBookook){
			// 		echo '<h4>You have not exceed date for return!</h4>';
			// 	}else{
			// 		$queryUsers = "INSERT INTO `contactus` 
			// 		SET `username`=:username,
			// 		 `eMail`=:email,
			// 		 `message`=:message
			// ";
			// $statement = $conn->prepare($queryUsers);
			// $statement->execute(array(
			// 		':username'=>$username,
			// 		':email'=>$eMail,
			// 		':message'=>$_POST['messageBook']
			// ));
			// echo "<h4>Successfully sent!</h4>";
			// 	}
			// }
           
        }


    }
}
?>
<div class="panel panel-default">
 <div class="panel-heading">
		<h3 class="panel-title"><center>CONTACT US</center></h3>
	</div>
<div class="panel-body">
<!-- <h3><center>CONTACT US</center></h3> -->
    <form action="index.php?action=contact" method="POST">
        <div class="form-group">
            <label>Username:</label>
            <input type="text"  name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">Select message: <br>
			<input type="checkbox" checked = true name="message-pass" value="forgotten password">
			<label for="forgotten_password">Forgotten password!</label><br>
			<input type="checkbox" checked = true name="messageBook" value="books for return">
			<label for="books_return">Books return!</label><br>
        </div>
        <div class="form-group">
            <button class="btn btn-info" name="submit" type="submit">Submit</button>
        </div>
    </form>
</div>
</div>