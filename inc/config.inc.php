<?php

require 'config.php';
require __DIR__ . '/../vendor/autoload.php';
require_once 'inc/helper-router-functions.php';
require_once 'inc/functions.php';
  

// AUTOLOAD
spl_autoload_register(function ($class_name) {
    include str_replace( '\\', '/', $class_name ) . '.php';
});


// Start a Session
if (!session_id()) @session_start();
