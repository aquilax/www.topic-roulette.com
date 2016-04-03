#!/usr/bin/env php
<?php
// application.php

require __DIR__ . '/../vendor/autoload.php';

use Topic\Command\AddCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new AddCommand());
$application->run();
