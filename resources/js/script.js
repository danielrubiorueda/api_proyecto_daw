$(function () {

    $("a").click(function (e) {
        var aid = $(this).attr("href");
        if (aid.indexOf("#") != -1) e.preventDefault();
        $('html,body').animate({ scrollTop: $(aid).offset().top }, 'slow');
    });

    // carga css en diferido
    var cssd = document.createElement('link');
    cssd.rel = 'stylesheet';
    cssd.href = 'resources/css/bootstrap.min.css';
    cssd.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(cssd, godefer);

    var cssd2 = document.createElement('link');
    cssd2.rel = 'stylesheet';
    cssd2.href = 'resources/css/style.css';
    cssd2.type = 'text/css';
    var godefer2 = document.getElementsByTagName('link')[0];
    godefer2.parentNode.insertBefore(cssd2, godefer2);

});

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