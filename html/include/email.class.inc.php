<?php
/**
* email class to send properly formatted emails use PEAR mail_mime, auth_sasl, and net_smtp
*
*/
namespace IGBIllinois;

/**
* email class to send properly formatted emails use PEAR mail_mime, auth_sasl, and net_smtp
*
* Provides interface to easily send emails
*
* @author David Slater <dslater@illinois.edu>
* @access public
* @package IGBIllinois
* @copyright Copyright (c) 2020 University of Illinois Board of Trustees
* @license https://opensource.org/licenses/GPL-3.0 GNU Public License v3
*
*/

class email {

        ///////////////Private Variables//////////
	/** @var string smtp hostname */ 
        private $smtp_host = "locahost";
	/** @var integer smtp port*/
        private $smtp_port = "25";
	/** @var string smtp username */
        private $smtp_username;
	/** @var string smtp password */
        private $smtp_password;
	/** $var string[] To Emails */
	private $to_emails = array();
	/** $var string[] CC Emails */
	private $cc_emails = array();
	/** $var string[] Replay To Emails */
	private $replyto_emails = array();
	/** $var string[] BCC Emails */
	private $bcc_emails = array();

        ////////////////Public Functions///////////

	/**
	* Object constructor
	*
	* Makes initial connection to ldap database
	*
	* @param string $smtp_host SMTP Hostname
	* @param string $smtp_port SMTP Port. Defaults to 25
	* @param string $smtp_username SMTP Username. Optional
	* @param string $smtp_password SMTP Password. Optional
	* @return \IGBIllinois\ldap
	*/
        public function __construct($smtp_host,$smtp_port,$smtp_username = "",$smtp_password = "") {
                $this->smtp_host = $smtp_host;
                $this->smtp_port = $smtp_port;
		$this->smtp_username = $smtp_username;
                $this->smtp_password = $smtp_password;
        }

	/**
	* Object deconstructor
	*
	* Destroys ldap object
	* @param void
	* @return void
	*/
        public function __destruct() {}

	/**
	* gets smtp host
	*
	* @param void
	* @return string[]
	*/
        public function get_smtp_host() { return $this->smtp_host; }
	
	/**
	* gets smtp port
	*
	* @param void
	* @return integer
	*/
        public function get_smtp_port() { return $this->smtp_port; }

	/**
	* gets smtp username
	*
	* @param void
	* @return string
	*/
        public function get_smtp_username() { return $this->smtp_username; }

	/**
	* get smtp password
	*
	* @param void
	* @return string
	*/
	public function get_smtp_password() { return $this->smtp_password; }

	/**
	* 
	* set To emails
	* @param string|string[] string or array of strings of To: emails
	* @return void
	*/
	public function set_to_emails($to_emails) {
		if (!is_array($to_emails)) {
			$this->to_emails = array($to_emails);
		}
		else {
			$this->to_emails = $to_emails;
		}
	}

        /**
        * 
        * set Cc emails
        * @param string|string[] string or array of strings of Cc: emails
        * @return void
        */
	public function set_cc_emails($cc_emails) {
		if (!is_array($cc_emails)) {
			$this->cc_emails = array($cc_emails);
		}
		else {
			$this->cc_emails = $cc_emails;
		}
	}

        /**
        * 
        * set Reply-To emails
        * @param string|string[] string or array of strings of Reply-To: emails
        * @return void
        */
	public function set_replyto_emails($replyto_emails) {
		if (!is_array($replyto_emails)) {
			$this->replyto_emails = array($replyto_emails);
		}
		else {
			$this->replyto_emails = $replyto_emails;
		}

	}

        /**
        * 
        * set Bcc emails
        * @param string|string[] string or array of strings of Bcc: emails
        * @return void
        */
	public function set_bcc_emails($bcc_emails) {
		if (!is_array($bcc_emails)) {
			$this->bcc_emails = array($bcc_emails);
		}
		else {
			$this->bcc_emails = $bcc_emails;
		}

	}
	/**
	* Sends email
	* 
	* @param string $from From Email Address
	* @param string $subject Email Subject
	* @param string $txt_message Email Message in plain txt
	* @param string $html_message Email Message in HTML
	* @throws Exception
	* @return boolean True on success, false otherwise
	*/
	public function send_email($from,$subject,$txt_message = "",$html_message = "") {
		if (!filter_var($from,FILTER_VALIDATE_EMAIL)) {
			throw new \Exception("From: Email is invalid");
			return false;
		}
		if (!count($this->to_emails)) {
			throw new \Exception("To field is not set");
			return false;
		}
		
		$extraheaders['To'] = implode(",",$this->to_emails);
		$recipiants = implode(",",$this->to_emails);
		if (count($this->cc_emails)) {
			$extraheaders['Cc'] = implode(",",$this->cc_emails);
			$recipiants .= "," . implode(",",$this->cc_emails);
		}
		if (count($this->bcc_emails)) {
			$extraheaders['Bcc'] = implode(",",$this->bcc_emails);
			$recipiants .= "," . implode(",",$this->bcc_emails);
		}
		if (count($this->replyto_emails)) {
			$extraheaders['Reply-To'] = implode(",",$this->replyto_emails);
		}
		$extraheaders['From'] = $from;
		$extraheaders['Subject'] = $subject;
		$extraheaders = array_merge($extraheaders,self::generate_message_date());
		$extraheaders = array_merge($extraheaders,self::generate_message_id());

		$message = new \Mail_mime();
		if ($txt_message !== "") {
			$message->setTxtBody($txt_message);
		}
		if ($html_message !== "") {
			$message->setHtmlBody($txt_message);
		}
		$headers = $message->headers($extraheaders);
		$body = $message->get();
		$mail_params = $this->get_mail_params();	
		$smtp = \Mail::factory("smtp",$mail_params);
		if (\PEAR::isError($smtp)) {
			throw new \Exception($smtp->getMessage());	
			return false;
		}
		$mail = $smtp->send($recipiants,$headers,$body);
		if (\PEAR::isError($mail)) {
			throw new \Exception($mail->getMessage());
			return false;
		}
		else {
			$this->unset_email_vars();
			return true;
		}
	}

	/**
	* generates mail params array for Mail::factory
	* @params void
	* $teturn string[] array of mail params
	*/
	private function get_mail_params() {
		$mail_params['host'] = $this->get_smtp_host();
                $mail_params['port'] = $this->get_smtp_port();

                if ($this->get_smtp_username() && $this->get_smtp_password()) {
                        $mail_params['auth'] = 'PLAIN';
                        $mail_params['username'] = $this->get_smtp_username();
                        $mail_params['password'] = $this->get_smtp_password();
                }

		return $mail_params;
	}
	/**
	* generate email message date header
	* @param void
	* @return date[] current date in proper formate 
	*/
	private function generate_message_date() {
		return array('Date'=>date('D, d M Y H:i:s O'));
	}

	/**
	* generate email Message-ID header
	*
	* @param void
	* @return string[] Message-ID
	*/
	private function generate_message_id() {
		
		$message_id = sprintf(
                        "<%s.%s@%s>",
                        base_convert(microtime(), 10, 36),
                        base_convert(bin2hex(openssl_random_pseudo_bytes(8)), 16, 36),
                        $_SERVER['SERVER_NAME']
                );
		return array('Message-Id'=>$message_id);
	}

	/**
	* Unset emails settings after email is sent
	* @param void
	* @return void
	*/
	private function unset_email_vars() {
		$this->to_emails = array();
		$this->cc_emails = array();
		$this->bcc_emails = array();
		$this->replyto_emails = array();
	}
}

?>

