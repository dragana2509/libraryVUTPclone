<?php
	session_start();
	require_once("header.php");
	require_once("conn.php");
?>
<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2" id="column1">
						<?php
							include_once("menagement.php")
						?>
				</div>
				<div class="col-md-8" id="column2"style="margin-bottom: 10px; padding:25px;">
					<h1><center>WELCOME TO ONLINE LIBRARY</center></h1>
						<?php
							include_once("menu.php");
							include_once("main.php");
						?>
				</div>
				<div class="col-md-2" id="column3">
						<?php
							require_once("location.php");
							require_once("login.php");
						?>
				</div>
			</div>
		</div>
<?php
	require_once 'recommended1.php';
	require_once 'footer.php';
?>
</body>
</html>