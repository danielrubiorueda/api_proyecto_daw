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
    $sth = $this->db->prepare("SELECT id_strava from alumnos where id_strava = ".$_POST['idalumno']);
    $sth->execute();
    if(!$respuesta = $sth->fetch()){
        return $this->response->withJson('1');
    }

    // comprueba si hay donación en las últimas 24 horas
    $sth = $this->db->prepare("SELECT max(id_contribucion), fecha_contribucion from contribuciones where id_strava = ".$_POST['idalumno']);
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
        $query = "INSERT INTO `fct`.`contribuciones` (`id_strava`, `id_proyecto`, `contribucion`) VALUES ('".$_POST['idalumno']."', '".$value["id_proyecto"]."', '".$donacion."');";
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

// Llamada a la API de Strava para obtener el acceso a los datos del usuario
// Redireccionamos a la app con parametros GET: token, nombre, foto de perfil y más
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
    CURLOPT_HTTPHEADER => array("Cache-Control: no-cache"),
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

//
// DATATABLES
//

// GETTERS

// mensajes
$app->get('/api/mensajes', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("SELECT * FROM mensajes");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});
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
    $sth = $this->db->prepare("SELECT * FROM cursos");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});
// centros
$app->get('/api/centros', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("SELECT * FROM centros");
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

// SETTERS

// alumnos (la clave foránea alumnos-contribuciones está conf. en cascada en update)
$app->post('/api/edit/alumnos', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sql = "UPDATE alumnos SET 
    id_strava = '".$_POST["id_strava"]."',
    id_alumno = '".$_POST["id_alumno"]."' 
    WHERE id_alumno = ".$_POST["id_alumno"];
    $sth = $this->db->prepare($sql);
    return $sth->execute();
});
// cursos
$app->post('/api/edit/cursos', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("UPDATE cursos SET 
    curso = '".$_POST["curso"]."',
    nivel = '".$_POST["nivel"]."',
    id_centro = '".$_POST["id_centro"]."'
    WHERE id_curso = ".$_POST["id_curso"]);
    return $sth->execute();
});
// centros
$app->post('/api/edit/centros', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("UPDATE centros SET 
    centro = '".$_POST["centro"]."',
    localidad = '".$_POST["localidad"]."',
    provincia = '".$_POST["provincia"]."'
    WHERE id_centro = ".$_POST["id_centro"]);
    return $sth->execute();
});
// causas
$app->post('/api/edit/causas', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("UPDATE causas SET 
    causa = '".$_POST["causa"]."',
    descripcion_causa = '".$_POST["descripcion_causa"]."',
    www_causa = '".$_POST["www_causa"]."',
    img_causa = '".$_POST["img_causa"]."'
    WHERE id_causa = ".$_POST["id_causa"]);
    return $sth->execute();
});
// empresas
$app->post('/api/edit/empresas', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("UPDATE empresas SET 
    empresa = '".$_POST["empresa"]."',
    descripcion_empresa = '".$_POST["descripcion_empresa"]."',
    www_empresa = '".$_POST["www_empresa"]."',
    img_empresa = '".$_POST["img_empresa"]."'
    WHERE id_empresa = ".$_POST["id_empresa"]);
    return $sth->execute();
});
// proyectos
$app->post('/api/edit/editproyectos', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("UPDATE proyectos SET 
    proyecto = '".$_POST["proyecto"]."',
    descripcion_proyecto = '".$_POST["descripcion_proyecto"]."',
    hashtag_proyecto = '".$_POST["hashtag_proyecto"]."',
    img_proyecto = '".$_POST["img_proyecto"]."',
    fecha_inicio = '".$_POST["fecha_inicio"]."',
    fecha_fin = '".$_POST["fecha_fin"]."',
    objetivo = '".$_POST["objetivo"]."',
    donacion = '".$_POST["donacion"]."'
    WHERE id_proyecto = ".$_POST["id_proyecto"]);
    return $sth->execute();
});

// DELETE

// alumnos (la clave foránea alumnos-contribuciones está conf. en cascada en update)
$app->post('/api/delete/alumnos', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sql = "DELETE FROM alumnos 
    WHERE id_alumno = ".$_POST["id_alumno"];
    $sth = $this->db->prepare($sql);
    return $sth->execute();
});
// cursos
$app->post('/api/delete/cursos', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("DELETE FROM cursos 
    WHERE id_curso = ".$_POST["id_curso"]);
    return $sth->execute();
});
// centros
$app->post('/api/delete/centros', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("DELETE FROM centros 
    WHERE id_centro = ".$_POST["id_centro"]);
    return $sth->execute();
});
// causas
$app->post('/api/delete/causas', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("DELETE FROM causas
    WHERE id_causa = ".$_POST["id_causa"]);
    return $sth->execute();
});
// empresas
$app->post('/api/delete/empresas', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("DELETE FROM empresas
    WHERE id_empresa = ".$_POST["id_empresa"]);
    return $sth->execute();
});
// proyectos
$app->post('/api/delete/editproyectos', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("DELETE FROM proyectos 
    WHERE id_proyecto = ".$_POST["id_proyecto"]);
    return $sth->execute();
});