<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Report Card - POST 
$app->post('/report_cards', function (Request $request, Response $response) {

  $required_params = ['student_id', 'teacher_remark', 'teacher_id'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $student_id = $request_data['student_id'];
  $teacher_remark = $request_data['teacher_remark'];
  $teacher_id = $request_data['teacher_id'];

  $db = new DbOperationReportCard();
  $result = $db->createReportCard($student_id, $teacher_remark, $teacher_id);

  if ($result == REPORT_CARD_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Report Card created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == REPORT_CARD_FAILURE) {
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

// All Report Cards - GET  
$app->get('/report_cards', function (Request $request, Response $response) {

  $db = new DbOperationReportCard;
  $report_cards = $db->getReportCardById();
  $response_data = array();
  $response_data['report_cards'] = $report_cards;

  if ($report_cards) {
    $response_data['error'] = false;
    $response_data['report_cards'] = $report_cards;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Report Card - GET 
$app->get('/report_cards/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationReportCard;
  $report_card = $db->getReportCardById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($report_card) {
    $response_data['error'] = false;
    $response_data['report_card'] = $report_card;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Report Card - PUT 
$app->put('/report_cards/{id}', function (Request $request, Response $response, array $args) {

  $report_card_id = $args['id'];
  if (!haveEmptyParametrs(array('student_id', 'teacher_remark', 'teacher_id'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $student_id = $request_data['student_id'];
    $teacher_remark = $request_data['teacher_remark'];
    $teacher_id = $request_data['teacher_id'];
   
    $db = new DbOperationReportCard;
    if ($db->updateReportCard($report_card_id, $student_id, $teacher_remark, $teacher_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Report Card updated successfully';
      $report_card = $db->getReportCardById($report_card_id);
      $response_data['report_card'] = $report_card;
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

// Delete Report Card - DELETE 
$app->delete('/report_cards/{id}', function (Request $request, Response $response, array $args) {
  $report_card_id = $args['id'];
  $db = new DbOperationReportCard;
  if ($db->deleteReportCard($report_card_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Report Card has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});