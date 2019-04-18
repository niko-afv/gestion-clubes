<?php


    function isActiveRoute($route, $output = 'active')
    {
        if( \Illuminate\Support\Facades\Request::route()->getPrefix() == $route){
            return $output;
        }
    }
