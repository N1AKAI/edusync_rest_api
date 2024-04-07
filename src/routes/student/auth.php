<?php

use App\Lib\JWTAuth;
use App\Repository\StudentRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Login Student - POST ✔️
$app->post('/auth/students', function (Request $request, Response $response, $args) {

  $status_code = 400;
  if (!haveEmptyParametrs(array('email', 'password'), $request, $response)) {
    $response_data = array();
    $response_data['error'] = true;

    $request_data = $request->getParsedBody();
    $email = $request_data['email'];
    $password = $request_data['password'];

    $db = new StudentRepository();
    $result = $db->studentLogin($email, $password);

    switch ($result) {
      case STUDENT_AUTHENTICATED:
        $student = $db->getStudentByEmail($email);
        $id = $student['student_id'];
        $email = $student['email'];
        $token = JWTAuth::getToken($id, $email);

        $response_data['error'] = false;
        $response_data['message'] = 'Login is Successful';
        $response_data['token'] = $token;
        break;
      case STUDENT_NOT_FOUND:
        $response_data['message'] = 'Student doesn\'t exist';
        break;
      case STUDENT_PASSWORD_DO_NOT_MATCH:
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
