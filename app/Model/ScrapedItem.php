<?php
App::import("Vendor", "simple_html_dom");
App::import("Vendor", "finediff");
ini_set('memory_limit','256M');

class ScrapedItem extends AppModel {
	var $belongsTo = array("Scrape");

	var $sources = array(
		"rogers" => array(
			"name" => "rogers",
			"packages" => array(
				array(
					"name" => "DIGITAL TV",
					"paths" => array(
						"normal" => array(
							array("div[id=allChannels_BCAB] table", 0),
							array("td[valign=top]")
						),
						"hd" => array(
							array("div[id=allChannels_BCAB] table", 1),
							array("td[valign=top]")
						)
					)
				),
				array(
					"name" => "DIGITAL PLUS",
					"paths" => array(
						"normal" => array(
							array("div[id=allChannels_DVFE] table", 0),
							array("td[valign=top]")
						),
						"hd" => array(
							array("div[id=allChannels_DVFE] table", 1),
							array("td[valign=top]")
						)
					)
				),
				array(
					"name" => "VIP PACKAGE",
					"paths" => array(
						"normal" => array(
							array("div[id=allChannels_VIP] table", 0),
							array("td[valign=top]")
						),
						"hd" => array(
							array("div[id=allChannels_VIP] table", 1),
							array("td[valign=top]")
						)
					)
				),
				array(
					"name" => "HD VIP PACKAGE",
					"paths" => array(
						"hd" => array(
							array("div[id=allChannels_HDVIP] table", 0),
							array("td[valign=top]")
						)
					)
				),
				array(
					"name" => "VIP ULTIMATE WITH TMN",
					"paths" => array(
						"normal" => array(
							array("div[id=allChannels_VULTI1] table", 0),
							array("td[valign=top]")
						),
						"hd" => array(
							array("div[id=allChannels_VULTI1] table", 1),
							array("td[valign=top]")
						)
					)
				),
				array(
					"name" => "VIP ULTIMATE WITH SUPER CHANNEL",
					"paths" => array(
						"normal" => array(
							array("div[id=allChannels_VULTI2] table", 0),
							array("td[valign=top]")
						),
						"hd" => array(
							array("div[id=allChannels_VULTI2] table", 1),
							array("td[valign=top]")
						)
					)
				)
			)
		)
	);
	
	function test() {
		// $tmp = ClassRegistry::init("Tmp")->findById(1);
		// $text = $this->_parseAndSave($tmp["Tmp"]["content"]);
		$this->getDiffs();
		// $this->_parseDiff("102.1 THE EDGE Toronto<ins> test</ins>");
	}

	function getDiffs() {
		$this->Scrape->contain("ScrapedItem");
		$batches = $this->Scrape->find("all", array(
			"order" => array("Scrape.created" => "DESC"),
			"limit" => 2
		));
		$from_text = $to_text = "";
		foreach ($batches[1]["ScrapedItem"] as $item) {
			$from_text .= json_encode(array(
				"vendor" => $item["vendor"],
				"package" => $item["package"],
				"tag" => $item["tag"],
				"channel" => mb_convert_encoding($item["channel"], 'HTML-ENTITIES', 'UTF-8')
			));
			$from_text .= "\n";
		}
		foreach ($batches[0]["ScrapedItem"] as $item) {
			$to_text .= json_encode(array(
				"vendor" => $item["vendor"],
				"package" => $item["package"],
				"tag" => $item["tag"],
				"channel" => mb_convert_encoding($item["channel"], 'HTML-ENTITIES', 'UTF-8')
			));
			$to_text .= "\n";
		}

		$opcodes = FineDiff::getDiffOpcodes($from_text, $to_text);
		$diffString = FineDiff::renderDiffToHTMLFromOpcodes($from_text, $opcodes);

		$diffs = explode("\n", html_entity_decode(html_entity_decode($diffString)) );
		foreach ($diffs as $key => $line) {
			unset($diffs[$key]);
			if ( strpos($line, "<ins>") !== false || strpos($line, "<del>") !== false ) {
				$json = $line;

				if ( strpos($json, "<ins>") === 0 ) {
					$json = str_replace("<ins>", "", $json);
					$data = Set::reverse(json_decode($json));
					foreach ($data as $field => $val) {
						$data[$field] = "<ins>".$val."</ins>";
					}
				} else if ( strpos($json, "<del>") === 0 ) {
					$json = str_replace("<del>", "", $json);
					$data = Set::reverse(json_decode($json));
					foreach ($data as $field => $val) {
						$data[$field] = "<del>".$val."</del>";
					}
				} else {
					$data = Set::reverse(json_decode($json));
				}
				foreach ($data as $field => $val) {
					$diffs[$key][$field] = $this->_parseDiff($val);
				}
			}
		}
		return $diffs;
	}

	function _parseDiff($text) {
		$data = array(
			"old" => strip_tags( $this->_replaceBetween($text, "<ins>", "</ins>", "") ),
			"new" => strip_tags( $this->_replaceBetween($text, "<del>", "</del>", "") )
		);
		return $data;
	}

	function _replaceBetween($str, $needle_start, $needle_end, $replacement) {
		$pos = strpos($str, $needle_start);
		if ($pos === false) return $str;
		$start = $pos === false ? 0 : $pos + strlen($needle_start);

		$pos = strpos($str, $needle_end, $start);
		if ($pos === false) return $str;
		$end = $pos === false ? strlen($str) : $pos;

		return substr_replace($str, $replacement, $start, $end - $start);
	}

	function saveChannels() {
		$this->Channel = ClassRegistry::init("Channel");
	}

	private function _parseAndSave($text, $vendor = "rogers") {
		$this->Scrape->create();
		$this->Scrape->save();
		$scrape_id = $this->Scrape->id;

		$html = str_get_html($text);

		foreach ( $this->sources[$vendor]["packages"] as $package) {
			foreach ($package["paths"] as $tag => $paths) {
				$doms = $html->find($paths[0][0], $paths[0][1])->find($paths[1][0]);

				$records = array();
				foreach ( $doms as $td ) {
					$chunk = $td->plaintext;
					$chunks = explode("\n", $chunk);
					
					$items = array();
					foreach ($chunks as $key => $val) {
						$val = trim($val);
						if ($val) $items []= $val;
					}
					$records = array_merge($records, $items);
				}
				// save
				foreach ($records as $key => $channel) {
					$this->create(array(
						"scrape_id" => $scrape_id,
						"vendor" => $vendor,
						"package" => $package["name"],
						"tag" => $tag,
						"position" => $key,
						"channel" => $channel
					));
					$this->save();
				}

			}
		}

		$html->clear(); unset($html);
		die;
	}

	private function _getRaw( $vendor = "rogers" ) {
		$foreplay = "https://www.rogers.com/web/resources/service/residentialRedirect.jsp?setLanguage=en&setProvince=ON&customer_type=Residential&targetUrl=%2Fweb%2Flink%2FptvBrowsePackagesFlowBegin%3FforwardTo%3Dlanding";
		$url = "https://www.rogers.com/web/link/ptvBrowsePackagesFlowBegin?forwardTo=landing";

		$ch = curl_init($foreplay);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, TMP.'cookies.txt');
		$output = curl_exec($ch);
		curl_close($ch);
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, TMP.'cookies.txt');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}
}