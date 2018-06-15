<?php

// echo "Welcome to mini-blog!";
// exit;

require '../bootstrap.php';
require '../MiniBlogApplication.php';

$app = new MiniBlogApplication(true);
$app->run();