<?php

class Dir {
	public $os;
	public $dir;

	function __construct($_os = null, $_dir = null) {
		$this->os = $_os;
		$this->dir = $_dir;
	}
}
?>
