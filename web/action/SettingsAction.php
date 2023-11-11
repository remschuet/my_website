
<?php
    require_once("action/CommonAction.php");
    require_once("action/DAO/UserDAO.php");

    class SettingsAction extends CommonAction {

        public function __construct() {
            parent::__construct(CommonAction::$VISIBILITY_MEMBER);
        }

        protected function executeAction() {
            if (isset($_POST["addPeople"])){
                UserDAO::addUserToGroupe($_POST["addPeople"], $_SESSION["groupe"]);
            }
        }
    }
