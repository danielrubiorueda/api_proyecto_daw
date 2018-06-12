<?php require_once($_SERVER['DOCUMENT_ROOT'].'/head.php'); ?>

    <main id="inicio" role="main">

        <div id="proyectos">
            <div class="jumbotron donacion">
                <div class="container">
                    <h1 class="display-4 text-center">Pon tu granito de arena</h1>
                    <p class="text-center">Poco a poco entre todos podemos lograrlo todo</p>
                </div>
            </div>
            <div class="card mx-auto">
                <div class="container text-center" id="boxpersona">
                    <span class="mt-3 perfil lima"></span>
                    <h2>Hola </h2>
                    <p></p>
                    <form id="form-donacion" class="card-body">
                        <input type="submit" onclick="enviadonacion(event)" class="btn btn-success btn-lg" role="button" value="Auto-repartir KMs">
                    </form>
                </div>
            </div>
        </div>

        <div id="colabora">
            <div class="jumbotron colabora">
                <div class="container">
                    <h1 class="display-4 text-center">Sin tí no podemos conseguirlo</h1>
                    <p class="text-center">Sólo con la colaboración de todos podemos llegar a conseguir todo lo que nos proponemos.</p>
                    <p class="text-center">
                        <a class="btn btn-primary btn-lg contacto" href="" role="button">Contacta con nosotros</a>
                    </p>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h2>Para causas solidarias</h2>
                        <p>Crea tu propia causa solidaria y haz realidad tus sueños... ¿A qué esperas?</p>
                        <p>
                            <a class="btn btn-secondary contacto" href="" role="button">Participa</a>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h2>Gracias a las empresas</h2>
                        <p>Agradecimiento a las empresas que fomentan el deporte por una mejor calidad de vida. Gracias al apoyo de las instituciones podremos frenar el sedentarismo y la obesidad, y así reducir el riesgo de sufrir enfermedades.</p>
                        <p>
                            <a class="btn btn-secondary contacto" href="" role="button">Contacta con nosotros</a>
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h2>Por los alumnos</h2>
                        <p>En este apartado podrás controlar y realizar un seguimiento de los kilómetros que realizan tus alumnos para el trabajo de la resistencia aeróbica, clave en el desarrollo de la condición física salud.</p>
                        <p>
                            <a class="btn btn-success stravalink" href="/donacion" role="button">Conecta con Strava</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer class="text-center">
        <p>&copy; SoliRun 2018</p>
    </footer>
    <script src="/resources/js/jquery-3.3.1.min.js"></script>
    <script src="/resources/js/popper.min.js"></script>
    <script src="/resources/js/bootstrap.min.js"></script>
    <script src="/resources/js/script.js"></script>
    <script>
        var parametros = decodeURIComponent(location.search).split('&');
        if (parametros[0] != '') {
            var access_token = parametros[0].split('=')[1];
            var id_alumno = parametros[2].split('=')[1];
            var nombre_alumno = parametros[4].split('=')[1];
            var perfil_alumno = parametros[15].split('=')[1];
            var distanciaTotal = 0;
        }

        function enviadonacion(e) {
            e.preventDefault();
            $.post('http://fct.danielrubiorueda.com/api/public/api/donacion', $('#form-donacion').serialize())
                .done(function (r) {
                    if (r == 1) {
                        $('#boxpersona').append('<div class="alert alert-danger alert-dismissible">' +
                            ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            ' <strong>No estás en la lista :(</strong> Comprueba con tu responsable si estás en la lista con tu ID de Strava.' +
                            '</div>');
                    } else if (r == 2) {
                        $('#boxpersona').append('<div class="alert alert-danger alert-dismissible">' +
                            ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            ' <strong>Tienes que esperar un poco :(</strong> Sólo puedes hacer tus donaciones cada 24 horas, esta carrera sólo se gana día a día.' +
                            '</div>');
                    } else {
                        $('#boxpersona').append('<div class="alert alert-success alert-dismissible">' +
                            ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                            ' <strong>Muchas gracias por tus KMs :)</strong> cada día estamos un poco más cerca de cumplir nuestros retos.' +
                            '</div>');
                    }
                });
        }

        $(function () {
            // AJAX
            if (parametros[0] != '') {
                $('#boxpersona h2').html('¡Hola ' + nombre_alumno + '!');
                $('#boxpersona .perfil').css('background', 'url(' + perfil_alumno + ')');
                $.get(linkAct + access_token)
                    .done(function (respuesta) {
                        respuesta.forEach(function (e) {
                            distanciaTotal += e.distance / 1000;
                        });
                        $('#boxpersona > p').html('En las últimas 24 horas has recorrido ' + distanciaTotal + ' kms');
                        $('#form-donacion').append('<input name="donacion" type="hidden" value="' + distanciaTotal + '">');
                        $('#form-donacion').append('<input name="idalumno" type="hidden" value="' + id_alumno + '">');
                    });
            } else $('#boxpersona').html('Conectate con Strava para acceder a esta area');
        });
    </script>
</body>

</html>