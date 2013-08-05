<?php
set_time_limit(120);
ini_set('memory_limit','256M');
class ChannelsController extends AppController {
	var $uses = array("Channel", "ScrapedItem");

	function index() {
		$this->set("title_for_layout", "Channels");

		$channels = $this->Channel->find("all", array("limit" => 10));
		$this->set(compact("channels"));
	}

	function edit($id) {
		
	}

	function delete($id) {

	}
}