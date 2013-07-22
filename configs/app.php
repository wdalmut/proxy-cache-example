<?php

return array_merge(
    array(),
    include __DIR__ . '/../configs/app_dev.php',
    (defined("PROD") ? include __DIR__ . '/../configs/app_prod.php': array())
);

