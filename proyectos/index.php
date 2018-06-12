<?php require_once($_SERVER['DOCUMENT_ROOT'].'/head.php'); ?>


    <main id="inicio" role="main">

        <div id="proyectos">
            <div class="jumbotron proyectos">
                <div class="container">
                    <h1 class="display-4 text-center">Reparte ilusión</h1>
                    <p class="text-center">Detras de cada proyecto hay muchas personas que la necesitan</p>
                </div>
            </div>
            <div class="container">
                <div id="cards" class="row">
                </div>
            </div>
        </div>

        <div id="colabora">
            <div class="jumbotron colabora">
                <div class="container">
                    <h1 class="display-4 text-center">Sin tí no podemos conseguirlo</h1>
                    <p class="text-center">Sólo con la colaboración de todos podemos llegar a conseguir todo lo que nos proponemos.</p>
                    <p class="text-center">
                        <a class="btn btn-primary btn-lg contacto" href="#" role="button">Contacta con nosotros</a>
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

    <script type="text/javascript">
        $.get('http://fct.danielrubiorueda.com/api/public/api/proyectos').done(function (r) {
            if (r.length >= 3) {
                var elemento = cardProyecto(r);
                $.each(elemento, function (i, value) {
                    setTimeout(function () {
                        $(value).appendTo('#cards').toggle().slideToggle(500);
                    }, 200 + (i * 200));
                });
            }
        });
    </script>
</body>

</html>