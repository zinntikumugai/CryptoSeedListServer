<?php
require_once __DIR__ ."/Dir.php";
/**
 *
 */
class Crypto {
	public $name = null;
	public $date = null;
	public $filename = null;
	public $dirs = [];
	public $seed = [];

	function __construct($_name = null, $_filename = null, $_dir = [], $_seed = []) {
		$this->name = $_name;
		$this->date = self::getDate();
		$this->filename = $_filename;
		$this->dirs = $_dir;
		$this->seed = $_seed;
	}

	private static function getDate($format = "Y-m-d H:i:s O",$tz = "Asia/Tokyo") {
		$date = new DateTime("", new DateTimeZone($tz));
		return $date->format($format);
	}

	public function getArray() {
		return (array)$this;
	}

	public function getJson() {
		return json_encode($this);
	}
}

?>
