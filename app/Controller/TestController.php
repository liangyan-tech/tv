<?php
class TestController extends AppController {
	var $uses = array("ScrapedItem");

	function index() {
		$this->ScrapedItem->test();
	}
}