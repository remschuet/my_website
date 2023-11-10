
<?php
    require_once("action/CommonAction.php");
    require_once("action/DAO/UserDAO.php");

    class SettingsAction extends CommonAction {

        public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_MODERATOR);
        }

        protected function executeAction() {
            if (isset($_POST["message"]) && $_POST["message"] != "") {
				UserDAO::sendMsg($_SESSION["username"], $_POST["message"]);
                header("location:chat.php");
            }
		}
	}
