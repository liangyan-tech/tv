<?php
class DiffsController extends AppController {
	var $uses = array("Channel", "ScrapedItem", "Scrape");

	function index() {
		$this->set("title_for_layout", "Diffs");

		$lastScrape = $this->Scrape->find("first", array( "order" => array("Scrape.created" => "DESC") ));
		$diffs = $this->ScrapedItem->getDiffs();
		$this->set(compact("diffs", "lastScrape"));
	}

	function commit($type, $scrapedItemId, $channel_id) {
		switch ($type) {
			case 'delete':
				$this->Channel->id = $channel_id;
				$this->Channel->saveField("disabled", 1);
				break;

			case 'create':
			case 'update':
				$item = $this->ScrapedItem->findById($scrapedItemId);
				$data = $item["ScrapedItem"];
				unset($data["id"]);
				unset($data["scrape_id"]);
				unset($data["created"]);
				unset($data["modified"]);
				$data["modified_according_to"] = $scrapedItemId;

				if ($type == "create") {
					$this->Channel->create($data);
					$this->Channel->save();
				} elseif ($type == "update") {
					$this->Channel->id = $channel_id;
					$this->Channel->save($data);
				}
				break;
		}

		$this->Session->setFlash("Changes have been commited!", null, array("type" => "success"));
		$this->redirect("/diffs");
	}
}