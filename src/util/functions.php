<?php

function haveEmptyParametrs($required_params, $request, $response)
{
  $error = false;
  $error_params = '';
  $request_params = $request->getParsedBody();
  // $request_params = $_REQUEST;
  foreach ($required_params as $param) {
    if (!isset($request_params[$param]) || strlen($request_params[$param]) <= 0) {
      $error = true;
      $error_params .= $param . ', ';
    }
  }
  if ($error) {
    $error_detail = [
      'error' => true,
      'message' => 'Required parameters ' . substr($error_params, 0, -2) . ' are missing or empty'
    ];
    $response->getBody()->write(json_encode($error_detail));
  }
  return $error;
}