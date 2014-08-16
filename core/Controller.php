<?php

namespace MVC;


class Controller
{
    protected function model( $model )
    {
        $modelName = '\\app\\models\\' . $model;
        return new $modelName;
    }


    protected function view( $view, $data = [] )
    {
        extract( $data );

        require_once 'app/views/' . $view . '.php';
    }
}