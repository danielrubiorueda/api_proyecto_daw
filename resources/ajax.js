$(function () {
    
    $.get('http://localhost/fct/api/public/').done(function(r) {
        if(r.length >= 3) {
            r.forEach(function(e){
                var elemento = '<div class="col-md-4"><div class="card"><img class="card-img-top" src="/resources/'+e.img_proyecto+'" alt="'+e.proyecto+'"><div class="card-body"><h5 class="card-title">'+e.proyecto+'</h5><p class="card-text">'+e.descripcion_proyecto+'</p><a href="'+e.hashtag_proyecto+'" class="btn btn-primary">Ver proyecto</a></div></div></div>';
                $('#cards').append(elemento);
            });
        }
    });
    
    $("a").click(function (e) {
        var aid = $(this).attr("href");
        if (aid.indexOf("#") != -1) e.preventDefault();
        $('html,body').animate({ scrollTop: $(aid).offset().top }, 'slow');
    });

});