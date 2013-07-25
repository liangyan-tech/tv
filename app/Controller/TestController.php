<?php
class TestController extends AppController {
	var $uses = array("Source");

	function index() {
		$this->Source->test();
	}
}