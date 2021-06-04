<div class="container-fluid">
<div class="jumbotron">
<?php
	if(isset($_GET['pid'])){
		$qUs = "SELECT * FROM `users`
				WHERE `id` = :user";
		$profile = $conn->prepare($qUs);
		$profile->execute(array(
			':user'=>$_GET['pid']
		));
	} else{
		$qUs = "SELECT * FROM `users`
				WHERE `id` = :user";
		$profile = $conn->prepare($qUs);
		$profile->execute(array(
			':user'=>$_SESSION['id'] 
		));
	}
	if(isset($_SESSION['id'])){
		if($profile->rowCount()){
			$fetchProf = $profile->fetchAll(PDO::FETCH_OBJ);
			foreach ($fetchProf as $p) {
				echo "<h3>". $p->Name ." ".$p->Surname ."</h3>";
				echo "<img src='". $p->avatar ."' width='200'> <br>";
				echo  $p->username . "<br>";
				echo  $p->eMail . "<br>";
			}
		} else{
			echo("User that you are searching for, does not exist! ");
		}
	} else{
		echo("You do not have permision to see this page if you are not loged in! ");
	}
