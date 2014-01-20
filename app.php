<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request; 

$app = new Silex\Application();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\SessionServiceProvider());


$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/thank-you', function () use ($app) {
    return $app['twig']->render('thank-you.html.twig');
});

$app->get('/{name}', function ($name) use ($app) {
    if (!file_exists($app['img_directory'].'/'.$name)) {
        $app->abort(404, "Image $name does not exist.");
    }
    return $app['twig']->render('image_detail.html.twig', array("name"=>$name));
});

$app->post('/', function (Request $request) use ($app) { 
    $file = $request->files->get('file'); 
    $name = $request->request->get('name');
    
    $message = $name.' image uploaded';
    if(file_exists($app['img_directory'].'/'.$name)){
        $message = $name.' image changed';
    }
    
    $file->move($app['img_directory'], $name); 

    $app['session']->getFlashBag()->add('message', $message);

    return $app->redirect('/thank-you');
}); 



return $app;
