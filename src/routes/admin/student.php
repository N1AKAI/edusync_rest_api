<?php

use App\Common\JsonResponse;
use App\Repository\StudentRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create student - POST ✔️
$app->post('/students', function (Request $request, Response $response, $args) {

  $required_params = ['first_name', 'last_name', 'phone_number', 'fathers_name', 'mothers_name', 'join_date', 'email', 'password'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $first_name = $request_data['first_name'];
  $last_name = $request_data['last_name'];
  $phone_number = $request_data['phone_number'];
  $fathers_name = $request_data['fathers_name'];
  $mothers_name = $request_data['mothers_name'];
  $join_date = $request_data['join_date'];
  $email = $request_data['email'];
  $password = $request_data['password'];
  $hash_password = password_hash($password, PASSWORD_DEFAULT);

  $db = new StudentRepository();
  $result = $db->createStudent($first_name, $last_name, $phone_number, $fathers_name, $mothers_name, $join_date, $email, $hash_password);

  if ($result == STUDENT_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Student created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == STUDENT_FAILUARE) {
    $message = [
      'error' => true,
      'message' => 'Some error occurred'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(422);
  } elseif ($result == STUDENT_EXIST) {
    $message = [
      'error' => false,
      'message' => 'Student Already Exists'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(422);
  }
});

// All student - GET ✔️
$app->get('/students', function (Request $request, Response $response) {

  $db = new StudentRepository;
  $students = $db->fetchAll();

  return JsonResponse::send($response, $students);
});

// Single student - GET ✔️
$app->get('/students/{id}', function (Request $request, Response $response, array $args) {

  $id = $args['id'];

  $db = new StudentRepository;
  $student = $db->fetch($id);

  return JsonResponse::send($response, $student);
});

// Update students - PUT ✔️
$app->put('/students/{id}', function (Request $request, Response $response, array $args) {

  $student_id = $args['id'];
  $status_code = 400;
  if (!haveEmptyParametrs(array ('first_name', 'last_name', 'phone_number', 'fathers_name', 'mothers_name', 'join_date'), $request, $response)) {
    $response_data = array ();
    $response_data['error'] = true;

    $request_data = $request->getParsedBody();
    $first_name = $request_data['first_name'];
    $last_name = $request_data['last_name'];
    $phone_number = $request_data['phone_number'];
    $fathers_name = $request_data['fathers_name'];
    $mothers_name = $request_data['mothers_name'];
    $join_date = $request_data['join_date'];

    $db = new StudentRepository;
    if ($db->updateStudent($first_name, $last_name, $phone_number, $fathers_name, $mothers_name, $join_date, $student_id)) {
      $response_data['error'] = false;
      $response_data['message'] = 'Student updated Successfelly';
      $status_code = 201;
    } else {
      $response_data['message'] = 'Please try again later';
      $status_code = 500;
    }
    $response->getBody()->write(json_encode($response_data));
  }
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus($status_code);
});

// Update student password - POST ✔️
$app->post('/student/password', function (Request $request, Response $response, array $args) {

  if (!haveEmptyParametrs(array ('password', 'new_password', 'email'), $request, $response)) {
    $request_data = $request->getParsedBody();
    $currentpassword = $request_data['password'];
    $newpassword = $request_data['new_password'];
    $email = $request_data['email'];

    $db = new StudentRepository;
    $result = $db->updatePasswordStudnt($currentpassword, $newpassword, $email);
    if ($result == PASSWORD_CHANGED) {
      $response_data = array ();
      $response_data['error'] = false;
      $response_data['message'] = 'Password Changed';
      $response->getBody()->write(json_encode($response_data));
      return $response->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else if ($result == PASSWORD_DO_NOT_MATCH) {
      $response_data = array ();
      $response_data['error'] = true;
      $response_data['message'] = 'You have wrong password';
      $response->getBody()->write(json_encode($response_data));
      return $response->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else if ($result == PASSWORD_NOT_CHANGED) {
      $response_data = array ();
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

// Delete student - DELETE ✔️
$app->delete('/students/{id}', function (Request $request, Response $response, array $args) {
  $student_id = $args['id'];
  $db = new StudentRepository;
  if ($db->deleteStudent($student_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Student has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
