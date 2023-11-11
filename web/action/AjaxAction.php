<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/UserDAO.php");

	class AjaxAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC);
		}

		protected function executeAction() {
			$result = "";
			if (isset($_POST['type'])) {
				if ($_POST['type'] == "getMsg"){
					$result = UserDAO::getAjaxMsgForGroupeArray($_SESSION["groupe"]);
				}
				if ($_POST['type'] == "getGroupe"){
					$result = UserDAO::getAjaxGroupeNameForUserArray($_SESSION["username"]);
				}

				echo json_encode($result);
			}
		}
	}