<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Fee - POST 
$app->post('/fees', function (Request $request, Response $response, $args) {

  $required_params = ['student_id', 'fee_description', 'total_fee', 'fee_date', 'is_paid'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $student_id = $request_data['student_id'];
  $fee_description = $request_data['fee_description'];
  $total_fee = $request_data['total_fee'];
  $fee_date = $request_data['fee_date'];
  $is_paid = $request_data['is_paid'];

  $db = new DbOperationFee();
  $result = $db->createFee($student_id, $fee_description, $total_fee, $fee_date, $is_paid);

  if ($result == FEE_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Fee created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == FEE_FAILURE) {
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

// All Fees - GET  
$app->get('/fees', function (Request $request, Response $response) {

  $db = new DbOperationFee;
  $fees = $db->getFeeById();
  $response_data = array();
  $response_data['fees'] = $fees;

  if ($fees) {
    $response_data['error'] = false;
    $response_data['fees'] = $fees;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Fee - GET 
$app->get('/fees/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationFee;
  $fee = $db->getFeeById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($fee) {
    $response_data['error'] = false;
    $response_data['fee'] = $fee;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Fee - PUT 
$app->put('/fees/{id}', function (Request $request, Response $response, array $args) {

  $fee_id = $args['id'];
  if (!haveEmptyParametrs(array('student_id', 'fee_description', 'total_fee', 'fee_date', 'is_paid'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $student_id = $request_data['student_id'];
    $fee_description = $request_data['fee_description'];
    $total_fee = $request_data['total_fee'];
    $fee_date = $request_data['fee_date'];
    $is_paid = $request_data['is_paid'];

    $db = new DbOperationFee;
    if ($db->updateFee($fee_id, $student_id, $fee_description, $total_fee, $fee_date, $is_paid)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Fee updated successfully';
      $fee = $db->getFeeById($fee_id);
      $response_data['fee'] = $fee;
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

// Delete Fee - DELETE 
$app->delete('/fees/{id}', function (Request $request, Response $response, array $args) {
  $fee_id = $args['id'];
  $db = new DbOperationFee;
  if ($db->deleteFee($fee_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Fee has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});