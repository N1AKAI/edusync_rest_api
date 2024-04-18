<?php

use App\Repository\CourseRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/courses', function (Request $request, Response $response, $args) {

  $required_params = ['course_name', 'course_code'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $request_data = $request->getParsedBody();

  $course_name = $request_data['course_name'];
  $course_code = $request_data['course_code'];

  $db = new CourseRepository();
  $result = $db->createCourse($course_name, $course_code);

  if ($result == COURSE_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Course created successfully'
    ];
    $response->getBody()->write(json_encode($message));
    return $response
      ->withHeader('Content-type', 'application/json')
      ->withStatus(201);
  } elseif ($result == COURSE_FAILUARE) {
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

// All Courses - GET  ✔️
$app->get('/courses', function (Request $request, Response $response) {

  $db = new CourseRepository;
  $courses = $db->getCourseById();
  $response_data = array();
  $response_data['error'] = true;

  if ($courses) {
    $response_data['error'] = false;
    $response_data['courses'] = $courses;
  }


  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Single Course - GET ✔️
$app->get('/courses/{id}', function (Request $request, Response $response, array $args) {

  $db = new CourseRepository;
  $course = $db->getCourseById($args['id']);
  $response_data = array();
  $response_data['error'] = true;

  if ($course) {
    $response_data['error'] = false;
    $response_data['course'] = $course;
  }

  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

// Update Course - PUT ✔️
$app->put('/courses/{id}', function (Request $request, Response $response, array $args) {

  $course_id = $args['id'];
  if (!haveEmptyParametrs(array('course_name', 'course_code'), $request, $response)) {
    $request_data = $request->getParsedBody();

    $course_name = $request_data['course_name'];
    $course_code = $request_data['course_code'];

    $db = new CourseRepository;
    if ($db->updateCourse($course_name, $course_code, $course_id)) {

      $response_data = array();
      $response_data['error'] = false;
      $response_data['message'] = 'Course updated Successfelly';
      $course = $db->getCourseById($course_id);
      $response_data['course'] = $course;
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
// Delete course - DELETE ✔️
$app->delete('/courses/{id}', function (Request $request, Response $response, array $args) {
  $course_id = $args['id'];
  $db = new CourseRepository;
  if ($db->deleteCourse($course_id)) {
    $response_data['error'] = false;
    $response_data['message'] = 'Course has been deleted';
  } else {
    $response_data['error'] = true;
    $response_data['message'] = 'Please try again later';
  }
  $response->getBody()->write(json_encode($response_data));
  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
