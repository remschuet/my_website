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
					$result = UserDAO::getAjaxMessageArray();
				}
				if ($_POST['type'] == "getGroupe"){
					$result = UserDAO::getAjaxGroupeNameForUserArray();
				}
				echo json_encode($result);
			}
		}
	}