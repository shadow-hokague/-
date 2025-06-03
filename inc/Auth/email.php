<?php


function send_email($email, $subject, $body, $sender_email = APP_EMAIL)
{
  if (empty($email)) return; 
  $headers = "MIME-Version: 1.0\r\n";
  $headers = "FROM: $sender_email\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  if (EMAIL_VERIFICATION) {
    mail($email, $subject, $body, $headers);
  } else {
    // email is disabled
  }
}
