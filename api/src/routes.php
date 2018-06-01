<?php

use Slim\Http\Request;
use Slim\Http\Response;

// get empresa
$app->get('/api/empresas/{id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM empresas WHERE id_empresa = ".$args['id']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get empresas
$app->get('/api/empresas', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM empresas ORDER BY empresa ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get causa
$app->get('/api/causas/{id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM causas WHERE id_causa = ".$args['id']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get causas
$app->get('/api/causas', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM causas ORDER BY causa ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get total contribuciones
$app->get('/api/contribuciones/totales', function ($request, $response, $args) {
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
$app->get('/api/contribuciones', function ($request, $response, $args) {
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

// get proyecto
$app->get('/api/proyectos/{id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM proyectos WHERE id_proyecto = ".$args['id']);
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// get proyectos
$app->get('/api/proyectos', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT proyectos.*, ifnull(sum(contribucion),0) as contribucion, empresas.* FROM proyectos 
    LEFT JOIN contribuciones on contribuciones.id_proyecto = proyectos.id_proyecto
    LEFT JOIN empresas on empresas.id_empresa = proyectos.id_empresa
    GROUP BY proyectos.id_proyecto
    ORDER BY proyectos.id_proyecto ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    header("Access-Control-Allow-Origin: *");
    return $this->response->withJson($todos);
});

// get proyectos
$app->get('/api/inicio', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT proyectos.*, ifnull(sum(contribucion),0) as contribucion, empresas.* FROM proyectos 
    LEFT JOIN contribuciones on contribuciones.id_proyecto = proyectos.id_proyecto
    LEFT JOIN empresas on empresas.id_empresa = proyectos.id_empresa
    GROUP BY proyectos.id_proyecto
    ORDER BY proyectos.id_proyecto ASC limit 3");
    $sth->execute();
    $todos = $sth->fetchAll();
    header("Access-Control-Allow-Origin: *");
    return $this->response->withJson($todos);
});

$app->get('/api/illo', function ($request, $response, $args) {

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.strava.com/oauth/token?client_id=26016&client_secret=43476f02df28fd7a7a5f6cd7aba18618d3f41b5d&code=".$_GET['code'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
        "Cache-Control: no-cache",
        "Postman-Token: d52469cd-65f0-4b10-842b-d22059639096"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    header('location: http://127.0.0.1:5500/');
    } else {
        $response = json_decode($response);
        return $response->withRedirect('http://127.0.0.1:5500/?'.http_build_query($response));
    }

});