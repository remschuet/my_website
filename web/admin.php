<?php
    require_once("action/AdminAction.php");

    $action = new AdminAction();
    $data = $action->execute();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link href="css/global.css" rel="stylesheet" />
	</head>
	<body>
        <div>Admin</div>
	</body>

</html>