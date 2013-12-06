<?php

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;

class IndexControllerProvider implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $before = function (Request $request, Application $app) {
                    $token = $app['session']->get('token');
                    if (!$token) {
                        return $app->redirect($app->url('login'));
                    }
                };

        $controllers->get('/', function (Application $app) {
                    return $app['twig']->render('index.twig');
                })->before($before)->bind('index');

        return $controllers;
    }

}