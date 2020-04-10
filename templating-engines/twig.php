<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/TestEntity.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('templates/twig');
$twig = new Environment($loader, [
    'cache' => false,
]);

$entity = new TestEntity();

$contents = file_get_contents('data/data.json');
$testData = json_decode($contents);

echo $twig->render('content.twig', ['data' => $testData, 'entity' => $entity]);

