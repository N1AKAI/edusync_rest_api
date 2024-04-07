<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/homework', function (Request $request, Response $response) {

  $required_params = ['class_id', 'teacher_id', 'course_id', 'homework'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $class_id = $request_data['class_id'];
  $teacher_id = $request_data['teacher_id'];
  $course_id = $request_data['course_id'];
  $homework = $request_data['homework'];

  $db = new DbOperationHomework();
  $result = $db->createHomework($class_id, $teacher_id, $course_id, $homework);

  if ($result == HOMEWORK_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Homework created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == HOMEWORK_FAILURE) {
    $message = [
      'error' => true,
      'message' => 'Some error occurred'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(422);
  }
});

// All Homework - GET  
$app->get('/homework', function (Request $request, Response $response) {

  $db = new DbOperationHomework;
  $homework = $db->getHomeworkById();
  $response_data = array();
  $response_data['homework'] = $homework;

  if ($homework) {
    $response_data['error'] = false;
    $response_data['homework'] = $homework;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Homework - GET 
$app->get('/homework/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationHomework;
  $homework = $db->getHomeworkById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($homework) {
    $response_data['error'] = false;
    $response_data['homework'] = $homework;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Homework - PUT 
$app->put('/homework/{id}', function (Request $request, Response $response, array $args) {

  $homework_id = $args['id'];
  if (!haveEmptyParametrs(array('class_id', 'teacher_id', 'course_id', 'homework'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $class_id = $request_data['class_id'];
    $teacher_id = $request_data['teacher_id'];
    $course_id = $request_data['course_id'];
    $homework = $request_data['homework'];
   
    $db = new DbOperationHomework;
    if ($db->updateHomework($homework_id, $class_id, $teacher_id, $course_id, $homework)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Homework updated successfully';
      $homework = $db->getHomeworkById($homework_id);
      $response_data['homework'] = $homework;
      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'Please try again later';

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

// Delete Homework - DELETE 
$app->delete('/homework/{id}', function (Request $request, Response $response, array $args) {
  $homework_id = $args['id'];
  $db = new DbOperationHomework;
  if ($db->deleteHomework($homework_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Homework has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});