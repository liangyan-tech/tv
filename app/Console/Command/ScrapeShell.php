<?php
class ScrapeShell extends AppShell {
	var $uses = array("Scrape", "ScrapedItem");

	public function main() {
		$this->out('Downloading html from Rogers...');
		$html = $this->ScrapedItem->getRaw();

		$this->out('Html download is successful!');
		$this->out('Parsing html and saving scraped items...');

		$this->ScrapedItem->parseAndSave($html);
		$this->out('Scrape successful!');
	}
}