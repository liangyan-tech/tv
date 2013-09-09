<?php
class Channel extends AppModel {
	
	function copyFromScrape($scrap_id = null) {
		$this->ScrapedItem = ClassRegistry::init("ScrapedItem");
		$this->Scrape = ClassRegistry::init("Scrape");
		if (!$scrap_id) {
			$lastScrape = $this->Scrape->find("first", array(
				"order" => array("Scrape.id" => "DESC")
			));
			$scrap_id = $lastScrape["Scrape"]["id"];
		}

		$items = $this->ScrapedItem->findAllByScrapeId($scrap_id);
		foreach ($items as $item) {
			$channel = $item["ScrapedItem"];
			unset($channel["id"]);unset($channel["scrape_id"]);unset($channel["created"]);unset($channel["modified"]);
			$this->create($channel);
			$this->save();
		}
	}
}