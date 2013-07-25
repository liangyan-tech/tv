<?php
App::uses("Controller", "Controller");
class AppController extends Controller {
	var $helpers = array(
		"Html",
		"Form",
		"Time",
		"Text",
		"Session"
	);
	var $components = array(
		"Session",
		"Cookie",
		"Auth" => array(
			"loginAction" => array(
				"controller" => "users",
				"action" => "login"
			),
			// "authError" => "",
			// "authError" => "",
			"authenticate" => array(
				"Form" => array(
					"fields" => array(
						"username" => "email",
						"password" => "password"
					),
					"scope" => array("User.activated" => 1),
					"userModel" => "User"
				)
			),
			"loginRedirect" => "/",
			"authorize" => array( "Controller" )
		)
	);
	
	function beforeFilter() {
		if ($this->request->is("ajax")) {
			$this->layout = "ajax";
		}
		if ( $this->params["prefix"] == "admin" ) {
			if (!AuthComponent::user("admin")) die;
		}
		if (isset($this->_allowedActions)) {
			$this->Auth->allow($this->_allowedActions);
		} else {
			$this->Auth->allow();
		}
	}
	
	function isAuthorized() {
		// disables auth check for testing purpose
		// @todo this should be removed ASAP
		return true;
	}
	
	function beforeRender() {
		if ($this->name == "CakeError") $this->layout = "error";
	}
	
	// 
	function ajaxRedirect($url) {
		echo '<script>document.location = "".Router::url($url)."";</script>';die;
	}
}