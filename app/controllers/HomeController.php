<?php

namespace app\controllers;

use MVC\Controller;


class HomeController extends Controller
{
    public function indexAction( $name = '' )
    {
        $user = $this->model( 'User' );
        $user->name = $name;

        $this->view( 'hello', ['name' => $user->name] );
    }
}