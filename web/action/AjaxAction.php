<?php
	require_once("action/CommonAction.php");
	require_once("action/DAO/UserDAO.php");

	class AjaxAction extends CommonAction {

		public function __construct() {
			parent::__construct(CommonAction::$VISIBILITY_PUBLIC);
		}

		protected function executeAction() {
            $result = UserDAO::getAjaxMessageArray();

			echo json_encode($result);
		}
	}