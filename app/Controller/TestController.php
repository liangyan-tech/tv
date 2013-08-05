<?php
class TestController extends AppController {
	var $uses = array("ScrapedItem", "Channel");

	function index() {
		$this->ScrapedItem->test();
	}
}