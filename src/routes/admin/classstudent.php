<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/classstudents', function (Request $request, Response $response, $args) {

$required_params = ['class_id', 'student_id'];
if (haveEmptyParametrs($required_params, $request, $response)) {
  return $response->withStatus(422);
}

$request_data = $request->getParsedBody();

$class_id = $request_data['class_id'];
$student_id = $request_data['student_id'];

$db = new DbOperationClassStudent();
$result = $db->createClassStudent($class_id, $student_id);

if ($result == CLASS_STUDENT_CREATED) {
  $message = [
    'error' => false,
    'message' => 'Class_Student created successfully'
  ];
  $response->getBody()->write(json_encode($message));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(201);
} elseif ($result == CLASS_STUDENT_FAILURE) {
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

// All Class_Student - GET  
$app->get('/classstudents', function (Request $request, Response $response) {

$db = new DbOperationClassStudent;
$classstudents = $db->getClassStudentById();
$response_data = array();
$response_data['classstudents'] = $classstudents;

if ($classstudents) {
  $response_data['error'] = false;
  $response_data['classstudents'] = $classstudents;
}


$response->getBody()->write(json_encode($response_data));
return $response
  ->withHeader('Content-type', 'application/json')
  ->withStatus(200);
});

// Single Class_Student - GET 
$app->get('/classstudents/{id}', function (Request $request, Response $response, array $args) {

$db = new DbOperationClassStudent;
$classstudent = $db->getClassStudentById($args['id']);
$response_data = array();
$response_data['error'] = true;

if ($classstudent) {
  $response_data['error'] = false;
  $response_data['classstudent'] = $classstudent;
}

$response->getBody()->write(json_encode($response_data));
return $response
  ->withHeader('Content-type', 'application/json')
  ->withStatus(200);
});

// Update Class_Student - PUT 
$app->put('/classstudents/{id}', function (Request $request, Response $response, array $args) {

$class_student_id = $args['id'];
if (!haveEmptyParametrs(array('class_id', 'student_id'), $request, $response)) {
  $request_data = $request->getParsedBody();

  $class_id = $request_data['class_id'];
  $student_id = $request_data['student_id'];
 
  $db = new DbOperationClassStudent;
  if ($db->updateClassStudent($class_student_id, $class_id, $student_id)) {

    $response_data = array();
    $response_data['error'] = false;
    $response_data['message'] = 'Class_Student updated Successfelly';
    $classstudent = $db->getClassStudentById($class_student_id);
    $response_data['classstudent'] = $classstudent;
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
// Delete Class_Student - DELETE 
$app->delete('/classstudents/{id}', function (Request $request, Response $response, array $args) {
$class_student_id = $args['id'];
$db = new DbOperationClassStudent;
if ($db->deleteClassStudent($class_student_id)) {
  $response_data['error'] = false;
  $response_data['message'] = 'Class_Student has been deleted';
} else {
  $response_data['error'] = true;
  $response_data['message'] = 'Please try again later';
}
$response->getBody()->write(json_encode($response_data));
return $response
  ->withHeader('Content-type', 'application/json')
  ->withStatus(200);
});