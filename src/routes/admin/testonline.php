<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Test Online - POST 
$app->post('/test_online', function (Request $request, Response $response) {

  $required_params = ['class_id', 'duration', 'score'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $class_id = $request_data['class_id'];
  $duration = $request_data['duration'];
  $score = $request_data['score'];

  $db = new DbOperationTestOnline();
  $result = $db->createTestOnline($class_id, $duration, $score);

  if ($result == TEST_ONLINE_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Test Online created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == TEST_ONLINE_FAILURE) {
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

// All Test Online - GET  
$app->get('/test_online', function (Request $request, Response $response) {

  $db = new DbOperationTestOnline;
  $test_online = $db->getTestOnlineById();
  $response_data = array();
  $response_data['test_online'] = $test_online;

  if ($test_online) {
    $response_data['error'] = false;
    $response_data['test_online'] = $test_online;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Test Online - GET 
$app->get('/test_online/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationTestOnline;
  $test_online = $db->getTestOnlineById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($test_online) {
    $response_data['error'] = false;
    $response_data['test_online'] = $test_online;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Test Online - PUT 
$app->put('/test_online/{id}', function (Request $request, Response $response, array $args) {

  $test_online_id = $args['id'];
  if (!haveEmptyParametrs(array('class_id', 'duration', 'score'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $class_id = $request_data['class_id'];
    $duration = $request_data['duration'];
    $score = $request_data['score'];
   
    $db = new DbOperationTestOnline;
    if ($db->updateTestOnline($test_online_id, $class_id, $duration, $score)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Test Online updated successfully';
      $test_online = $db->getTestOnlineById($test_online_id);
      $response_data['test_online'] = $test_online;
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

// Delete Test Online - DELETE 
$app->delete('/test_online/{id}', function (Request $request, Response $response, array $args) {
  $test_online_id = $args['id'];
  $db = new DbOperationTestOnline;
  if ($db->deleteTestOnline($test_online_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Test Online has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});