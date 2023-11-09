<?php
    require_once("action/IndexAction.php");

    $action = new IndexAction();
    $data = $action->execute();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link href="css/global.css" rel="stylesheet" />
	</head>
	<body>
		<div class="all-form">
			<?php  echo ($data["hasConnectionError"]) ?>
		</div>
		<div class="all-form">
			<form action="" method="post" class="login-form">
				<input type="text" name="username" id="username" placeholder="username" required> <br>
				<input type="password" name="passwd" id="passwd" placeholder="password" required> <br>
				<button type="submit">LOG IN</button>
			</form>
			<form action="" method="post" class="sign-form">
				<input type="text" name="sign_username" id="sign_username" placeholder="username" required> <br>
				<input type="email" name="sign_email" id="sign_email" placeholder="email" required> <br>
				<input type="password" name="sign_passwd" id="sign_passwd" placeholder="password" required> <br>
				<input type="password" name="sign_passwd_verif" id="sign_passwd_verif" placeholder="verif password" required> <br>
				<button type="submit">SIGN UP</button>
			</form>
		</div>
	</body>
</html>
