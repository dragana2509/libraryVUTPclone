<?php 
  foreach ($_POST as $key => $value) {
    echo '<p><strong>' . $key.':</strong> '.$value.'</p>';
  }
?>

<?php
 
 // grab recaptcha library
 require_once "recaptchalib.php";
  // your secret key
$secret = "6LeQl5YaAAAAAIUEygIYy1UvgLM9SOFni2uTLBeT";
 
// empty response
$response = null;
 
// check secret key
$reCaptcha = new ReCaptcha($secret);
// if submitted check response


// if ($_POST["g-recaptcha-response"]) {
//     $response = $reCaptcha->verifyResponse(
//         $_SERVER["REMOTE_ADDR"],
//         $_POST["g-recaptcha-response"]
//     );
// }
//  ?>
 
 <?php
  if ($response != null && $response->success) {
    echo "Hi " . $_POST["name"] . " , thanks for submitting the form!";
  } else {
?>
	
	<?php } ?>