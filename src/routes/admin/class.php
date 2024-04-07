<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Class - POST 
$app->post('/classes', function (Request $request, Response $response, $args) {

  $required_params = ['class_name', 'year', 'remarks', 'teacher_id'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $class_name = $request_data['class_name'];
  $year = $request_data['year'];
  $remarks = $request_data['remarks'];
  $teacher_id = $request_data['teacher_id'];

  $db = new DbOperationClass();
  $result = $db->createClass($class_name, $year,$remarks,$teacher_id);

  if ($result == CLASS_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Class created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == CLASS_FAILURE) {
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

// All Class - GET  
$app->get('/classes', function (Request $request, Response $response) {

  $db = new DbOperationClass;
  $classes = $db->getClassById();
  $response_data = array();
  $response_data['error'] = true;

  if ($classes) {
    $response_data['error'] = false;
    $response_data['classes'] = $classes;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Class - GET 
$app->get('/classes/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationClass;
  $class = $db->getClassById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($class) {
    $response_data['error'] = false;
    $response_data['class'] = $class;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Class - PUT 
$app->put('/classes/{id}', function (Request $request, Response $response, array $args) {

  $class_id = $args['id'];
  if (!haveEmptyParametrs(array( 'class_name', 'year', 'remarks', 'teacher_id' , 'class_id'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $class_name = $request_data['class_name'];
    $year = $request_data['year'];
    $remarks = $request_data['remarks'];
    $teacher_id = $request_data['teacher_id'];

    $db = new DbOperationClass;
    if ($db->updateClass($class_name, $year,$remarks,$teacher_id ,$class_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Class updated Successfelly';
      $class = $db->getClassById($class_id);
      $response_data['class'] = $class;
      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'Please try agin later';

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
// Delete Class - DELETE 
$app->delete('/classes/{id}', function (Request $request, Response $response, array $args) {
  $class_id = $args['id'];
  $db = new DbOperationClass;
  if ($db->deleteClass($class_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Class has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
