<?php

require_once __DIR__ . "/main.inc.php";

$session = new \IGBIllinois\session(settings::get_session_name());
$string_length = 6;
$captcha_string = captcha::secure_generate_string(captcha::$permitted_chars, $string_length);

$session->set_session_var('captcha_text', $captcha_string);
$image = captcha::draw_captcha($captcha_string);
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);


?>
