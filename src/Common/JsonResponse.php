<?php

namespace App\Common;

class JsonResponse
{
  public static function send($response, array $data, $status = 200)
  {
    $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
    return $response->withHeader('Content-type', 'application/json')->withStatus($status);
  }
}