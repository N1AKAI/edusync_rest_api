<?php

use App\Common\JsonResponse;
use App\Lib\JWTAuth;
use App\Repository\AbsentStudentsRepository;
use App\Repository\AnswerRepository;
use App\Repository\AttendanceRepository;
use App\Repository\ClassRepository;
use App\Repository\FeeRepository;
use App\Repository\HomeworkRepository;
use App\Repository\QuestionRepository;
use App\Repository\StudentHomeworkRepository;
use App\Repository\StudentRepository;
use App\Repository\TestOnlineRepository;
use App\Repository\TestOnlineStudentRepository;
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

$app->post("/student/homeworks", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $reqData = $request->getParsedBody();
  $reqData['student_id'] = $data->id;

  $msg['error'] = true;
  $msg['message'] = "Something went wrong!";
  $status = 422;

  $repo = new StudentHomeworkRepository();
  if ($id = $repo->create($reqData)) {
    $msg['error'] = false;
    $msg['message'] = "Checked successfully!";
    $msg['id'] = $id;
    $status = 201;
  }

  return JsonResponse::send($response, $msg, $status);
});

$app->delete("/student/homeworks/{id}", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $id = $args['id'];

  $msg['error'] = true;
  $msg['message'] = "Something went wrong!";
  $status = 422;

  $repo = new StudentHomeworkRepository();
  if ($repo->delete($id)) {
    $msg['error'] = false;
    $msg['message'] = "Unchecked successfully!";
    $status = 201;
  }

  return JsonResponse::send($response, $msg, $status);
});

$app->get("/student/absents", function (Request $request, Response $response, array $args) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new AbsentStudentsRepository();
  $absents = $repo->getStudentsAbsent($data->id);

  return JsonResponse::send($response, $absents);
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

$app->post("/student/exams/{id}", function (Request $request, Response $response, array $args) {
  $res["error"] = true;
  $res["message"] = "Something went wrong!";
  $status = 200;


  $id = $args['id'];

  $data = $request->getParsedBody();
  $score = 0;
  $repo = new AnswerRepository();

  foreach ($data as $key => $value) {
    if ($mark = $repo->isAnswerCorrect($key, $value)) {
      $score += $mark;
    }
  }

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new TestOnlineStudentRepository();
  if ($repo->submit($data->id, $id, $score)) {
    $res["error"] = false;
    $res["message"] = "Your score is $score";
    $status = 201;
  }

  $response->getBody()->write(json_encode($res));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus($status);
});
