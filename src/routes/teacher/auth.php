<?php

use App\Common\JsonResponse;
use App\Lib\JWTAuth;
use App\Repository\TeacherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Login Student - POST ✔️
$app->post('/auth/teachers', function (Request $request, Response $response, $args) {

  $status = 422;
  $msg['error'] = true;

  $request_data = $request->getParsedBody();
  $email = $request_data['email'];
  $password = $request_data['password'];

  $db = new TeacherRepository();
  $result = $db->teacherLogin($email, $password);

  switch ($result) {
    case TEACHER_AUTHENTICATED:
      $teacher = $db->fetchByColumn("email", $email);
      $id = $teacher['teacher_id'];
      $email = $teacher['email'];
      $token = JWTAuth::getToken($id, $email, TYPE_TEACHER);
      $msg['error'] = false;
      $msg['message'] = 'Login is Successful';
      $msg['token'] = $token;
      $status = 200;
      break;
    case TEACHER_NOT_FOUND:
    case TEACHER_PASSWORD_DO_NOT_MATCH:
      $msg['message'] = 'Invalid Email or Password';
      break;
  }

  return JsonResponse::send($response, $msg, $status);
});
