<?php

use App\Lib\JWTAuth;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;

$restrictRoutesMiddleware = function (Request $request, RequestHandler $handler): Response {
  $route = $request->getUri()->getPath();
  $response = new SlimResponse();

  // Ignore these routes
  switch ($route) {
    case '/auth/students':
    case '/auth/admins':
    case '/forget-password/student':
    case '/very-otp/student':
    case '/change-password/student':
      return $handler->handle($request);
      break;
  }

  try {
    // Check if token exists
    $token = $request->getHeaderLine('Authorization');
    if (empty($token)) {
      throw new Exception();
    }

    $token = str_replace("Bearer ", "", $token);

    // Validate token
    if (JWTAuth::verifyToken($token)) {
      return $handler->handle($request);
    }
    throw new Exception();
  } catch (Exception $e) {
    $response
      ->getBody()
      ->write(json_encode(['error' => 'true', 'message' => 'You are not authorized']));
    return $response
      ->withStatus(401)
      ->withHeader('Content-type', 'application/json');
  }
};
