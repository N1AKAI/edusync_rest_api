<?php

use App\Common\JsonResponse;
use App\Lib\JWTAuth;
use App\Repository\ClassRepository;
use App\Repository\HomeworkRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get("/teacher/show", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new TeacherRepository;
  $student = $repo->getTeacherAndTheirClassesByEmail($data->email);

  return JsonResponse::send($response, $student);
});

$app->get("/teacher/classes", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new ClassRepository;
  $classes = $repo->getTeachersClasses($data->id);

  return JsonResponse::send($response, $classes);
});

$app->get("/teacher/homeworks", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new HomeworkRepository;
  $homeworks = $repo->getTeachersHomeworks($data->id);

  return JsonResponse::send($response, $homeworks);
});

$app->get("/teacher/class/{classId}/homeworks/{homeworkId}", function (Request $request, Response $response, array $args) {

  $classId = $args['classId'];
  $homeworkId = $args['homeworkId'];

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new StudentRepository;
  $students = $repo->getAllClassStudentsHomework($classId, $homeworkId, $data->id);

  return JsonResponse::send($response, $students);
});

$app->post("/teacher/homeworks", function (Request $request, Response $response, array $args) {

  $data = $request->getParsedBody();

  $msg['error'] = true;
  $msg['message'] = "Something went wrong!";
  $status = 200;
  $repo = new HomeworkRepository;
  if ($repo->create($data)) {
    $msg['error'] = false;
    $msg['message'] = "Created successfully!";
    $status = 201;
  }

  return JsonResponse::send($response, $msg, $status);
});
