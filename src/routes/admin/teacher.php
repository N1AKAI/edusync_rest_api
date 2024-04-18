<?php

use App\Common\JsonResponse;
use App\Repository\TeacherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// Create teacher - POST ✔️
$app->post('/teachers', function (Request $request, Response $response, $args) {

  $data = $request->getParsedBody();
  $db = new TeacherRepository();
  $result = $db->create($data, "password");
  $status = 201;
  if ($result == TEACHER_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Teacher created successfully'
    ];
  } elseif ($result == TEACHER_FAILUARE) {
    $message = [
      'error' => true,
      'message' => 'Some error occurred'
    ];
    $status = 422;
  } elseif ($result == TEACHER_EXIST) {
    $message = [
      'error' => false,
      'message' => 'Email already exsists'
    ];
    $status = 422;
  }
  return JsonResponse::send($response, $message, $status);
});

// Login teacher - POST ✔️
$app->post('/auth/teacher', function (Request $request, Response $response, $args) {

  $data = $request->getParsedBody();
  $email = $data['email'];
  $password = $data['password'];

  $message['error'] = true;
  $status = 422;

  $db = new TeacherRepository();
  $result = $db->teacherLogin($email, $password);
  if ($result == TEACHER_AUTHENTICATED) {
    $teacher = $db->fetchByColumn("email", $email);

    $message['error'] = false;
    $message['message'] = 'Login is Successful';
    $message['teacher'] = $teacher;
    $status = 200;
  } else if ($result == TEACHER_NOT_FOUND) {
    $message['message'] = 'Invalid Email or Password';
  } else if ($result == TEACHER_PASSWORD_DO_NOT_MATCH) {
    $message['message'] = 'Invalid Email or Password';
  }

  return JsonResponse::send($response, $message, $status);
});

// All teachers - GET ✔️
$app->get('/teachers', function (Request $request, Response $response) {

  $db = new TeacherRepository;
  $teachers = $db->fetchAll();

  return JsonResponse::send($response, $teachers);
});

// Single teachers - GET ✔️
$app->get('/teachers/{id}', function (Request $request, Response $response, array $args) {

  $id = $args['id'];

  $db = new TeacherRepository;
  $teacher = $db->fetch($id);

  return JsonResponse::send($response, $teacher);
});

// Update teacher - PUT ✔️
$app->put('/teachers/{id}', function (Request $request, Response $response, array $args) {

  $id = $args['id'];

  $data = $request->getParsedBody();

  $message['error'] = true;
  $status = 204;

  $db = new TeacherRepository;
  if ($db->update($id, $data, "password")) {
    $message['error'] = false;
    $message['message'] = 'Teacher updated Successfelly';
    $status = 201;
  } else {
    $message['message'] = 'Please try agin later';
  }
  return JsonResponse::send($response, $message, $status);
});

// Update teacher password - POST ✔️
$app->post('/teachers/password', function (Request $request, Response $response, array $args) {

  $data = $request->getParsedBody();
  $currentpassword = $data['password'];
  $newpassword = $data['new_password'];
  $email = $data['email'];

  $msg['error'] = true;
  $status = 422;

  $db = new TeacherRepository;
  $result = $db->updatePassword($currentpassword, $newpassword, $email);
  switch ($result) {
    case PASSWORD_CHANGED:
      $msg['error'] = false;
      $msg['message'] = 'Password Changed!';
      break;
    case PASSWORD_DO_NOT_MATCH:
      $msg['message'] = 'Passwords don\'t match';
      break;
    case PASSWORD_NOT_CHANGED:
      $msg['message'] = 'Password didn\'t change';
      break;
  }

  return JsonResponse::send($response, $msg, $status);
});

// Delete teacher - DELETE ✔️
$app->delete('/teachers/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];

  $message['error'] = true;
  $message['message'] = 'Please try again later';
  $status = 422;

  $db = new TeacherRepository;
  if ($db->delete($id)) {
    $message['error'] = false;
    $message['message'] = 'Teacher has been deleted';
    $status = 204;
  }
  return JsonResponse::send($response, $message, $status);
});
