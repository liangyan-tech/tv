<?php
class Channel extends AppModel {
	
	function copyFromScrape($scrap_id) {
		$this->ScrapedItem = ClassRegistry::init("ScrapedItem");

		$items = $this->ScrapedItem->findAllByScrapeId(3);
		foreach ($items as $item) {
			$channel = $item["ScrapedItem"];
			unset($channel["id"]);unset($channel["scrape_id"]);unset($channel["created"]);unset($channel["modified"]);
			$this->Channel->create($channel);
			$this->Channel->save();
		}
	}
}