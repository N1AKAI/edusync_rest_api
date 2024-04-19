<?php

use App\Common\JsonResponse;
use App\Repository\CourseRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/courses', function (Request $request, Response $response, $args) {

  $required_params = ['course_name', 'course_code'];
  if (haveEmptyParametrs($required_params, $request, $response)) {
    return $response->withStatus(422);
  }

  $data = $request->getParsedBody();

  $db = new CourseRepository();
  $result = $db->create($data);
  $message = [];
  if ($result == COURSE_CREATED) {
    $message = [
      'error' => false,
      'message' => 'Course created successfully'
    ];
  } elseif ($result == COURSE_FAILUARE) {
    $message = [
      'error' => true,
      'message' => 'Some error occurred'
    ];
  }
  return JsonResponse::send($response, $message);
});

// All Courses - GET  ✔️
$app->get('/courses', function (Request $request, Response $response) {

  $repo = new CourseRepository;
  $courses = $repo->fetchAll();

  print_r($courses);

  return JsonResponse::send($response, $courses);
});

// Single Course - GET ✔️
$app->get('/courses/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];

  $db = new CourseRepository;
  $course = $db->fetch($id);

  return JsonResponse::send($response, $course);
});

// Update Course - PUT ✔️
$app->put('/courses/{id}', function (Request $request, Response $response, array $args) {

  $course_id = $args['id'];

  $data = $request->getParsedBody();
  $msg = [];
  $db = new CourseRepository;
  if ($db->update($course_id, $data)) {
    $msg['error'] = false;
    $msg['message'] = 'Course updated Successfelly';
  } else {
    $msg = array();
    $msg['error'] = true;
    $msg['message'] = 'Please try agin later';
  }
  return JsonResponse::send($response, $msg);
});

// Delete course - DELETE ✔️
$app->delete('/courses/{id}', function (Request $request, Response $response, array $args) {
  $course_id = $args['id'];
  $db = new CourseRepository;

  $msg['error'] = true;
  $msg['message'] = 'Please try again later';
  if ($db->delete($course_id)) {
    $msg['error'] = false;
    $msg['message'] = 'Course has been deleted';
  }
  return JsonResponse::send($response, $msg);
});
