<?php
set_time_limit(600);
class TestController extends AppController {
	var $uses = array("Scrape", "ScrapedItem", "Channel");

	function index() {
		$html = $this->ScrapedItem->getRaw();
		$this->ScrapedItem->parseAndSave($html);
	}
}