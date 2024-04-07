<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Create answer - POST 
$app->post('/answers', function (Request $request, Response $response, $args) {

  $required_params = ['is_correct', 'question_id'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $is_correct = $request_data['is_correct'];
  $question_id = $request_data['question_id'];

  $db = new DbOperationAnswer();
  $result = $db->createAnswer($is_correct, $question_id);

  if ($result == ANSWER_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Answer created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == ANSWER_FAILURE) {
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

// All answers - GET  
$app->get('/answers', function (Request $request, Response $response) {

  $db = new DbOperationAnswer;
  $answers = $db->getAnswerById();
  $response_data = array();
  $response_data['error'] = true;

  if ($answers) {
    $response_data['error'] = false;
    $response_data['answers'] = $answers;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Answers - GET
$app->get('/answers/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationAnswer;
  $answer = $db->getAnswerById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($answer) {
    $response_data['error'] = false;
    $response_data['answer'] = $answer;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Answer - PUT 
$app->put('/answers/{id}', function (Request $request, Response $response, array $args) {

  $answer_id = $args['id'];
  if (!haveEmptyParametrs(array('is_correct', 'question_id'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $is_correct = $request_data['is_correct'];
    $question_id = $request_data['question_id'];

    $db = new DbOperationAnswer;
    if ($db->updateAnswer($is_correct, $question_id, $answer_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Answer updated Successfelly';
      $answer = $db->getAnswerById($answer_id);
      $response_data['answer'] = $answer;
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
// Delete Answer - DELETE 
$app->delete('/answers/{id}', function (Request $request, Response $response, array $args) {
  $answer_id = $args['id'];
  $db = new DbOperationAnswer;
  if ($db->deleteAnswer($answer_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Answer has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
