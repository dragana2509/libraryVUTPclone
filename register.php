<?php
$name = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
$surname = filter_input(INPUT_POST,'surname',FILTER_SANITIZE_STRING);
$eMail = filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_EMAIL);
	$err = "";
	if(isset($_POST['submit_reg'])){
		if(!empty($_POST['username'])){
			$UserName = "SELECT * FROM `users` WHERE `username`= :username";
			$users= $conn->prepare($UserName);
			$users->execute(array(
						':username'=>$_POST['username']
							));
			
			if($users->rowCount()){
				$err .="Username already exists, please choose other! <br>";
			} else {
				$username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
			}
		} else {
			$err .="- You must enter your username! <br>";
		}	

		if(!empty($_POST['pass'])){
			
		} else {
			$err .="- You must enter your password! <br>";
		}	
		if(!empty($_POST['Repass'])){
			
		} else {
			$err .="- You must repeat your password! <br>";
		}	

		if(!empty($_POST['pass']) && !empty($_POST['Repass'])){
			if($_POST['pass'] == $_POST['Repass']){
				$password = md5(filter_input(INPUT_POST,'pass',FILTER_SANITIZE_STRING));
			} else {
				$err .="- Your passwords must be the same! <br>";
			}
		}
		if(empty($_POST['name'])){
			$err .="- You must enter your name! <br>";
		}else{
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $err .= "First name->Only letters and white space allowed <br>";
            }else{
				$UserName = "SELECT * FROM `users` WHERE `name`= :name";
				$users= $conn->prepare($UserName);
				$users->execute(array(
							':name'=>$_POST['name']
								));
			}
		}
			if(empty($_POST['surname'])){
				$err .="- You must enter your surname! <br>";
			}else{
				if (!preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
					$err .= "Last name->Only letters and white space allowed <br>";
				}else{
					$UserName = "SELECT * FROM `users` WHERE `surname`= :surname";
					$users= $conn->prepare($UserName);
					$users->execute(array(
								':surname'=>$_POST['surname']
									));
				}
			}

			if(!empty($eMail)) { 
				if (filter_var($eMail, FILTER_VALIDATE_EMAIL) === false) {
					$err.= '- Email is not valid email address <br>';
				}else{
					$Usermail = "SELECT * FROM `users` WHERE eMail = :email";
					$stmmail = $conn->prepare($Usermail);
					$mailData = [
					':email' => $_POST['eMail']
					];
					$stmmail->execute($mailData);
                if($stmmail->rowCount()) {
                    $err.= '- Email already exist <br>';
                }else{
                    $eMail = filter_input(INPUT_POST, 'eMail', FILTER_SANITIZE_EMAIL);
                    } 
                }
            } 
		if(!empty($_FILES['avatar']['tmp_name'])){
			$folder = "Pictures_registration/";
			$folder = $folder . basename($_FILES['avatar']['name']);
			$tmpName = $_FILES['avatar']['tmp_name'];
			$part_name = pathinfo($_FILES['avatar']['name']);
			$ext = $part_name['extension'];

			$first =rand(1,100000);
			$second =rand(1,100000);
			$third =rand(1,100000);
			$rand_name = $first ."-" .$second . "-" .$third .".".$ext;
			$final = "Pictures_registration/" .$rand_name;
		} else{
			$err .="Upload profile picture! ";
		}
		if($err <> ""){
			echo "<h4>$err</h4>" ;
		}else{
			if(move_uploaded_file($tmpName, $final)){
					$queryUsers = "INSERT INTO `users` 
							SET `username`=:username,
							 `password` =:password,
							 `name`=:name,
							 `surname`=:surname,
							 `eMail`=:eMail,
							 `avatar`=:avatar
					";
					$statement = $conn->prepare($queryUsers);
					$statement->execute(array(
							':username'=>$username,
							':password'=>$password,
							':name'=>$name,
							'surname'=>$surname,
							':eMail'=>$eMail,
							':avatar'=>$final
					));
				} else {
					$qUsers = "INSERT INTO `users` 
							SET `username`=:username,
							 `password` =:password,
							 `name`=:name,
							 `surname`=:surname,
							 `eMail`=:eMail,
							 `avatar`=:avatar
					";
					$stmt = $conn->prepare($qUsers);
					$stmt->execute(array(
							':username'=>$username,
							':password'=>$password,
							':name'=>$name,
							'surname'=>$surname,
							':eMail'=>$eMail,
							':avatar'=>"Pictures_registration/default.png"
					));
				}
			echo "Successfully signed in!";
			header("Location:index.php?action=login");
		}	
	}
?>
<div class="panel panel-default" style="margin-top:10px;">
        		<div class="panel-heading">
			    		<h3 class="panel-title"><center>Please sign up!</center></h3>
			 			</div>
			 			<div class="panel-body">
			    		<form method="POST", action="index.php?action=register" enctype="multipart/form-data">
						<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			                <input type="text" id="username" name="username" class="form-control input-sm" placeholder="UserName">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="file" name="avatar" id="avatar" class="form-control input-sm" placeholder="Profile Picture">
			    					</div>
			    				</div>
			    			</div>
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			                <input type="text" style="text-transform:capitalize;" name="name" class="form-control input-sm" placeholder="First Name">
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="text" style="text-transform:capitalize;" name="surname" class="form-control input-sm" placeholder="Last Name">
			    					</div>
			    				</div>
			    			</div>

			    			<div class="form-group">
			    				<input type="email" name="eMail" class="form-control input-sm" placeholder="example@email.com">
			    			</div>

			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" id="pass" name="pass"  class="form-control input-sm" placeholder="Password" 
										pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
										title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
			    						<input type="password" name="Repass" class="form-control input-sm" placeholder="Confirm Password">
			    					</div>
			    				</div>
			    			</div>
			    			
			    			<input type="submit" id="submit_reg" name="submit_reg" value="Sign Up" class="btn btn-info">
			    		
			    		</form>
			    	</div>
						<div id="message">
							<h4>Password must contain the following:</h4>
							<p id="letter" class="invalid">A <b>lowercase</b> letter</p>
							<p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
							<p id="number" class="invalid">A <b>number</b></p>
							<p id="length" class="invalid">Minimum <b>8 characters</b></p>
						</div>
	    		</div>

<script>
var myInput = document.getElementById("pass");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  }else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  }else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  }else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  }else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>