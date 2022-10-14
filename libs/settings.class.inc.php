<?php

class settings {

	private const DEBUG = false;
	private const TIMEZONE = "UTC";
	private const SESSION_NAME = "PHPSESSID";
	private const SESSION_TIME = 300;
	private const DB_HOST = "localhost";
	private const DB_PORT = 3306;
	private const DB_SSL = false;
	private const ENABLE_LOG = false;
	private const SMTP_PORT = 25;
	private const SMTP_HOST = "localhost";

	public static function get_debug() {
		if (defined("DEBUG") && is_bool(DEBUG)) {
			return DEBUG;
		}
		return self::DEBUG;

	}

	public static function get_version() {
		return VERSION;
	}
	public static function get_website_url() {
		return WEBSITE_URL;
	}

	public static function get_timezone() {
		if (defined("TIMEZONE") && (TIMEZONE != "")) {
			return TIMEZONE;
		}
		return self::TIMEZONE;
	}

	public static function get_session_name() {
		if (defined("SESSION_NAME")) {
			return SESSION_NAME;
		}
		return self::SESSION_NAME;
	}
	public static function get_session_timeout() {
		if (defined("SESSION_TIMEOUT")) {
			return SESSION_TIMEOUT;
		}
		return self::SESSION_TIMEOUT;
	}

	public static function get_mysql_host() {
		if (defined("DB_HOST")) {
			return DB_HOST;
		}
		return self::MYSQL_HOST;

	}

	public static function get_mysql_user() {
		if (defined("DB_USER")) {
			return DB_USER;
		}
		return false;
	}

	public static function get_mysql_password() {
		if (defined("DB_PASSWORD")) {
			return MYSQL_PASSWORD;
		}
		return false;
	}
	public static function get_mysql_port() {
		if (defined("DB_PORT")) {
			return DB_PORT;
		}
		return self::DB_PORT;

	}

	public static function get_mysql_database() {
		if (defined("DB_NAME")) {
			return DB_NAME;
		}
		return false;
	}

	public static function get_mysql_ssl() {
		if (defined("DB_SSL")) {
			return DB_SSL;
		}
		return self::DB_SSL;

	}

	public static function get_log_enabled() {
		if (defined("ENABLE_LOG") && (is_bool(ENABLE_LOG))) {
			return ENABLE_LOG;
		}
		return self::ENABLE_LOG;
	}

	public static function get_logfile() {
                if (self::get_log_enabled() && !file_exists(LOG_FILE)) {
                        touch(LOG_FILE);
                }
                return LOG_FILE;

	}

	public static function get_smtp_host() {
		if (defined("SMTP_HOST")) {
			return SMTP_HOST;
		}
		return self::SMTP_HOST;

	}
	public static function get_smtp_port() {
		if (defined("SMTP_PORT")) {
			return SMTP_PORT;
		}
		return self::SMTP_PORT;

	}

	public static function get_smtp_username() {
                if (defined("SMTP_USERNAME")) {
                        return SMTP_USERNAME;
                }
                return false;
        }

        public static function get_smtp_password() {
                if (defined("SMTP_PASSWORD")) {
                        return SMTP_PASSWORD;
                }
                return false;

	}

	public static function get_from_email() {
		if (defined("FROM_EMAIL")) {
			return FROM_EMAIL;
		}
		return false;

	}

	public static function get_admin_email() {
		if (defined("ADMIN_EMAIL")) {
			return ADMIN_EMAIL;
		}
		return false;

	}
}


?>
