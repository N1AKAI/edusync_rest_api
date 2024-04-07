<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create test - POST ✔️
$app->post('/tests', function (Request $request, Response $response, $args) {

  $required_params = ['test_code', 'mark', 'student_id', 'course_id'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $test_code = $request_data['test_code'];
  $mark = $request_data['mark'];
  $student_id = $request_data['student_id'];
  $course_id = $request_data['course_id'];

  $db = new DbOperationTest();
  $result = $db->createTest($test_code, $mark, $student_id, $course_id);

  if ($result == TEST_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Test created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == TEST_FAILURE) {
    $message = [
      'error' => true,
      'message' => 'Some error occurred'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(422);
  } elseif ($result == TEST_EXIST) {
    $message = [
      'error' => false,
      'message' => 'Test Already Exists'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(422);
  }
});

// All test - GET ✔️
$app->get('/tests', function (Request $request, Response $response) {

  $db = new DbOperationTest;
  $tests = $db->getTestById();
  $response_data = array();
  $response_data['error'] = true;
  if ($tests) {
    $response_data['error'] = false;
    $response_data['tests'] = $tests;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single test - GET ✔️
$app->get('/tests/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationTest;
  $test = $db->getTestById($args['id']);
  $response_data = array();
  $response_data['error'] = true;
  if ($test) {
    $response_data['error'] = false;
    $response_data['test'] = $test;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update test - PUT ✔️
$app->put('/tests/{id}', function (Request $request, Response $response, array $args) {

  $test_id = $args['id'];
  if (!haveEmptyParametrs(array('test_code', 'mark', 'student_id', 'course_id'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $test_code = $request_data['test_code'];
    $mark = $request_data['mark'];
    $student_id = $request_data['student_id'];
    $course_id = $request_data['course_id'];

    $db = new DbOperationTest;
    if ($db->updateTest($test_id, $test_code, $mark, $student_id, $course_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Test updated Successfelly';
      $test = $db->getTestById($test_id);

      $response_data['test'] = $test;
      $response->getBody()->write(json_encode($response_data));
      return $response
        ->withHeader('Content-type', 'application/json')
        ->withStatus(200);
    } else {
      $response_data = array();
      $response_data['error'] = true;
      $response_data['message'] = 'Please try agin later';
      $test = $db->getTestById($test_id);

      $response_data['test'] = $test;
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
// Delete test - DELETE ✔️
$app->delete('/tests/{id}', function (Request $request, Response $response, array $args) {
  $test_id = $args['id'];
  $db = new DbOperationTest;
  if ($db->deleteTest($test_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Test has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});