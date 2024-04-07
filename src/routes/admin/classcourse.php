<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/classcourses', function (Request $request, Response $response, $args) {

  $required_params = ['class_id', 'course_id'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $class_id = $request_data['class_id'];
  $course_id = $request_data['course_id'];

  $db = new DbOperationClassCourse();
  $result = $db->createClassCourse($class_id, $course_id);

  if ($result == CLASS_COURSE_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Class_Course created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == CLASS_COURSE_FAILURE) {
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

// All Class_Course - GET  
$app->get('/classecourses', function (Request $request, Response $response) {

  $db = new DbOperationClassCourse;
  $classecourses = $db->getClassCourseById();
  $response_data = array();
  $response_data['classecourses'] = $classecourses;

  if ($classecourses) {
    $response_data['error'] = false;
    $response_data['classecourses'] = $classecourses;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Class_Course - GET 
$app->get('/classcourses/{id}', function (Request $request, Response $response, array $args) {

  $db = new DbOperationClassCourse;
  $classcourse = $db->getClassCourseById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($classcourse) {
    $response_data['error'] = false;
    $response_data['classcourse'] = $classcourse;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Class_Cours - PUT 
$app->put('/classcoures/{id}', function (Request $request, Response $response, array $args) {

  $class_course_id = $args['id'];
  if (!haveEmptyParametrs(array('class_id', 'course_id'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $class_id = $request_data['class_id'];
    $course_id = $request_data['course_id'];
   
    $db = new DbOperationClassCourse;
    if ($db->updateClassCourse($class_course_id, $class_id, $course_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Class_Course updated Successfelly';
      $classcourse = $db->getClassCourseById($class_course_id);
      $response_data['class'] = $classcourse;
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
// Delete Class_Course - DELETE 
$app->delete('/classcourses/{id}', function (Request $request, Response $response, array $args) {
  $class_course_id = $args['id'];
  $db = new DbOperationClassCourse;
  if ($db->deleteClassCourse($class_course_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Class_Course has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});