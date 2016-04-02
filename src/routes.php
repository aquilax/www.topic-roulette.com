<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    $topic = $this->model->loadRandomTopic();
    return $this->view->render($response, 'index.html', [
        'title' => 'Topic Roulette',
        'topic' => $topic,
        'tags' => explode(',', $topic['tags']),
        'id' => base_convert($topic['id'], 10, 36),
    ]);
});

$app->get('/{id}', function ($request, $response, $args) {
    $id = base_convert($args['id'], 36, 10);
    $topic = $this->model->loadTopic($id);
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
