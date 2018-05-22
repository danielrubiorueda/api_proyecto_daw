<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

// $app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

// get empresa
$app->get('/empresas/{id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM empresas WHERE id_empresa = ".$args['id']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get empresas
$app->get('/empresas', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM empresas ORDER BY empresa ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get proyecto
$app->get('/proyectos/{id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM proyectos WHERE id_proyecto = ".$args['id']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get proyectos
$app->get('/proyectos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM proyectos ORDER BY proyecto ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get causa
$app->get('/causas/{id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM causas WHERE id_causa = ".$args['id']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get causas
$app->get('/causas', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM causas ORDER BY causa ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});