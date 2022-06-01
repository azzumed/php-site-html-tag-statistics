<?php

require __DIR__ . '/../../vendor/autoload.php';

require __DIR__ . '/config.php';

function dd(...$args) {
    var_dump(...$args);
    die;
}