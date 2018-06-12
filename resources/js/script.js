$(function () {

    $('.stravalink').attr('href', linkAuth);

    // carga css en diferido
    var cssd = document.createElement('link');
    cssd.rel = 'stylesheet';
    cssd.href = '/resources/css/bootstrap.min.css';
    cssd.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(cssd, godefer);

    $('#loader').fadeOut(500);

    contacto();

});

function contacto(){
    $modal = '<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="formulario"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-body"> <div class="form-area"> <form role="form"> <div class="form-group"> <input type="text" class="form-control" id="org" name="org" placeholder="Organización" required> </div> <div class="form-group"> <input type="text" class="form-control" id="email" name="email" placeholder="Email" required> </div> <div class="form-group"> <textarea required name="msg" class="form-control" type="textarea" id="message" placeholder="Mensaje" maxlength="140" rows="7"></textarea> <span class="help-block"> <p id="characterLeft" class="help-block "></p> </span> </div> <button type="button" class="btn btn-secondary" data-dismiss="modal">No, gracias</button> <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Envia el mensaje</button> </form> </div> </div> </div> </div> </div>';
    $('body').append($modal);
    // clicks
    $('.contacto').on('click', function (e) {
        e.preventDefault();
        $('#formulario').modal('show');
    });
    // Formulario 
    $('#characterLeft').text('Te quedan 140 caracteres');
    $('#message').keydown(function () {
        var max = 140;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('Has llegado al límite');
            $('#characterLeft').addClass('red');
            $('#btnSubmit').addClass('disabled');
        }
        else {
            var ch = max - len;
            $('#characterLeft').text('Te quedan ' + ch + ' caracteres');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('red');
        }
    });
    $('#formulario form').on('submit', function (e) {
       e.preventDefault();
       $.post('http://fct.danielrubiorueda.com/api/public/api/mensaje', $(this).serialize())
       .done(function (r) {
            $('#formulario').modal('hide');
       });
    });
    
}

function cardProyecto(r){
    var elemento = [];
    r.forEach(function (e) {
        elemento.push('<div class="col-md-4">' +
        '<div class="card">' +
        '<img class="card-img-top" src="/resources/img/' + e.img_proyecto + '" alt="' + e.proyecto + '">' +
        '<div class="card-body">' +
        '<h5 class="card-title">' + e.proyecto + '</h5>' +
        '<p>¡Faltan ' + Math.round(100*(e.objetivo - e.contribucion))/100 + 'km para la meta!</p>' +
        '<div class="progreso"><span style="width:'+(e.contribucion/e.objetivo*100)+'%"><span></div>'+
        '<p class="card-text">' + e.descripcion_proyecto + ' <a target="_blank" href="https://www.instagram.com/explore/tags/' + e.hashtag_proyecto + '/">#' + e.hashtag_proyecto + '</a></p>' +
        '<p class="card-text donacion">Donación ' + e.donacion + '€</p>' +
        '<p class="card-text">Patrocinado por <a href="' + e.www_empresa + '" target="_blank">' + e.empresa + '</a></p>' +
        '</div></div></div>');
    });
    return elemento;
}

var ahora = Math.round(new Date().getTime()/1000.0);
var ayer = ahora - 86400;
var linkAct = "https://www.strava.com/api/v3/athlete/activities?before="+ahora+"&after="+ayer+"&access_token=";
var idapp = '26016';
var redirect = 'http://fct.danielrubiorueda.com/api/public/api/strava';
var linkAuth = 'https://www.strava.com/oauth/authorize?client_id='+idapp+'&response_type=code&approval_prompt=force&redirect_uri='+redirect;