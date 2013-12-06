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
                    $token = $app['session']->get('token');
                    $resp = $app['buzz']->get('http://vacancy.dev.telehouse-ua.net/media/list', array("X-Auth-Token: {$token}"));
                    if (!$resp->isOk()) {
                        return $app['twig']->render('login.twig', array('error' => 'something wrong', 'last_username' => ''));
                    }
                    $answ = json_decode($resp->getContent());
                    return $app['twig']->render('index.twig', array('list' => $answ->list));
                })->before($before)->bind('index');

        return $controllers;
    }

}