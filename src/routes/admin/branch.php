<?php

use App\Common\JsonResponse;
use App\Repository\BranchRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/branches', function (Request $request, Response $response, $args) {

  $msg['error'] = true;
  $msg['message'] = "Failed";

  $data = $request->getParsedBody();

  $repo = new BranchRepository;
  if ($repo->create($data)) {
    $msg['error'] = false;
    $msg['message'] = "Branch added successfully";
  }

  return JsonResponse::send($response, $msg);
});

// All Courses - GET  ✔️
$app->get('/branches', function (Request $request, Response $response) {

  $repo = new BranchRepository;
  $branches = $repo->fetchAll();

  return JsonResponse::send($response, $branches);
});

// Single Course - GET ✔️
$app->get('/branches/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];

  $repo = new BranchRepository;
  $branch = $repo->fetch($id);

  return JsonResponse::send($response, $branch);
});

// Update Course - PUT ✔️
$app->put('/branches/{id}', function (Request $request, Response $response, array $args) {

  $id = $args['id'];

  $data = $request->getParsedBody();

  $msg['error'] = true;
  $msg['message'] = 'Please try agin later';

  $db = new BranchRepository;
  if ($db->update($id, $data)) {
    $msg['error'] = false;
    $msg['message'] = 'Branch updated Successfelly';
  }
  return JsonResponse::send($response, $msg);
});

// Delete course - DELETE ✔️
$app->delete('/branches/{id}', function (Request $request, Response $response, array $args) {

  $id = $args['id'];
  $repo = new BranchRepository;

  $msg['error'] = true;
  $msg['message'] = 'Please try again later';

  if ($repo->delete($id)) {
    $msg['error'] = false;
    $msg['message'] = 'Branch has been deleted';
  }
  return JsonResponse::send($response, $msg);
});
