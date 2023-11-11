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
		<div class="section-settings">
        	<div class="settings-title"> <?php echo $_SESSION["groupe"] ?> </div>
		
			<form action="" method="post" class="home-create-groupe-form">
				<input type="text" name="addPeople" class="settings-create-input" id="addPeople" placeholder="username" required>
			</form>

			<div class="settings-current-user">
			</div>

		</div>

	<script>
		window.addEventListener("load", () => {
			refreshUser();
		})

		const refreshUser = () => {
			let formData = new FormData();
			formData.append('type', "getUser");
			
			fetch("ajax.php", {
				method : "POST",
				body: formData, // Utilisez formData comme corps de la requête
			})
			.then(response => response.json())
			.then(data => {
				let node = document.querySelector(".settings-current-user");
				node.innerHTML = "";
				data.forEach(msg => {
					console.log(data);

					let div = document.createElement("div");
					div.className = "settings-username";
					div.textContent = msg["username"];
					node.appendChild(div);
				})

				setTimeout(() => {
					refreshUser();
				}, 1000);

			})
		}
	</script>

	</body>
</html>