<?php
App::import("Vendor", "simple_html_dom");
ini_set('memory_limit','256M');

class Source extends AppModel {
	var $useTable = "scrapes";
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
		$tmp = ClassRegistry::init("Tmp")->findById(1);
		$text = $this->_parseHtml($tmp["Tmp"]["content"]);
	}

	private function _parseHtml($text, $vendor = "rogers") {
		$html = str_get_html($text);

		foreach ( $this->sources[$vendor]["packages"] as $package) {
			foreach ($package["paths"] as $tag => $paths) {
// debug($package);die;
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