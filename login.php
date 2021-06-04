<?php
	$err1 ="";
	if(isset($_POST['submit_login'])){
		if(!empty($_POST['username'])){
			$qUserName="SELECT * FROM `users` WHERE `username`=:username";
			$user = $conn -> prepare($qUserName);
			$user ->execute(array(
				':username'=> $_POST['username']));
			
			if ($user->rowCount()>=2) {
				$err1 .="Error, please contact admin!<br>";
			} elseif ($user->rowCount()==0){
				$err1 .="Username does not exist, please make a <a href ='index.php?action=register'><h4>Registration!</h4></a><br>";
			}
		} else{
			$err1 .="Username is required!<br>";
		}
		if(!empty($_POST['pass']) && empty($err1)){
			$qAccount = "SELECT * FROM `users` WHERE `username`= :username AND `password`=:pass";
			$statement = $conn->prepare($qAccount);
			$statement ->execute(array(
					':username'	=> $_POST['username'], 
					':pass' =>md5($_POST['pass'])));
			if($statement->rowCount()==1){
				
				$user = $statement->fetch();
				$_SESSION['id'] = $user['id'];
				$_SESSION['username'] = $user['username'];
				if($user['username'] == "admin"){
					header("Location:admin.php");
				} else{
					header("Location:home.php");
				}
			} elseif ($user->rowCount()>=2) {
				$err1 .="Error, please contact admin!<br>";
			} else{
				$err1 .="Username/Password is not correct, please try again! <br>";
			}
		} else{
			$err1 .="Password is required!<br>";
		}
		if(!empty($err1)){
			echo "<h4>$err1</h4>";
		}
	}	
?>
<div class="panel panel-default">
    <div class="panel-heading">
		<h3 class="panel-title"><center>Log In form</center></h3>
	</div>
<div class="panel-body">
		<form method="POST", action="index.php?action=login" enctype="multipart/form-data">
			<div class="row">
					<div class="form-group">
						<input type="text" name="username" class="form-control input-sm" placeholder="UserName">
					</div>
					<div class="form-group">
						<input type="password" name="pass" id="inputPass" class="form-control input-sm" placeholder="Password">
					</div>
					<input type="checkbox" onclick="myFunction()"> Show Password
			    	<input type="submit" role="button" name="submit_login" value="Log In" class="btn btn-info" style="display:block;margin:0 auto;">
				<div class="etc-login-form">
					<p style="margin:7px 0 0; color:darkslateblue; font-size:16px;">forgot your password? <a href="index.php?action=contact">click here to contact us</a></p>
					<p style="margin:7px 0 0; color:darkslateblue; font-size:16px;">new user? <a href="index.php?action=register">create new account</a></p>
				</div>
		</form>
			</div>
</div>
<script>
function myFunction() {
  var x = document.getElementById("inputPass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
			
