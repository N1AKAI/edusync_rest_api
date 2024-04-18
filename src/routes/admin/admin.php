<?php

use App\Common\JsonResponse;
use App\Lib\JWTAuth;
use App\Repository\AdminRepository;
use App\Repository\ClassRepository;
use App\Repository\FeeRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get("/admin/show", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $repo = new AdminRepository;
  $admin = $repo->fetch($data->id);
  return JsonResponse::send($response, $admin);
});

$app->get("/admin/statistic", function (Request $request, Response $response) {

  $token = str_replace("Bearer ", "", $request->getHeaderLine('Authorization'));
  $data = JWTAuth::getData($token);

  $res = [];

  $repo = new StudentRepository;
  $res['students'] = $repo->count();

  $repo = new TeacherRepository;
  $res['teachers'] = $repo->count();

  $repo = new ClassRepository;
  $res['classes'] = $repo->count();

  $repo = new FeeRepository;
  $res['revenue'] = $repo->totalRevenue();

  return JsonResponse::send($response, $res);
});