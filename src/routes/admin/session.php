<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Session - POST 
$app->post('/sessions', function (Request $request, Response $response) {

  $required_params = ['session_time'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $session_time = $request_data['session_time'];

  $db = new DbOperationSession();
  $result = $db->createSession($session_time);

  if ($result == SESSION_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Session created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == SESSION_FAILURE) {
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

// All Sessions - GET  
$app->get('/sessions', function (Request $request, Response $response) {

  $db = new DbOperationSession;
  $sessions = $db->getSessionById();
  $response_data = array();
  $response_data['sessions'] = $sessions;

  if ($sessions) {
    $response_data['error'] = false;
    $response_data['sessions'] = $sessions;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Session - GET 
$app->get('/sessions/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationSession;
  $session = $db->getSessionById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($session) {
    $response_data['error'] = false;
    $response_data['session'] = $session;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Session - PUT 
$app->put('/sessions/{id}', function (Request $request, Response $response, array $args) {

  $session_id = $args['id'];
  if (!haveEmptyParametrs(array('session_time'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $session_time = $request_data['session_time'];
   
    $db = new DbOperationSession;
    if ($db->updateSession($session_id, $session_time)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Session updated successfully';
      $session = $db->getSessionById($session_id);
      $response_data['session'] = $session;
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

// Delete Session - DELETE 
$app->delete('/sessions/{id}', function (Request $request, Response $response, array $args) {
  $session_id = $args['id'];
  $db = new DbOperationSession;
  if ($db->deleteSession($session_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Session has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});