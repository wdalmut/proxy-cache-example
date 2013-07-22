<?php
require __DIR__ . '/../vendor/autoload.php';

define("PROD", 1);

$conf = include __DIR__ . '/../configs/app.php';
$app = new UpCloo\App($conf);
$app->run();
