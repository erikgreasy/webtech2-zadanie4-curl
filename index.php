<?php 

require_once 'inc/config.inc.php';

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;
Router::setDefaultNamespace('controller');


// 404
Router::error(function(Request $request, \Exception $exception) {
    return view('core/404.php');
});

Router::start();
