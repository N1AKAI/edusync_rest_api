<?php

namespace App\Lib;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{

  public static function getToken($id, $email)
  {
    $secret = SECRET_KEY;

    $now = date('Y-m-d H:i:s');
    $exp = date('Y-m-d H:i:s', mktime(date('H') + 1));

    $token = [
      'header'  => [
        'id' => $id,
        'email' => $email
      ],
      'payload' => [
        'iat' => $now, // Start time
        'exp' => $exp // Expires after 1 hour
      ]
    ];

    return JWT::encode($token, $secret, 'HS256');
  }

  public static function verifyToken($token)
  {
    $secret = SECRET_KEY;

    $obj = JWT::decode($token, new Key($secret, 'HS256'));

    if (isset($obj->payload)) {
      $now = strtotime(date("Y-m-d H:i:s"));
      $exp = strtotime($obj->payload->exp);
      if ($now < $exp) {
        return $obj;
      }
    }

    return false;
  }

  public static function getData($token)
  {
    $secret = SECRET_KEY;
    $obj = JWT::decode($token, new Key($secret, 'HS256'));

    return $obj->header;
  }
}
