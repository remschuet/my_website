<?php
    require_once("action/HomeAction.php");

    $action = new HomeAction();
    $data = $action->execute();
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link href="css/global.css" rel="stylesheet" />
	</head>
	<body>
		<div class="home-section">
			<div class ="section-home-top"> 
				<div class="home-top-username"><?php echo $data["username"]; ?> </div>
				<form action="?logout=true" class="deconnexion" method="post">
					<button class="lobbyBtn" type="submit">Quitter</button>
				</form>
			</div>
			<br>
			<form action="" method="post" class="home-groupe-form">
				<!-- Btn genere par ajax -->
			</form>

			<form action="" method="post" class="home-create-groupe-form">
				<input type="text" name="groupeName" class="home-create-input" id="groupeName" placeholder="groupe name" required>
				<button type="submit" class="home-groupe">Create</button>
			</form>

		</div>
	</body>

	<script>
		window.addEventListener("load", () => {
			refreshGroupe();
		})

	const refreshGroupe = () => {
		let formData = new FormData();
		formData.append('type', "getGroupe");
		
		fetch("ajax.php", {
			method : "POST",
			body: formData, // Utilisez formData comme corps de la requête
		})
		.then(response => response.json())
		.then(data => {

			let node = document.querySelector(".home-groupe-form");
			node.innerHTML = "";
			data.forEach(msg => {
				console.log(data);
				/*
					<button type="submit" name="action" value="public" class="home-groupe">public groupe</button>
					<button type="submit" name="action" value="bouton2" class="home-groupe">Friend</button>
				*/
				let button = document.createElement("button");
				button.type = "submit";
				button.name = "action";
				button.value = msg["name"];
				button.className = "home-groupe";
				button.textContent = msg["name"];;
				node.appendChild(button);
			})


			setTimeout(() => {
				refreshGroupe();
			}, 1000);

		})
	}
	</script>

</html>