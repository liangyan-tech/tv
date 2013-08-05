<?php
class HomeController extends AppController {
	var $uses = array("Channel", "ScrapedItem", "Scrape");

	function index() {
		$this->set("title_for_layout", "Diffs");

		$lastScrape = $this->Scrape->find("first", array( "order" => array("Scrape.created" => "DESC") ));
		$diffs = $this->ScrapedItem->getDiffs();
		$this->set(compact("diffs", "lastScrape"));
	}
}