<?php

use App\Lib\Mailer;
use App\Repository\StudentRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Student - Forget password - POST ✔️
$app->post('/forget-password/student', function (Request $request, Response $response) {
  $res['error'] = true;
  $res['message'] = 'Student doesn\'t exsits!';

  $email = $request->getParsedBody()['email'];

  $db = new StudentRepository;
  if ($db->isEmailExist($email)) {
    $otp = "";
    for ($i = 0; $i < 5; $i++) {
      $otp .= rand(1, 9);
    }

    if ($db->addOtp($otp, $email)) {
      $to = $email;
      $subject = "Forget Password - OTP";
      $name = $email;
      $text = "Your OTP: $otp";
      $html = "<strong>OTP: $otp</strong>";
      if (Mailer::send($to, $name, $subject, $html, $text)) {
        $res['error'] = false;
        $res['message'] = 'Send it successfully, check your email!';
      } else {
        $res['message'] = 'Failed to send it';
      }
    }
  }

  $response->getBody()->write(json_encode($res));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Student - Verify OTP - POST ✔️
$app->post('/very-otp/student', function (Request $request, Response $response) {
  $res['error'] = true;
  $res['message'] = 'Invliad OTP';

  $body = $request->getParsedBody();
  $email = $body['email'];
  $otp = $body['otp'];

  $db = new StudentRepository;
  if ($db->isValidOtp($otp, $email)) {
    $res['error'] = false;
    $res['message'] = 'Valid OTP';
  }

  $response->getBody()->write(json_encode($res));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Student - Change Password via OTP - POST ✔️
$app->post('/change-password/student', function (Request $request, Response $response) {
  $res['error'] = true;
  $res['message'] = 'Invliad OTP';

  $body = $request->getParsedBody();
  $email = $body['email'];
  $password = $body['password'];
  $otp = $body['otp'];

  $db = new StudentRepository;
  if ($db->isValidOtp($otp, $email)) {
    if ($db->changePassword($password, $email)) {
      $res['error'] = false;
      $res['message'] = 'Changed successfully';
    } else {
      $res['message'] = 'Password didn`\'t change';
    }
  }

  $response->getBody()->write(json_encode($res));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
