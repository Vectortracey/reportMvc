<?php

declare(strict_types=1);

require_once __DIR__ . '/tools/php-cs-fixer/vendor/autoload.php';

$finder = PhpCsFixer\Finder::create();

$config = new PhpCsFixer\Config();
$config->setFinder($finder);

return $config;
