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
				else if ($_POST['type'] == "getGroupe"){
					$result = UserDAO::getAjaxGroupeNameForUserArray($_SESSION["username"]);
				}
				else if ($_POST['type'] == "getUser"){
					$result = UserDAO::getAjaxUserForGroupeArray($_SESSION["groupe"]);
				}
				else if ($_POST['type'] == "remUserFromGroupe"){
					$result = UserDAO::removeUserFromGroupe($_POST["user"], $_POST['groupe']);
					exit;
				}
				echo json_encode($result);
			}
		}
	}