<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    $siteSettings = $this->get('settings')['site'];
    $topic = $this->model->getRandomTopic();
    $latest = $this->model->getLatest(10);
    return $this->view->render($response, 'index.html', [
        'title' => 'Topic Roulette',
        'topic' => $topic,
        'tags' => explode(',', $topic['tags']),
        'domain' => $siteSettings['domain'],
        'latest' => $latest,
    ]);
});

$app->get('/sitemap', function ($request, $response, $args) {
    $siteSettings = $this->get('settings')['site'];
    $topics = $this->model->getAll();
    $newResponse = $response->withHeader('Content-type', 'text/xml');
    return $this->view->render($newResponse, 'sitemap.xml', [
        'topics' => $topics,
        'domain' => $siteSettings['domain'],
    ]);
});

$app->get('/topic/add', function ($request, $response, $args) {
    return $this->view->render($response, 'add.html', [
        'title' => 'Topic Roulette / Add new topic',
    ]);
});

$app->post('/topic/add', function ($request, $response, $args) {
    $title = '';
    $tags = '';
    $allPostVars = $request->getParsedBody();
    if (isset($allPostVars['title']) &&
        mb_strlen($allPostVars['title']) > 3) {
        $title = trim(strip_tags($allPostVars['title']));
    }
    if (isset($allPostVars['tags']) &&
        mb_strlen($allPostVars['tags']) > 3) {
        $tags = trim(strip_tags($allPostVars['tags']));
    }
    $user = $allPostVars['user'];
    if (empty($user) && $title && $tags) {
        $id = $this->model->addTopic($title, $tags);
    }
    return $response->withRedirect('/');
});

$app->get('/topic/{id}[/{amp}]', function ($request, $response, $args) {
    $slug = explode('-', $args['id']);
    $sid = array_shift($slug);
    $id = base_convert($sid, 36, 10);
    $topic = $this->model->getTopic($id);
    $siteSettings = $this->get('settings')['site'];
    $template = (isset($args['amp']) && $args['amp'] === 'amp') ? 'show_amp.html' : 'show.html';
    if (!$topic) {
        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    }
    return $this->view->render($response, $template, [
        'title' => 'Topic Roulette / ' . $topic['title'],
        'topic' => $topic,
        'tags' => explode(',', $topic['tags']),
        'domain' => $siteSettings['domain'],
        'add_permalink' => true,
    ]);
});
