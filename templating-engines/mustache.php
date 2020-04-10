<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/TestEntity.php';

$mustache = new Mustache_Engine(array(
    'template_class_prefix' => '__MyTemplates_',
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates/mustache'),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/templates/mustache/partials'),
    'helpers' => array('lang' => function($text) {
        return 'Lang: '.strtoupper($text);
    }),
    'escape' => function($value) {
        return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
    },
    'charset' => 'ISO-8859-1',
    'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
    'strict_callables' => true,
    'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
));

$entity = new TestEntity();

$contents = file_get_contents('data/data.json');
$testData = json_decode($contents);

$tpl = $mustache->loadTemplate('main');
echo $tpl->render(['data' => $testData, 'entity' => $entity]);