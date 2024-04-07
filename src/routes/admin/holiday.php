<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Holiday - POST 
$app->post('/holidays', function (Request $request, Response $response) {

  $required_params = ['date'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $date = $request_data['date'];

  $db = new DbOperationHoliday();
  $result = $db->createHoliday($date);

  if ($result == HOLIDAY_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Holiday created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == HOLIDAY_FAILURE) {
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

// All Holidays - GET  
$app->get('/holidays', function (Request $request, Response $response) {

  $db = new DbOperationHoliday;
  $holidays = $db->getHolidayById();
  $response_data = array();
  $response_data['holidays'] = $holidays;

  if ($holidays) {
    $response_data['error'] = false;
    $response_data['holidays'] = $holidays;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Holiday - GET 
$app->get('/holidays/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationHoliday;
  $holiday = $db->getHolidayById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($holiday) {
    $response_data['error'] = false;
    $response_data['holiday'] = $holiday;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Holiday - PUT 
$app->put('/holidays/{id}', function (Request $request, Response $response, array $args) {

  $holiday_id = $args['id'];
  if (!haveEmptyParametrs(array('date'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $date = $request_data['date'];
   
    $db = new DbOperationHoliday;
    if ($db->updateHoliday($holiday_id, $date)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Holiday updated Successfully';
      $holiday = $db->getHolidayById($holiday_id);
      $response_data['holiday'] = $holiday;
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
// Delete Holiday - DELETE 
$app->delete('/holidays/{id}', function (Request $request, Response $response, array $args) {
  $holiday_id = $args['id'];
  $db = new DbOperationHoliday;
  if ($db->deleteHoliday($holiday_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Holiday has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});