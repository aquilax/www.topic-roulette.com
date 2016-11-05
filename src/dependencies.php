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
    $convertId = new Twig_SimpleFilter('convert_id', function ($id) {
        return base_convert($id, 10, 36);
    });
    $environment = $view->getEnvironment();
    $environment->addFilter($convertId);
    $environment->addExtension(
        new Cocur\Slugify\Bridge\Twig\SlugifyExtension(Cocur\Slugify\Slugify::create())
    );

    return $view;
};

$container['database'] = function ($c) {
    $settings = $c->get('settings')['database'];
    $pdo =  new \PDO($settings['dsn']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
};

$container['model'] = function ($c) {
    return new \Topic\Model($c->database);
};
