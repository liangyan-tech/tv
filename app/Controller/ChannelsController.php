<?php
set_time_limit(120);
ini_set('memory_limit','256M');
class ChannelsController extends AppController {
	var $uses = array("Channel", "ScrapedItem");

	function index() {
		$this->set("title_for_layout", "Channels");

		$channels = $this->Channel->find("all", array(
			"conditions" => array(
				"Channel.disabled" => 0
			)
		));
		$this->set(compact("channels"));
	}

	function edit($id = null) {
		$title_for_layout = "Edit Channel";
		if (!$id)  $title_for_layout = "Create Channel";
		$this->set("title_for_layout", $title_for_layout);

		if ($this->request->is("post")) {
			$newChannel = $this->request->data;
			if ($id) {
				$this->Channel->id = $id;
			} else {
				$this->Channel->create();
			}

			if ($this->Channel->save($newChannel)) {
				$this->Session->setFlash("Channel saved successfully.", null, array("type" => "success"));
			} else {
				$this->Session->setFlash("Oops, something is wrong.", null, array("type" => "error"));
			}
			$this->redirect("/channels");
		}
		
		$vendors = $this->ScrapedItem->getVendors();
		$channel = $this->Channel->findById($id);
		$this->set(compact("channel", "id", "vendors"));
	}

	function delete($id) {
		$this->Channel->id = $id;
		$this->Channel->saveField("disabled", 1);

		$this->Session->setFlash("Channel has been deleted!", null, array("type" => "success"));
		$this->redirect("/channels");
	}
}