<?php

class settings {

	private const DEBUG = false;



	public static function get_debug() {
		if (defined("DEBUG") && is_bool(DEBUG)) {
			return DEBUG;
		}
		return self::DEBUG;

	}

}


?>
