<?php
// DIC configuration

$container = $app->getContainer();

$container['view'] = function ($c) {
    $settings = $c->get('settings')['view'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => $settings['cache_path']
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

$container['database'] = function ($c) {
    $settings = $c->get('settings')['database'];
    return new \PDO($settings['dsn']);
};

$container['model'] = function ($c) {
    return new \Topic\Model($c);
};
