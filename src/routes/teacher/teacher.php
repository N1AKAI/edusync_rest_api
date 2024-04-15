<?php

use App\Lib\JWTAuth;
use App\Repository\ClassRepository;
use App\Repository\TeacherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get("/teacher/show", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new TeacherRepository;
  $student = $repo->getTeacherAndTheirClassesByEmail($data->email);

  $response->getBody()->write(json_encode($student));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});

$app->get("/teacher/classes", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new ClassRepository;
  $classes = $repo->getTeachersClasses($data->id);

  $response->getBody()->write(json_encode($classes));

  return $response
    ->withHeader('Content-type', 'application/json')
    ->withStatus(200);
});
