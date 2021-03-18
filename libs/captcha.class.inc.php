<?php

/* 
 * This is a class to add a captcha functionality for public forms
 *  like ones that send email
 */

class captcha {
    
/** String of permitted characters to use in the captcha string */    
public static $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';


/** Generate a random string of characters 
 * 
 * @param string $input The input string of possible characters
 * @param int $strength Length of the string to generate
 * @param boolean $secure Use secure function 
 * @return type
 */
    public static function secure_generate_string($input, $strength = 5, $secure = true) {

        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            if($secure) {
                $random_character = $input[random_int(0, $input_length - 1)];
            } else {
                $random_character = $input[mt_rand(0, $input_length - 1)];
            }
            $random_string .= $random_character;
        }
        return $random_string;
    }
    
    /**
     * Draw a colored CAPTCHA box, with random rectangles for obfuscation,
     * and draw the CAPTCHA letters in that box
     * 
     * @param string $captcha_string
     * @param int $width Width of the CAPTCHA box, in pixels
     * @param int $height Height of the CAPTCHA box, in pixels
     * @param int $string_length Length of the string, in number of characters
     * @return image The PHP image object that was generated
     */
    public static function draw_captcha($captcha_string, $width=200, $height=50, $string_length = 6) {
        
        // create an image object
        $image = imagecreatetruecolor($width, $height);

        imageantialias($image, true);

        $colors = [];

        
        // generate random rgb colors
        $red = rand(125, 175);
        $green = rand(125, 175);
        $blue = rand(125, 175);

        for($i = 0; $i < 5; $i++) {
          $colors[] = imagecolorallocate($image, $red - 20*$i, $green - 20*$i, $blue - 20*$i);
        }

        imagefill($image, 0, 0, $colors[0]);

        // Create the rectangle
        for($i = 0; $i < 10; $i++) {

          imagesetthickness($image, rand(2, 10));
          $rect_color = $colors[rand(1, 4)];
          imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $rect_color);
        }

        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $textcolors = [$black, $white];

        $fonts = [dirname(__FILE__).'\..\html\fonts\Acme.ttf', dirname(__FILE__).'\..\html\fonts\Ubuntu.ttf', dirname(__FILE__).'\..\html\fonts\Merriweather.ttf', dirname(__FILE__).'\..\html\fonts\PlayfairDisplay.ttf'];

        // Add letters with random rotation to the image
        for($i = 0; $i < $string_length; $i++) {
          $letter_space = 170/$string_length;
          $initial = 15;

          imagettftext($image, 24, rand(-15, 15), $initial + $i*$letter_space, rand(25, 45), $textcolors[rand(0, 1)], $fonts[array_rand($fonts)], $captcha_string[$i]);
          
        }
        return $image;

    }
    
}