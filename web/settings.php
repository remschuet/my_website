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
			<div class="back">
				<b>CI</b>
			</div>

        	<div class="settings-title"> <?php echo $_SESSION["groupe"] ?> </div>
		
			<!-- FIX ME , est ce que je suis admin ? -->
			<form action="" method="post" class="settings-create-groupe-form">
				<input type="text" name="addPeople" class="settings-create-input" id="addPeople" placeholder="username" required>
			</form>

			<div class="settings-current-user">
			</div>

		</div>

	<script>
		window.addEventListener("load", () => {
			let nodeBack = document.querySelector(".back");
			nodeBack.addEventListener("click", () =>{
				window.location.href = "chat.php";				
			})

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
					
					let parent = document.createElement("div");
					parent.className = "settings-parent-username-btn";

					let div = document.createElement("div");
					div.className = "settings-username";
					div.textContent = msg["username"];

					// Créer un bouton pour chaque élément
					let button = document.createElement("button");
					button.type = "submit";
					button.name = "action";
					button.value = msg["name"]; // Notez que vous utilisez msg["name"], assurez-vous que c'est correct
					button.className = "home-groupe";
					button.textContent = "X"; // Ajoutez le texte que vous souhaitez pour le bouton

					button.addEventListener("click", () => {
						// Ajoutez ici le code que vous souhaitez exécuter lorsque le bouton est cliqué
						console.log("supprimer :" + msg["username"]);
					});

					// Ajouter à la même div parent
					node.appendChild(parent);				

					parent.appendChild(div);
					parent.appendChild(button);
				})

				setTimeout(() => {
					refreshUser();
				}, 3000);

			})
		}
	</script>

	</body>
</html>