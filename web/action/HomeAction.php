
<?php
    require_once("action/CommonAction.php");
    require_once("action/DAO/UserDAO.php");

    class HomeAction extends CommonAction {

        public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_MEMBER);
        }

        protected function executeAction() {
            if (isset($_POST['action'])) {
                $_SESSION["groupe"] = $_POST['action'];
                header("location:chat.php");
            }
            else if (isset($_POST["groupeName"])) {
                UserDAO::createGroupe($_SESSION["username"], $_POST["groupeName"]);
                UserDAO::addUserToGroupe($_SESSION["username"], $_POST["groupeName"]);
                header("location:home.php");
                exit;
            }
        }
	}