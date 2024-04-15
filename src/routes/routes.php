<?php


$folders = array_diff(scandir(__DIR__), array('..', '.'));

foreach ($folders as $folder) {
  $routeFolderDir = __DIR__ . "/" . $folder;
  if (is_dir($routeFolderDir)) {
    $routeFiles = array_diff(scandir($routeFolderDir), array('..', '.'));
    foreach ($routeFiles as $file) {
      $filePath = $routeFolderDir . '/' . $file;
      if (is_file($filePath)) {
        require_once $filePath;
      }
    }
  }
}
