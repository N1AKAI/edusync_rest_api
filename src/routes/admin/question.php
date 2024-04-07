<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create Question - POST 
$app->post('/questions', function (Request $request, Response $response) {

  $required_params = ['test_online_id', 'question'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $test_online_id = $request_data['test_online_id'];
  $question = $request_data['question'];

  $db = new DbOperationQuestion();
  $result = $db->createQuestion($test_online_id, $question);

  if ($result == QUESTION_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Question created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == QUESTION_FAILURE) {
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

// All Questions - GET  
$app->get('/questions', function (Request $request, Response $response) {

  $db = new DbOperationQuestion;
  $questions = $db->getQuestionById();
  $response_data = array();
  $response_data['questions'] = $questions;

  if ($questions) {
    $response_data['error'] = false;
    $response_data['questions'] = $questions;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Question - GET 
$app->get('/questions/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationQuestion;
  $question = $db->getQuestionById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($question) {
    $response_data['error'] = false;
    $response_data['question'] = $question;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Question - PUT 
$app->put('/questions/{id}', function (Request $request, Response $response, array $args) {

  $question_id = $args['id'];
  if (!haveEmptyParametrs(array('test_online_id', 'question'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $test_online_id = $request_data['test_online_id'];
    $question = $request_data['question'];
   
    $db = new DbOperationQuestion;
    if ($db->updateQuestion($question_id, $test_online_id, $question)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Question updated successfully';
      $question = $db->getQuestionById($question_id);
      $response_data['question'] = $question;
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

// Delete Question - DELETE 
$app->delete('/questions/{id}', function (Request $request, Response $response, array $args) {
  $question_id = $args['id'];
  $db = new DbOperationQuestion;
  if ($db->deleteQuestion($question_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Question has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});