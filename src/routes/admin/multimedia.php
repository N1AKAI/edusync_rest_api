<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Multimedia - POST 
$app->post('/multimedia', function (Request $request, Response $response) {

  $required_params = ['file_type', 'size', 'title', 'description', 'class_id', 'resource'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $file_type = $request_data['file_type'];
  $size = $request_data['size'];
  $title = $request_data['title'];
  $description = $request_data['description'];
  $class_id = $request_data['class_id'];
  $resource = $request_data['resource'];

  $db = new DbOperationMultimedia();
  $result = $db->createMultimedia($file_type, $size, $title, $description, $class_id, $resource);

  if ($result == MULTIMEDIA_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Multimedia created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == MULTIMEDIA_FAILURE) {
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

// All Multimedia - GET  
$app->get('/multimedia', function (Request $request, Response $response) {

  $db = new DbOperationMultimedia;
  $multimedia = $db->getMultimediaById();
  $response_data = array();
  $response_data['multimedia'] = $multimedia;

  if ($multimedia) {
    $response_data['error'] = false;
    $response_data['multimedia'] = $multimedia;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Multimedia - GET 
$app->get('/multimedia/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationMultimedia;
  $multimedia = $db->getMultimediaById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($multimedia) {
    $response_data['error'] = false;
    $response_data['multimedia'] = $multimedia;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Multimedia - PUT 
$app->put('/multimedia/{id}', function (Request $request, Response $response, array $args) {

  $multimedia_id = $args['id'];
  if (!haveEmptyParametrs(array('file_type', 'size', 'title', 'description', 'class_id', 'resource'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $file_type = $request_data['file_type'];
    $size = $request_data['size'];
    $title = $request_data['title'];
    $description = $request_data['description'];
    $class_id = $request_data['class_id'];
    $resource = $request_data['resource'];
   
    $db = new DbOperationMultimedia;
    if ($db->updateMultimedia($multimedia_id, $file_type, $size, $title, $description, $class_id, $resource)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Multimedia updated successfully';
      $multimedia = $db->getMultimediaById($multimedia_id);
      $response_data['multimedia'] = $multimedia;
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

// Delete Multimedia - DELETE 
$app->delete('/multimedia/{id}', function (Request $request, Response $response, array $args) {
  $multimedia_id = $args['id'];
  $db = new DbOperationMultimedia;
  if ($db->deleteMultimedia($multimedia_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Multimedia has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
