<?php
session_start();
$otp=random_int(10000,99999);
$to_email = "21bmiit034@gmail.com";
$subject = "OTP VERIFICATION";
$body = "your otp is $otp";
$headers = "From: harshfree034@gmail.com";
if (mail($to_email, $subject, $body, $headers)) {
    
echo "success";
} else {
    echo "Email sending failed...";
}