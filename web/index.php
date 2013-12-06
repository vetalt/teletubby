<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();

$app['debug'] = true;

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
    'twig.options' => array(
        'auto_reload' => true,
        'strict_variables' => false
    ),
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new MarcW\Silex\Provider\BuzzServiceProvider());

$app->mount('/', new IndexControllerProvider());

$app->mount('/login', new LoginControllerProvider());

$app->run();
