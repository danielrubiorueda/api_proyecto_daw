<?php

use Slim\Http\Request;
use Slim\Http\Response;

// post mensaje
$app->post('/api/mensaje', function ($request, $response, $args) {

    header("Access-Control-Allow-Origin: *");

    $sth = $this->db->prepare("INSERT INTO mensajes (org,email,msg) VALUES ('".$_POST['org']."','".$_POST['email']."','".$_POST['msg']."')");
    return $sth->execute();

});

// post donacion
$app->post('/api/donacion', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    // comprueba si el alumno está registrado
    $sth = $this->db->prepare("SELECT id_alumno from alumnos where id_alumno = ".$_POST['idalumno']);
    $sth->execute();
    if(!$respuesta = $sth->fetch()){
        return $this->response->withJson('1');
    }

    // comprueba si hay donación en las últimas 24 horas
    $sth = $this->db->prepare("SELECT max(id_contribucion), fecha_contribucion from contribuciones where id_alumno = ".$_POST['idalumno']);
    $sth->execute();
    $respuesta = $sth->fetch();
    $respuesta = $respuesta['fecha_contribucion'];
    if(date(time() - 60 * 60 * 24) < strtotime($respuesta)){
        return $this->response->withJson('2');
    }

    $sth = $this->db->prepare("SELECT proyectos.id_proyecto, round(objetivo-ifnull(sum(contribucion),0),2) as resta FROM proyectos 
    LEFT JOIN contribuciones on contribuciones.id_proyecto = proyectos.id_proyecto
    GROUP BY proyectos.id_proyecto
    ORDER BY proyectos.id_proyecto ASC");
    $sth->execute();
    $todos = $sth->fetchAll();
    $donacion = $_POST["donacion"];
    $query = '';
    $sobrante = 0;
    foreach ($todos as $value) {
        $sobrante;
        $auxdonacion = $donacion / 2;
        $auxdonacion += $sobrante;
        $donacion = ($value["resta"] < $auxdonacion) ? $value["resta"] : $auxdonacion ;
        $sobrante = ($value["resta"] < $auxdonacion) ? $auxdonacion-$value["resta"] : 0 ;
        $query = "INSERT INTO `fct`.`contribuciones` (`id_alumno`, `id_proyecto`, `contribucion`) VALUES ('".$_POST['idalumno']."', '".$value["id_proyecto"]."', '".$donacion."');";
        $sth = $this->db->prepare($query);
        $sth->execute();
    }
    $sth = $this->db->prepare($query);
    $sth->execute();
    return $this->response->withJson('0');
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

// inicio
$app->get('/api/inicio', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    $sth = $this->db->prepare("SELECT proyectos.*, ifnull(sum(contribucion),0) as contribucion, empresas.* FROM proyectos 
    LEFT JOIN contribuciones on contribuciones.id_proyecto = proyectos.id_proyecto
    LEFT JOIN empresas on empresas.id_empresa = proyectos.id_empresa
    GROUP BY proyectos.id_proyecto
    ORDER BY proyectos.id_proyecto ASC limit 3");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

$app->get('/api/strava', function ($request, $response, $args) {

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
        "Cache-Control: no-cache"
    ),
    ));

    $curl_response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return $response->withHeader('Location', 'http://127.0.0.1:5500/');
    } else {
        $curl_response = json_decode($curl_response);
        return $response->withHeader('Location', 'http://127.0.0.1:5500/donacion/?'.http_build_query($curl_response));
    }

});


// admin


// alumnos
$app->get('/api/alumnos', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    $sth = $this->db->prepare("SELECT * FROM alumnos");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// cursos
$app->get('/api/cursos', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    $sth = $this->db->prepare("SELECT * FROM cursos JOIN centros on centros.id_centro = cursos.id_centro");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// causas
$app->get('/api/causas', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    $sth = $this->db->prepare("SELECT * FROM causas");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// mensajes
$app->get('/api/mensajes', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    $sth = $this->db->prepare("SELECT * FROM mensajes");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// empresas
$app->get('/api/empresas', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    $sth = $this->db->prepare("SELECT * FROM empresas");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

// proyectos
$app->get('/api/editproyectos', function ($request, $response, $args) {
    
    header("Access-Control-Allow-Origin: *");
    
    $sth = $this->db->prepare("SELECT * FROM proyectos");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});