<?php

use App\Lib\JWTAuth;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Login Student - POST ✔️
$app->post('/auth/teachers', function (Request $request, Response $response, $args) {

  $status_code = 400;
  if (!haveEmptyParametrs(array('email', 'password'), $request, $response)) {
    $response_data = array();
    $response_data['error'] = true;

    $request_data = $request->getParsedBody();
    $email = $request_data['email'];
    $password = $request_data['password'];

    $db = new TeacherRepository();
    $result = $db->teacherLogin($email, $password);

    switch ($result) {
      case TEACHER_AUTHENTICATED:
        $teacher = $db->getTeacherByEmail($email);
        $id = $teacher['teacher_id'];
        $email = $teacher['email'];
        $token = JWTAuth::getToken($id, $email, TYPE_TEACHER);

        $response_data['error'] = false;
        $response_data['message'] = 'Login is Successful';
        $response_data['token'] = $token;
        break;
      case TEACHER_NOT_FOUND:
        $response_data['message'] = 'Teacher doesn\'t exist';
        break;
      case TEACHER_PASSWORD_DO_NOT_MATCH:
        $response_data['message'] = 'Invalid credentials';
        break;
    }

    $response->getBody()->write(json_encode($response_data));
    $status_code = 200;
  }

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus($status_code);
});
