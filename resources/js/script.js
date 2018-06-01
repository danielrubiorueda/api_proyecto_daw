$(function () {

    $("a").click(function (e) {
        var aid = $(this).attr("href");
        if (aid.indexOf("#") != -1) e.preventDefault();
        $('html,body').animate({ scrollTop: $(aid).offset().top }, 'slow');
    });

    // carga css en diferido
    var cssd = document.createElement('link');
    cssd.rel = 'stylesheet';
    cssd.href = '/resources/css/bootstrap.min.css';
    cssd.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(cssd, godefer);

    var cssd2 = document.createElement('link');
    cssd2.rel = 'stylesheet';
    cssd2.href = '/resources/css/style.css';
    cssd2.type = 'text/css';
    var godefer2 = document.getElementsByTagName('link')[0];
    godefer2.parentNode.insertBefore(cssd2, godefer2);

});

function cardProyecto(r){
    var elemento = [];
    r.forEach(function (e) {
        elemento.push('<div class="col-md-4">' +
        '<div class="card">' +
        '<img class="card-img-top" src="/resources/img/' + e.img_proyecto + '" alt="' + e.proyecto + '">' +
        '<div class="card-body">' +
        '<h5 class="card-title">' + e.proyecto + '</h5>' +
        '<p>¡Faltan ' + (e.objetivo - e.contribucion) + 'km para la meta!</p>' +
        '<div class="progreso"><span style="width:'+(e.contribucion/e.objetivo*100)+'%"><span></div>'+
        '<p class="card-text">' + e.descripcion_proyecto + ' <a target="_blank" href="https://www.instagram.com/explore/tags/' + e.hashtag_proyecto + '/">#' + e.hashtag_proyecto + '</a></p>' +
        '<p class="card-text donacion">' + e.donacion + '€</p>' +
        '<p class="card-text">Patrocinado por <a href="' + e.www_empresa + '" target="_blank">' + e.empresa + '</a></p>' +
        '</div></div></div>');
    });
    return elemento;
}


var idapp = '26016';
var secret = '43476f02df28fd7a7a5f6cd7aba18618d3f41b5d';
var redirect = 'http://localhost';
var linkAuth = 'https://www.strava.com/oauth/authorize?client_id='+idapp+'&response_type=code&redirect_uri='+redirect;
var code = '84e062718e072ebcc13dd06e72021e82a87afc1a';
var postAthlete = 'https://www.strava.com/oauth/token?client_id='+idapp+'&client_secret='+secret+'&code='+code;
var access_token = '7db9e521c0b278d1aee0f76b38c700e128e76a28';
var ahora = Math.round(new Date().getTime()/1000.0);
var ayer = ahora - 86400;
var getActividad = 'https://www.strava.com/api/v3/athlete/activities?before='+ahora+'&after='+ayer+'&access_token='+access_token;
var getAthlete = 'https://www.strava.com/api/v3/athlete?access_token='+access_token;