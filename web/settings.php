<?php
    require_once("action/SettingsAction.php");

    $action = new SettingsAction();
    $data = $action->execute();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link href="css/global.css" rel="stylesheet" />
	</head>
	<body>
        <div>Settings</div>
	</body>

</html>