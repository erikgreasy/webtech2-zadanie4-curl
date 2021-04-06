<?php 

require_once 'inc/config.inc.php';

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::setDefaultNamespace('app\controllers');



Router::get( ROUTING_PREFIX . '/', 'PagesController@index' );
Router::get( ROUTING_PREFIX . '/stats', 'PagesController@stats' );

Router::get( ROUTING_PREFIX . '/student/{student_id}/lecture/{lecture_id}', 'StudentController@show' );


// 404
Router::error(function(Request $request, \Exception $exception) {
    return view('core/404');
});

Router::start();
