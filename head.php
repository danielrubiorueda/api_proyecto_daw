<?php ?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="Description" content="Corre y cambia el mundo con SoliRun, la plataforma solidaria">
    <title>SoliRun</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="preload" href="/resources/css/bootstrap.min.css" as="style">
    <link rel="stylesheet" type="text/css" href="/resources/css/style.css?2" />
    <noscript>
        <link rel="stylesheet" type="text/css" href="/resources/css/bootstrap.min.css" />
    </noscript>
</head>

<body>
    <style>
        #loader {
            background: url(/resources/img/logo.png) no-repeat 50% white;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100000;
        }

        @media screen and (max-width: 600px) {
            #loader {
                background-size: 70%;
            }
        }
    </style>
    <div id="loader"></div>

    <div class="navbar navbar-expand-md navbar fixed-top">
        <nav class="container">
            <a id="logo" class="navbar-brand" href='/'>
                <img class="img img-fluid" src="/resources/img/logo.png" alt="Logotipo SoliRun">
                <span>SoliRun</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    ≡
                </span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="/proyectos" class="nav-link">Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a href="/empresas" class="nav-link">Empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link stravalink" href='#colabora'>Conecta con Strava</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>