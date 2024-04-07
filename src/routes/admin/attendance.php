<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create attendance - POST 
$app->post('/attendances', function (Request $request, Response $response, $args) {

  $required_params = ['date', 'is_present', 'class_id', 'teacher_id', 'session_id'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $date = $request_data['date'];
  $is_present = $request_data['is_present'];
  $class_id = $request_data['class_id'];
  $teacher_id = $request_data['teacher_id'];
  $session_id = $request_data['session_id'];

  $db = new DbOperationAttendance();
  $result = $db->createAttendance($date, $is_present,$class_id,$teacher_id,$session_id);

  if ($result == ATTENDANCE_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Attendance created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == ATTENDANCE_FAILURE) {
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

// All Attendance - GET  
$app->get('/attendances', function (Request $request, Response $response) {

  $db = new DbOperationAttendance;
  $attendances = $db->getAttendanceById();
  $response_data = array();
  $response_data['error'] = true;

  if ($attendances) {
    $response_data['error'] = false;
    $response_data['attendances'] = $attendances;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Attendance - GET 
$app->get('/attendance/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationAttendance;
  $attendance = $db->getAttendanceById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($attendance) {
    $response_data['error'] = false;
    $response_data['attendance'] = $attendance;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Attendance - PUT 
$app->put('/attendances/{id}', function (Request $request, Response $response, array $args) {

  $attendance_id = $args['id'];
  if (!haveEmptyParametrs(array( 'date', 'is_present', 'class_id', 'teacher_id', 'session_id'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $date = $request_data['date'];
    $is_present = $request_data['is_present'];
    $class_id = $request_data['class_id'];
    $teacher_id = $request_data['teacher_id'];
    $session_id = $request_data['session_id'];

    $db = new DbOperationAttendance;
    if ($db->updateAttendance($date, $is_present,$class_id,$teacher_id,$session_id ,$attendance_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Attendance updated Successfelly';
      $attendance = $db->getAttendanceById($attendance_id);
      $response_data['attendance'] = $attendance;
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
// Delete attendance - DELETE 
$app->delete('/attendances/{id}', function (Request $request, Response $response, array $args) {
  $attendance_id = $args['id'];
  $db = new DbOperationAttendance;
  if ($db->deleteAttendance($attendance_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Attendance has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
