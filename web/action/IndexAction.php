<?php
    require_once("action/CommonAction.php");
    require_once("action/DAO/UserDAO.php");

    class IndexAction extends CommonAction {

        public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_PUBLIC);
        }

        protected function executeAction() {
			$hasConnectionError = "";

			# Connection
			if (isset($_POST["username"])) {
				$user = UserDAO::authenticate($_POST["username"], $_POST["passwd"]);

				if (!empty($user)) {	
					$_SESSION["username"] = $user["username"];
					$_SESSION["email"] = $user["email"];
                    $_SESSION["visibility"] = $user["visibility"];

					# Message de bienvenu
					UserDAO::sendMsg($_SESSION["username"], 1, "Salut a tous !");
					
					# Sortir vers la page admin
					header("location:home.php");
					exit;
				}
				else {
					$hasConnectionError = "Erreur de login";
				}
			}
			# Create User
			else if (isset($_POST["sign_username"])){
				# Meme mot de passe
				if ($_POST["sign_passwd_verif"] == $_POST["sign_passwd"]){
					$status = UserDAO::createUser($_POST["sign_username"], password_hash($_POST["sign_passwd"], PASSWORD_DEFAULT), $_POST["sign_email"]);
					
					# Si creation marche
					if (empty($status)) {
						$user = UserDAO::authenticate($_POST["sign_username"], $_POST["sign_passwd"]);
						if (!empty($user)) {	
							$_SESSION["username"] = $user["username"];
							$_SESSION["email"] = $user["email"];
							$_SESSION["visibility"] = $user["visibility"];
		
							# Message de bienvenu
							UserDAO::sendMsg($_SESSION["username"], 1, "Une nouvelle personne avec nous !");
							# UserDAO::addUserToGroupe($_SESSION["username"], 'public');						
						}
						# Sortir vers la page admin
						header("location:home.php");
						exit;
					}
					else {
						$hasConnectionError = "Erreur de creation de compte";
					}
				}
				else{
					$hasConnectionError = "Vos mots de passes ne sont pas identiques";
				}
			}

			return compact("hasConnectionError");
		}
	}
