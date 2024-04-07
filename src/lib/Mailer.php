<?php

namespace App\Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer
{

  public static function send($to, $name, $subject, $html, $text)
  {
    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                          // Set mailer to use SMTP
    $mail->SMTPDebug  =  0;                   // Enable verbose debug output
    $mail->Host       =  MAIL_HOST;           // Specify main and backup SMTP servers
    $mail->Username   =  MAIL_USER;           // SMTP username
    $mail->Password   =  MAIL_PASS;           // SMTP password
    $mail->SMTPAuth   =  true;                // Enable SMTP authentication
    $mail->SMTPSecure =  'tls';               // Enable TLS encryption, `ssl` also accepted
    $mail->Port       =  587;                 // TCP port to connect to

    //Recipients
    $mail->AddReplyTo(MAIL_USER, MAIL_NAME);  // Add a "Reply-To" address (Optional)
    $mail->SetFrom(MAIL_USER, MAIL_NAME);
    $mail->AddAddress($to, $name);            // Add a recipient
    $mail->addBCC(MAIL_USER);                 // Add a "BCC" address (Optional)

    //Content
    $mail->isHTML(true);                      // Set email format to HTML
    $mail->Subject    =  $subject;
    $mail->Body      =  $html;
    $mail->AltBody    =  $text;
    $mail->CharSet    =  'UTF-8';

    if (filter_var($to, FILTER_VALIDATE_EMAIL) !== false) { // Chck if email is valid
      $result = $mail->send();
    } else {
      return false;
    }

    if ($result) {
      return true;
    } else {
      return false;
    }
  }
}
