<?php
require_once("../main.inc.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['reset_password_submit'])) {
    
    // Find user, update db with password reset data, and send email
    $email = $_POST['email'];
    
    $query = "SELECT id from members where uname='". mysqli_real_escape_string($dbcon, $email) . "'";
    $result = mysqli_query($dbcon, $query); 
    
    if(count($result) == 0) {
        $error_message = "The email you provided could not be found. Please check you have entered it properly,"
                . "or sign up for a new account.";
    } else {
        $id = $result[0]['id'];

// Create tokens
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);

$url = sprintf('%sreset.php?%s', ABS_URL, http_build_query([
    'selector' => $selector,
    'validator' => bin2hex($token)
]));

// Token expiration
$expires = new DateTime('NOW');
$expires->add(new DateInterval('PT01H')); // 1 hour

// Delete any existing tokens for this user
$this->db->delete('password_reset', 'email', $user->email);

// Insert reset token into database
$insert = $this->db->insert('password_reset', 
    array(
        'email'     =>  $user->email,
        'selector'  =>  $selector, 
        'token'     =>  hash('sha256', $token),
        'expires'   =>  $expires->format('U'),
    )
);
    }
}
echo('
<form action="reset_password.php" method="post">
    <input type="text" class="text" name="email" placeholder="Enter your email address" required>
    <input type="submit" class="submit" id="reset_password_submit" name="reset_password_submit" value="Submit">
</form>
        ');