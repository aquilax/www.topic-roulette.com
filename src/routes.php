<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Render index view
    return $this->view->render($response, 'index.phtml', $args);
});
