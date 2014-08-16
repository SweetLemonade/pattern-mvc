<?php

namespace MVC;

use Exception;
use ReflectionClass;


class App
{
    protected $_controller = 'home';

    protected $_method = 'index';

    protected $_params = [];




    public function __construct()
    {
        $this->parseUrl();

        $controllerClassName = '\\app\\controllers\\' . $this->_controller;

        if( class_exists( $controllerClassName ) )
        {
            $rc = new ReflectionClass( $controllerClassName );

            if( $rc->hasMethod( $this->_method ) )
            {
                $controller = $rc->newInstance();
                $method = $rc->getMethod( $this->_method );
                $method->invokeArgs( $controller, $this->_params );
            }
            else throw new Exception( 'Controller has not method with name "' . $this->_method . '"' );
        }
        else throw new Exception( 'Controller not found with name "' . $this->_controller . '"' );
    }


    public function parseUrl()
    {
        $url = trim( $_SERVER['REQUEST_URI'], '/' );
        $urlPieces = explode( '/', $url );

        #Select a controller
        if( ! empty($urlPieces[0]) ) $this->_controller = ucfirst( mb_strtolower($urlPieces[0]) ) . 'Controller';
        else $this->_controller = 'IndexController';

        #Select a method
        if( ! empty($urlPieces[1]) ) $this->_method = mb_strtolower($urlPieces[1]) . 'Action';
        else $this->_method = 'indexAction';

        #Select params
        if( ! empty($urlPieces[2]) )
        {
            $this->_params = array_slice( $urlPieces, 2 );

            /*
            $keys = $values = [];

            for($i = 2, $count = count($urlPieces); $i < $count; $i++)
            {
                if( $i%2 == 0 ) $keys[] = $urlPieces[ $i ];
                else $values[] = $urlPieces[ $i ];
            }

            #Cut arrays
            $countKeys = count($keys);
            $countValues = count($values);

            if( $countKeys != $countValues )
            {
                if( $countKeys < $countValues ) unset( $values[ $countValues - 1 ] );
                else unset( $keys[ $countKeys- 1 ] );
            }

            $this->_params = array_combine( $keys, $values );
            */
        }
    }
}