<div class="jumbotron">
<center><h3><b>EDIT USER</b></h3></center>
<?php	
	include_once("conn.php");
	include_once("header.php");
?>
<?php
	$id_edit = $_GET['id'];
	$query = "SELECT * FROM `users` WHERE `id` = $id_edit";
	$user = $conn->query($query);
	$u = $user->fetch(PDO::FETCH_OBJ);
		$id = $u->id;
		$username = $u->username;
		$name = $u->Name;
		$surname = $u->Surname;
		$email = $u->eMail;
		$password = $u->password;
		
		if(isset($_POST['submit'])){
			if($username !== "admin"){
				$username_form = $_POST['username'];
				$name_form = $_POST['name'];
				$surname_form = $_POST['surname'];
				$email_form = $_POST['email'];
				$password_form =  md5($_POST['password']);

				if(!empty($username_form) AND !empty($name_form) AND !empty($surname_form) AND !empty($email_form) AND !empty($password_form)) {
					$query = "UPDATE users 
								SET `username` =:username, 
								`Name` =:name, 
								`Surname` =:surname, 
								`eMail` =:email,
								`password` =:password
							WHERE id =$id_edit";
					$result = $conn->prepare($query);
					$result->execute(array(
						":username"=>$username_form, 
						":name"=>$name_form,
						":surname"=>$surname_form,
						":email"=>$email_form,
						":password"=>$password_form
					));
				?>
						<meta http-equiv="refresh" content="0;url='admin.php?action=show_user_admin'"/>
				<?php
						die();
					}else{
						echo "No field must be empty! <br>";
					}
			}else{
				echo "<h4>You can not change username admin!</h4>";
				$name_form = $_POST['name'];
				$surname_form = $_POST['surname'];
				$email_form = $_POST['email'];
				$password_form =  md5($_POST['password']);

				if(!empty($name_form) AND !empty($surname_form) AND !empty($email_form) AND !empty($password_form)) {
					$query = "UPDATE users 
								SET  `Name` =:name, 
								`Surname` =:surname, 
								`eMail` =:email,
								`password` =:password
							WHERE id =$id_edit";
					$result = $conn->prepare($query);
					$result->execute(array(
						":name"=>$name_form,
						":surname"=>$surname_form,
						":email"=>$email_form,
						":password"=>$password_form
					));
					echo "<a href='admin.php?action=show_user_admin'>Back to list of users </a>";
				?>
						
				<?php
						die();
					}else{
						echo "No field must be empty! <br>";
					}
				
			}
		}
		?>
<a href="admin.php?action=show_user_admin"><h3 style="margin-left:25px">Go Back To List Of Users</h3></a>
<hr>

<div class="panel panel-default">
<div class="panel-body" style="width:30%; padding:40px;">
	<form action="edit_user.php?id=<?php echo $id_edit; ?>" method="POST">
		<div class="row">
				<div class="form-group">
					*Username <input type="text" name="username" value="<?php echo $username; ?>" class="form-control input-sm">
				</div>
				<div class="form-group">
					*Name <input type="text" name="name" value="<?php echo $name ; ?>" class="form-control input-sm">
				</div>
				<div class="form-group">
					*Surname <input type="text" name="surname" value="<?php echo $surname ; ?>" class="form-control input-sm">
				</div>
				<div class="form-group">
					*Email <input type="text" name="email" value="<?php echo $email ; ?>" class="form-control input-sm">
				</div>
				<div class="form-group">
					*Password <input type="text" name="password" value="<?php echo $password ; ?>" class="form-control input-sm">
				</div>
				<input type="submit" role="submit" name="submit"  class="btn btn-info" value="EDIT" style="display:block;margin:0 auto;">
	</form>
		</div>
</div>
