<?php
    require_once("action/CommonAction.php");
    require_once("action/DAO/UserDAO.php");

    class ChatAction extends CommonAction {

        public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_MEMBER);
        }

        protected function executeAction() {
            if (isset($_POST["message"]) && $_POST["message"] != "") {
				UserDAO::sendMsg($_SESSION["username"], $_SESSION["groupe"], $_POST["message"]);
                header("location:chat.php");
            }
		}
	}
