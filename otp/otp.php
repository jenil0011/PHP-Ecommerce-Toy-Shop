<?php
session_start();
$otp=random_int(10000,99999);
$to_email = "21bmiit033@gmail.com";
$subject = "OTP VERIFICATION REGARDING LOGIN INTO THE SYSTEM NAMED TOY MANIA";
$body = "your otp is: $otp";
$headers = "From: 21bmiit031@gmail.com";

if (mail($to_email, $subject, $body, $headers)) {
    
echo "success";
} else {
    echo "Email sending failed...";
}