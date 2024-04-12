<?php

use App\Lib\JWTAuth;
use App\Repository\AttendanceRepository;
use App\Repository\ClassRepository;
use App\Repository\FeeRepository;
use App\Repository\HomeworkRepository;
use App\Repository\QuestionRepository;
use App\Repository\StudentRepository;
use App\Repository\TestOnlineRepository;
use App\Repository\TestRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get("/student/show", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new StudentRepository;
  $student = $repo->getStudentAndTheirClassByEmail($data->email);

  $response->getBody()->write(json_encode($student));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get("/student/tests", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new TestRepository();
  $tests = $repo->getLatestTestsByStudentEmail($data->email);

  $response->getBody()->write(json_encode($tests));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get("/student/homeworks", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new HomeworkRepository();
  $homeworks = $repo->getAllHomeWorkByStudent($data->id);

  $response->getBody()->write(json_encode($homeworks));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get("/student/attendances", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new AttendanceRepository();
  $attendances = $repo->getStudentsAttendace($data->id);

  $response->getBody()->write(json_encode($attendances));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get("/student/fees", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new FeeRepository();
  $fees = $repo->getStudentsFees($data->id);

  $response->getBody()->write(json_encode($fees));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get("/student/exams", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new TestOnlineRepository();
  $tests = $repo->getTestsOnline($data->id);

  $response->getBody()->write(json_encode($tests));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get("/student/exams/{id}/questions", function (Request $request, Response $response, array $args) {

  $id = $args['id'];

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new QuestionRepository();
  $questions = $repo->getQuestions($id, $data->id);

  $response->getBody()->write(json_encode($questions));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->put("/student/exams/{id}", function (Request $request, Response $response, array $args) {

  $id = $args['id'];

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new TestOnlineRepository();
  $questions = $repo->submit();

  $response->getBody()->write(json_encode($questions));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
