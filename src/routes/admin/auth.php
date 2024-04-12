<?php

use App\Lib\JWTAuth;
use App\Repository\AdminRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post("/auth/admins", function (Request $request, Response $response) {
  if(!haveEmptyParametrs(['email', 'password'], $request, $response)) {
    $res["error"] = true;
    $res["message"] = "Incorrect Email or Password";
  
    $body = $request->getParsedBody();
  
    $repo = new AdminRepository();
  
    if ($admin = $repo->loginAdmin($body['email'], $body['password'])) {
      $token = JWTAuth::getToken($admin['admin_id'], $admin['email'], true);
      $res["token"] = $token;
      $res["error"] = false;
      $res["message"] = "Login in Successfully!";
    }
    $response->getBody()->write(json_encode($res));
  }
  return $response
  ->withStatus(200)
  ->withHeader("Content-type", "application/json");
});