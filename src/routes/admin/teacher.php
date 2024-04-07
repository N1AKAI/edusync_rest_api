<?php

use App\Repository\TeacherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


// Create teacher - POST ✔️
$app->post('/teachers', function (Request $request, Response $response, $args) {

  $required_params = ['first_name', 'last_name', 'email', 'password', 'phone_number'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $first_name = $request_data['first_name'];
  $last_name = $request_data['last_name'];
  $email = $request_data['email'];
  $password = $request_data['password'];
  $phone_number = $request_data['phone_number'];
  $hash_password = password_hash($password, PASSWORD_DEFAULT);

  $db = new TeacherRepository();
  $result = $db->createTeacher($first_name, $last_name, $email, $hash_password, $phone_number);

  if ($result == TEACHER_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Teacher created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == TEACHER_FAILUARE) {
    $message = [
      'error' => true,
      'message' => 'Some error occurred'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(422);
  } elseif ($result == TEACHER_EXIST) {
    $message = [
      'error' => false,
      'message' => 'Teacher Already Exists'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(422);
  }
});

// Login teacher - POST ✔️
$app->post('/auth/teacher', function (Request $request, Response $response, $args) {

  if (!haveEmptyParametrs(array('email', 'password'), $request, $response)) {
    $request_data = $request->getParsedBody();
    $email = $request_data['email'];
    $password = $request_data['password'];

    $db = new TeacherRepository();
    $result = $db->teacherLogin($email, $password);
    if ($result == TEACHER_AUTHENTICATED) {
      $teacher = $db->getTeacherByEmail($email);

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Login is Successful';
      $response_data['teacher'] = $teacher;

      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else if ($result == TEACHER_NOT_FOUND) {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'Teacher doesn\'t exist';

      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else if ($result == TEACHER_PASSWORD_DO_NOT_MATCH) {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'Invalid credentil';

      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    }
  }

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});

// All teachers - GET ✔️
$app->get('/teachers', function (Request $request, Response $response) {

  $db = new TeacherRepository;
  $teachers = $db->getAllTeachers();
  $response_data = array();
  $response_data['error'] = false;
  $response_data['teachers'] = $teachers;

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});


// Update teacher - PUT ✔️
$app->put('/teachers/{id}', function (Request $request, Response $response, array $args) {

  $teacher_id = $args['id'];
  if (!haveEmptyParametrs(array('first_name', 'last_name', 'email', 'phone_number'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $first_name = $request_data['first_name'];
    $last_name = $request_data['last_name'];
    $email = $request_data['email'];
    $phone_number = $request_data['phone_number'];

    $db = new TeacherRepository;
    if ($db->updateTeacher($first_name, $last_name, $email, $phone_number, $teacher_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Teacher updated Successfelly';
      $teacher = $db->getTeacherByEmail($email);

      $response_data['teacher'] = $teacher;
      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'Please try agin later';
      $teacher = $db->getTeacherByEmail($email);

      $response_data['teacher'] = $teacher;
      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    }
  }
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update teacher password - POST ✔️
$app->post('/teachers/password', function (Request $request, Response $response, array $args) {

  if (!haveEmptyParametrs(array('password', 'new_password', 'email'), $request, $response)) {
    $request_data = $request->getParsedBody();
    $currentpassword = $request_data['password'];
    $newpassword = $request_data['new_password'];
    $email = $request_data['email'];

    $db = new TeacherRepository;
    $result = $db->updatePassword($currentpassword, $newpassword, $email);
    if ($result == PASSWORD_CHANGED) {
      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Password Changed';
      $response->getBody()->write(json_encode($response_data));
      return $response->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else if ($result == PASSWORD_DO_NOT_MATCH) {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'You have wrong password';
      $response->getBody()->write(json_encode($response_data));
      return $response->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else if ($result == PASSWORD_NOT_CHANGED) {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'Somme erreur accord';
      $response->getBody()->write(json_encode($response_data));
      return $response->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    }
  }

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(422);
});

// Delete teacher - DELETE ✔️
$app->delete('/teachers/{id}', function (Request $request, Response $response, array $args) {
  $teacher_id = $args['id'];
  $db = new TeacherRepository;
  if ($db->deleteTeacher($teacher_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Teacher has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});