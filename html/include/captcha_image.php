<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ds = DIRECTORY_SEPARATOR;
$filepath = __DIR__ . "$ds..$ds";
try {
require_once "./main.inc.php";
require_once("../../libs/captcha.class.inc.php");
} catch(Exception $e) {
    echo($e->getTraceAsString());
}
$string_length = 6;
$captcha_string = captcha::secure_generate_string(captcha::$permitted_chars, $string_length);

$session->set_session_var('captcha_text', $captcha_string);
$image = captcha::draw_captcha($captcha_string);
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);


?>