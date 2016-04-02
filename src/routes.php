<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    $topic = $this->model->getRandomTopic();
    return $this->view->render($response, 'index.html', [
        'title' => 'Topic Roulette',
        'topic' => $topic,
        'tags' => explode(',', $topic['tags']),
        'id' => base_convert($topic['id'], 10, 36),
    ]);
});

$app->get('/sitemap', function ($request, $response, $args) {
    $siteSettings = $this->get('settings')['site'];
    $links = $this->model->getAll();
    $newResponse = $response->withHeader('Content-type', 'text/xml');
    return $this->view->render($newResponse, 'sitemap.xml', [
        'links' => $links,
        'domain' => $siteSettings['domain'],
    ]);
});

$app->get('/topic/{id}', function ($request, $response, $args) {
    $id = base_convert($args['id'], 36, 10);
    $topic = $this->model->getTopic($id);
    if (!$topic) {
        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    }
    return $this->view->render($response, 'index.html', [
        'title' => 'Topic Roulette / ' . $topic,
        'topic' => $topic,
        'tags' => explode(',', $topic['tags']),
        'id' => base_convert($topic['id'], 10, 36),
    ]);
});

