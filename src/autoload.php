<?php

/**
 * Autoload file for Mime library
 */
spl_autoload_register(function($class) {
    //trip library name Mime 
    $class = stripos($class,'Mime') === 0 ? substr($class,5):$class;
    $class = str_replace('\\',DIRECTORY_SEPARATOR,$class);
    include_once($class.'.php');
});
 
