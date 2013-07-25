<?php
class Source extends AppModel {
	var $uses = array();

	function test() {
		$foreplay = "https://www.rogers.com/web/resources/service/residentialRedirect.jsp?setLanguage=en&setProvince=ON&customer_type=Residential&targetUrl=%2Fweb%2Flink%2FptvBrowsePackagesFlowBegin%3FforwardTo%3Dlanding";
		$url = "https://www.rogers.com/web/link/ptvBrowsePackagesFlowBegin?forwardTo=landing";

		$ch = curl_init($foreplay);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_COOKIEJAR, TMP.'cookies.txt');
		$output = curl_exec($ch);
		curl_close($ch);
// debug($output);die;
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, TMP.'cookies.txt');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$output = curl_exec($ch);
		curl_close($ch);

		debug($output);die;
	}
}