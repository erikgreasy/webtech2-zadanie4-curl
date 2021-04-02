<?php 

require_once 'inc/config.inc.php';

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::setDefaultNamespace('app\controllers');

// create curl resource
// $ch = curl_init();

// // set url
// curl_setopt($ch, CURLOPT_URL, 'https://github.com/apps4webte/curldata2021');

// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


// $output = curl_exec($ch);

// curl_close($ch);

// $dom = new DOMDocument();
// $dom->loadHTML($output, LIBXML_NOWARNING | LIBXML_NOERROR);

// $documentElement = $dom->getElementById('files');
// $finder = new DomXPath($dom);
// $classname="js-navigation-open Link--primary";
// $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
// $data = [];
// $files = [];


// foreach( $nodes as $index => $node ) {
//     $files[] = $node->nodeValue;
//     // $ch = curl_init();
//     // curl_setopt($ch, CURLOPT_URL, 'https://raw.githubusercontent.com/apps4webte/curldata2021/main/' . $node->nodeValue);
//     // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//     // $output = curl_exec($ch);
//     // $output = mb_convert_encoding($output, "UTF-8", "UTF-16");

//     // curl_close($ch);
//     // $users = explode("\n", $output);
//     // unset($users[0]);
    
//     // $new_users = [];
//     // foreach( $users as $user ) {
//     //     $new_user = explode( "\t", $user );
//     //     $new_users[] = $new_user;
//     // }

//     // $data[] = $new_users;


// }
// $fr = new \database\repositories\FileRepository;
// // foreach( $files as $file ) {
// //     $f = new app\models\File();
// //     $f->setName( $file );
// //     $fr->add($f);
// // }
// dd($fr->getAll());


Router::get( ROUTING_PREFIX . '/', 'PagesController@index' );


// 404
Router::error(function(Request $request, \Exception $exception) {
    return view('core/404');
});

Router::start();
