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

// get total contribuciones
$app->get('/contribuciones/totales', function ($request, $response, $args) {
    $consulta = "SELECT proyectos.*, causas.*, empresas.*, IFNULL(SUM(contribucion),0) AS aportado
    FROM proyectos
    LEFT JOIN contribuciones ON proyectos.id_proyecto = contribuciones.id_proyecto
    LEFT JOIN causas ON causas.id_causa = proyectos.id_causa
    LEFT JOIN empresas ON empresas.id_empresa = proyectos.id_empresa
    GROUP BY proyectos.id_proyecto";    
    $sth = $this->db->prepare($consulta);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get contribuciones
$app->get('/contribuciones', function ($request, $response, $args) {
    $consulta = "SELECT * 
    FROM contribuciones
    JOIN alumnos ON alumnos.id_alumno = contribuciones.id_alumno
    JOIN cursos ON cursos.id_curso = alumnos.id_curso
    JOIN proyectos ON proyectos.id_proyecto = contribuciones.id_proyecto
    JOIN causas ON causas.id_causa = proyectos.id_causa
    JOIN empresas ON empresas.id_empresa = proyectos.id_empresa";
    $sth = $this->db->prepare($consulta);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get proyectos
$app->get('/', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM proyectos ORDER BY proyecto ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});