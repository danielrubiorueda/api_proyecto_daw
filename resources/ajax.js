$(function () {

    $.get('http://localhost/fct/api/public/api/inicio').done(function (r) {
        if (r.length >= 3) {
            var elemento = [];
            r.forEach(function (e) {
                elemento.push('<div class="col-md-4">' +
                    '<div class="card">' +
                    '<img class="card-img-top" src="resources/' + e.img_proyecto + '" alt="' + e.proyecto + '">' +
                    '<div class="card-body">' +
                    '<h5 class="card-title">' + e.proyecto + '</h5>' +
                    '<p>¡Faltan ' + (e.objetivo - e.contribucion) + 'km para la meta!</p>' +
                    '<div class="progreso"><span style="width:'+(e.contribucion/e.objetivo*100)+'%"><span></div>'+
                    '<p class="card-text">' + e.descripcion_proyecto + '</p>' +
                    '<a href="' + e.id_proyecto + '" class="btn btn-primary">Ver proyecto</a>' +
                    '</div></div></div>');
            });
            $.each(elemento, function (i, value) {
                setTimeout(function(){
                    $(value).appendTo('#cards').toggle().fadeToggle(800);
                }, 300 + ( i * 300 ));
            });
        }
    });

    $("a").click(function (e) {
        var aid = $(this).attr("href");
        if (aid.indexOf("#") != -1) e.preventDefault();
        $('html,body').animate({ scrollTop: $(aid).offset().top }, 'slow');
    });

});


// https://www.strava.com/oauth/authorize?client_id=26016&response_type=code&redirect_uri=http://localhost&scope=view_private
// 1cd663b63f446e88ae16377f4ed0c3c75cbb4d0e
// https://www.strava.com/api/v3/athlete/activities?before=1527775498&after=1527689164
