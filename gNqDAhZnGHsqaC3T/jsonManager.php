<?php
	function readJSONfile() {
		$json = file_get_contents($GLOBALS["jsonPath"]);
		return json_decode($json, true);
	}