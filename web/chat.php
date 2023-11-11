<?php
    require_once("action/ChatAction.php");

    $action = new ChatAction();
    $data = $action->execute();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link href="css/global.css" rel="stylesheet" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="corp-admin">
<!--
			<form action="?logout=true" class="deconnexion" method="post">
				<button class="lobbyBtn" type="submit">Quitter</button>
			</form>
-->			<div class="section-admin-top">
				<b> <?php echo $data["username"] ?> </b>
			</div>
			<div class="section-msg">
			</div>

			<br>
			<form action="" class="messageZone" method="post">
				<input type="text" name="message" id="message" placeholder="message" autofocus>
			<!--	<button type="submit">SEND</button> -->
			</form>
		</div>
	</body>

	<script>

		setTimeout(() => {
			let element = document.querySelector(".section-msg");
			element.scrollTop = element.scrollHeight;
		}, 200);

		window.addEventListener("load", () => {
			let node = document.querySelector(".section-admin-top");
			node.addEventListener("click", () => {    
				window.location.href = "settings.php";});
			refreshChat();
		})
		
		const refreshChat = () => {
			let formData = new FormData();
    		formData.append('type', "getMsg");

			fetch("ajax.php", {
				method : "POST",
				body: formData, // Utilisez formData comme corps de la requête
			})
			.then(response => response.json())
			.then(data => {
				console.log(data);
				let node = document.querySelector(".section-msg");
				node.innerHTML = "";

				const lastMessages = data.slice(-30);

				lastMessages.forEach(msg => {
					// Créez un conteneur de message (div)
					var messageDiv = document.createElement("div");
					messageDiv.className = "message";

					// Remplissez le contenu du message
					messageDiv.innerHTML = '<p class="user">(' + msg.sender + ')</p><p> - ' + msg.content + '</p>';
					node.appendChild(messageDiv);
				})

				setTimeout(() => {
					refreshChat();
				}, 1000);
			})
		}

	</script>
</html>