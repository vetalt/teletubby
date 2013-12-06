<?php

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\ControllerProviderInterface;

class LoginControllerProvider implements ControllerProviderInterface {

    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function () use ($app) {
                    return $app['twig']->render('login.twig', array('error' => '', 'last_username' => ''));
                })->bind('login');

        $controllers->post('/', function (Request $request) use ($app) {
                    $login = $request->get('_username');
                    $password = $request->get('_password');
                    $resp = $app['buzz']->post('http://vacancy.dev.telehouse-ua.net/auth/login', array(), "login={$login}&password={$password}");
                    if (!$resp->isOk()) {
                        return $app['twig']->render('login.twig', array('error' => 'something wrong', 'last_username' => $login));
                    }
                    $answ = json_decode($resp->getContent());
                    $app['session']->set('token', $answ->token);
                    return $app->redirect($app->url('index'));
                });

        return $controllers;
    }

}