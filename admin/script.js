var baseUrl = 'http://fct.danielrubiorueda.com/';
var lastEdit;
var dataTableUpdate;
var centros;
var cursos;
var causas;
var empresas;

$(document).ready(function () {
    // poblado de centros causas y empresas

    $.get(baseUrl+'api/public/api/cursos').done(function (r) {
        cursos = r;
    });
    $.get(baseUrl+'api/public/api/centros').done(function (r) {
        centros = r;
    });
    $.get(baseUrl+'api/public/api/causas').done(function (r) {
        causas = r;
    });
    $.get(baseUrl+'api/public/api/empresas').done(function (r) {
        empresas = r;
    });
    
    // Agrega botones para la inserción de filas
    $('h3').append(
        '<button onclick="modalInsert(event)" class="ml-2 btn btn-success">+</button>'
    );
    
    // Inicialización de visualización de datos

    var esplang = {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ filas",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "_START_ - _END_ de _TOTAL_",
        "sInfoEmpty": "0 - 0 de 0",
        "sInfoFiltered": "(encontrado entre _MAX_ filas)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }

    $('#alumnos').DataTable({
        ordering: false,
        responsive: true,
        ajax: {
            url: baseUrl+'api/public/api/alumnos',
            dataSrc: ''
        },
        columns: [{
            data: 'id_strava'
        }, {
            data: 'id_curso'
        }, {
            width: '2em',
            data: function (row, type, val, meta) {
                return '<button class="editbtn btn btn-primary mr-1 mb-1">Editar</button>';
            }
        }, ],
        lengthChange: false,
        language: esplang
    });

    $('#proyectos').DataTable({
        responsive: true,
        ajax: {
            url: baseUrl+'api/public/api/editproyectos',
            dataSrc: ''
        },
        columns: [{
            data: 'id_causa'
        }, {
            data: 'id_empresa'
        }, {
            data: 'proyecto'
        }, {
            data: 'descripcion_proyecto'
        }, {
            data: 'img_proyecto'
        }, {
            data: 'objetivo'
        }, {
            data: 'donacion'
        }, {
            data: 'hashtag_proyecto'
        }, {
            data: 'fecha_inicio'
        }, {
            data: 'fecha_fin'
        }, {
            width: '2em',
            data: function (row, type, val, meta) {
                return '<button class="editbtn btn btn-primary mr-1 mb-1">Editar</button>';
            }
        }, ],
        lengthChange: false,
        language: esplang
    });

    $('#empresas').DataTable({
        responsive: true,
        ajax: {
            url: baseUrl+'api/public/api/empresas',
            dataSrc: ''
        },
        columns: [{
            data: 'empresa'
        }, {
            data: 'descripcion_empresa'
        }, {
            data: 'www_empresa'
        }, {
            data: 'img_empresa'
        }, {
            width: '2em',
            data: function (row, type, val, meta) {
                return '<button class="editbtn btn btn-primary mr-1 mb-1">Editar</button>';
            }
        }, ],
        lengthChange: false,
        language: esplang
    });

    $('#cursos').DataTable({
        responsive: true,
        ajax: {
            url: baseUrl+'api/public/api/cursos',
            dataSrc: ''
        },
        columns: [{
            data: 'curso'
        }, {
            data: 'nivel'
        }, {
            data: 'id_centro'
        }, {
            width: '2em',
            data: function (row, type, val, meta) {
                return '<button class="editbtn btn btn-primary mr-1 mb-1">Editar</button>';
            }
        }, ],
        lengthChange: false,
        language: esplang
    });

    $('#centros').DataTable({
        responsive: true,
        ajax: {
            url: baseUrl+'api/public/api/centros',
            dataSrc: ''
        },
        columns: [{
            data: 'centro'
        }, {
            data: 'localidad'
        }, {
            data: 'provincia'
        }, {
            width: '2em',
            data: function (row, type, val, meta) {
                return '<button class="editbtn btn btn-primary mr-1 mb-1">Editar</button>';
            }
        }, ],
        lengthChange: false,
        language: esplang
    });

    $('#causas').DataTable({
        responsive: true,
        ajax: {
            url: baseUrl+'api/public/api/causas',
            dataSrc: ''
        },
        columns: [{
            data: 'causa'
        }, {
            data: 'descripcion_causa'
        }, {
            data: 'www_causa'
        }, {
            data: 'img_causa'
        }, {
            width: '2em',
            data: function (row, type, val, meta) {
                return '<button class="editbtn btn btn-primary mr-1 mb-1">Editar</button>';
            }
        }, ],
        lengthChange: false,
        language: esplang
    });


    $('#mensajes').DataTable({
        sorting: false,
        responsive: true,
        ajax: {
            url: baseUrl+'api/public/api/mensajes',
            dataSrc: ''
        },
        columns: [{
            data: 'fecha'
        }, {
            data: 'org'
        }, {
            data: 'msg'
        }, {
            data: 'email'
        }, ],
        lengthChange: false,
        language: esplang
    });

    // Inicialización de modales para edición

    $('#cursos').on('click', 'button.editbtn', function () {
        lastEdit = this;
        var data = $('#cursos').DataTable().row(this.parentElement.parentElement).data();
        var modal = $('#modal .form-group');
        modal.html('');
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/update/cursos'));
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/delete/cursos'));
        modal.append(newHiddenInput('id_curso', data.id_curso));
        modal.append(newInput('curso', data.curso));
        modal.append(newInput('nivel', data.nivel));
        modal.append(newInput('id_centro', data.id_centro));
        $('#modal').modal('show');
    });

    $('#centros').on('click', 'button.editbtn', function () {
        lastEdit = this;
        var data = $('#centros').DataTable().row(this.parentElement.parentElement).data();
        var modal = $('#modal .form-group');
        modal.html('');
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/update/centros'));
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/delete/centros'));
        modal.append(newHiddenInput('id_centro', data.id_centro));
        modal.append(newInput('centro', data.centro));
        modal.append(newInput('localidad', data.localidad));
        modal.append(newInput('provincia', data.provincia));
        $('#modal').modal('show');
    });

    $('#empresas').on('click', 'button.editbtn', function () {
        lastEdit = this;
        var data = $('#empresas').DataTable().row(this.parentElement.parentElement).data();
        var modal = $('#modal .form-group');
        modal.html('');
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/update/empresas'));
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/delete/empresas'));
        modal.append(newHiddenInput('id_empresa', data.id_empresa));
        modal.append(newInput('empresa', data.empresa));
        modal.append(newInput('descripcion_empresa', data.descripcion_empresa));
        modal.append(newInput('www_empresa', data.www_empresa));
        modal.append(newInput('img_empresa', data.img_empresa));
        $('#modal').modal('show');
    });

    $('#causas').on('click', 'button.editbtn', function () {
        lastEdit = this;
        var data = $('#causas').DataTable().row(this.parentElement.parentElement).data();
        var modal = $('#modal .form-group');
        modal.html('');
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/update/causas'));
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/delete/causas'));
        modal.append(newHiddenInput('id_causa', data.id_causa));
        modal.append(newInput('causa', data.causa));
        modal.append(newInput('descripcion_causa', data.descripcion_causa));
        modal.append(newInput('www_causa', data.www_causa));
        modal.append(newInput('img_causa', data.img_causa));
        $('#modal').modal('show');
    });

    $('#alumnos').on('click', 'button.editbtn', function () {
        lastEdit = this;
        var data = $('#alumnos').DataTable().row(this.parentElement.parentElement).data();
        var modal = $('#modal .form-group');
        modal.html('');
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/update/alumnos'));
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/delete/alumnos'));
        modal.append(newHiddenInput('id_alumno', data.id_alumno));
        modal.append(newInput('id_strava', data.id_strava));
        modal.append(newInput('id_curso', data.id_curso));
        $('#modal').modal('show');
    });

    $('#proyectos').on('click', 'button.editbtn', function () {
        lastEdit = this;
        var data = $('#proyectos').DataTable().row(this.parentElement.parentElement).data();
        var modal = $('#modal .form-group');
        modal.html('');
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/update/editproyectos'));
        modal.append(newHiddenInput('api', baseUrl+'api/public/api/delete/editproyectos'));
        modal.append(newHiddenInput('id_proyecto', data.id_proyecto));
        modal.append(newHiddenInput('id_empresa', data.id_empresa));
        modal.append(newHiddenInput('id_causa', data.id_causa));
        modal.append(newInput('proyecto', data.proyecto));
        modal.append(newInput('descripcion_proyecto', data.descripcion_proyecto));
        modal.append(newInput('hashtag_proyecto', data.hashtag_proyecto));
        modal.append(newInput('objetivo', data.objetivo));
        modal.append(newInput('donacion', data.donacion));
        modal.append(newInput('fecha_inicio', data.fecha_inicio));
        modal.append(newInput('fecha_fin', data.fecha_fin));
        modal.append(newInput('img_proyecto', data.img_proyecto));
        $('#modal').modal('show');
    });

});

// Funciones

function modalInsert(e){
    dataTableUpdate = e.path[2].querySelector('table');
    inputs = e.path[1].nextElementSibling.value.split(', ');
    apiroute = e.path[1].nextElementSibling.nextElementSibling.value;
    modal = $('#modaln .form-group');
    modal.html('');
    modal.append('<input type="hidden" value="'+apiroute+'"/>');
    inputs.forEach(function (elemento) {
        if (elemento.indexOf('fecha') != -1) {
            modal.append('<label>'+elemento+': <input class="form-control" required type="date" name="'+elemento+'"></label>');
        } else if(elemento == 'nivel'){
            modal.append('<label>'+elemento+': '+
            '<select class="form-control" required name="'+elemento+'">'+
            '<option value="Primaria">Primaria</option>'+
            '<option value="ESO">ESO</option>'+
            '<option value="Bachiller">Bachiller</option>'+
            '<option value="FP">FP</option>'+
            '</select></label>');
        } else if(elemento == 'id_centro'){
            modal.append('<label>'+elemento+': '+
            '<select class="form-control" required name="'+elemento+'">'+
            opcionesCentro()+
            '</select></label>');
        } else if(elemento == 'id_curso'){
            modal.append('<label>'+elemento+': '+
            '<select class="form-control" required name="'+elemento+'">'+
            opcionesCurso()+
            '</select></label>');
        } else if(elemento == 'id_causa'){
            modal.append('<label>'+elemento+': '+
            '<select class="form-control" required name="'+elemento+'">'+
            opcionesCausa()+
            '</select></label>');
        } else if(elemento == 'id_empresa'){
            modal.append('<label>'+elemento+': '+
            '<select class="form-control" required name="'+elemento+'">'+
            opcionesEmpresa()+
            '</select></label>');
        } else modal.append('<label>'+elemento+': <input class="form-control" required type="text" name="'+elemento+'"></label>');
    });
    $('#modaln').modal('show');
}

function opcionesCentro() {
    var output = "";
    centros.forEach(function(centro){
        output += '<option value="'+centro.id_centro+'">'+centro.centro+'</option>';
    });
    return output;
}

function opcionesCurso() {
    var output = "";
    cursos.forEach(function(curso){
        output += '<option value="'+curso.id_curso+'">'+curso.centro+' - '+curso.nivel+' - '+curso.curso+'</option>';
    });
    return output;
}

function opcionesCausa() {
    var output = "";
    causas.forEach(function(causa){
        output += '<option value="'+causa.id_causa+'">'+causa.causa+'</option>';
    });
    return output;
}

function opcionesEmpresa(v) {
    var output = "";
    empresas.forEach(function(empresa){
        output += '<option value="'+empresa.id_empresa+'">'+empresa.empresa+'</option>';
    });
    return output;
}

function createApi(e) {
    var formulario = e.path[2];
    $.post(formulario.children[0].children[0].value, $(formulario).serialize())
    .done(function (r) {
        $(dataTableUpdate).DataTable().ajax.reload(false);
        $('#modaln').modal('hide');
    });
}

function updateApi(e) {
    var formulario = e.path[2];
    $.post(formulario.children[0].children[0].value, $(formulario).serialize())
        .done(function (r) {
            $(lastEdit.parentElement.parentElement.parentElement.parentElement).DataTable().ajax.reload(false);
            $('#modal').modal('hide');
        });
}

function deleteApi(e) {
    var formulario = e.path[2];
    $.post(formulario.children[0].children[1].value, $(formulario).serialize())
        .done(function (r) {
            $(lastEdit.parentElement.parentElement.parentElement.parentElement).DataTable().ajax.reload(false);
            $('#modal').modal('hide');
        });
}

function newInput(key, value) {
    if(key == 'id_centro'){
        nv = opcionesCentro(value);
        return '<label>' + key + ': <select class="form-control "name="' + key + '" id="' + key + '"><option value="' + value + '">'+nv+'</option></label>';
    } else if(key == 'id_curso'){
        nv = opcionesCurso(value);
        return '<label>' + key + ': <select class="form-control "name="' + key + '" id="' + key + '"><option value="' + value + '">'+nv+'</option></label>';
    } else if(key == 'id_causa'){
        nv = opcionesCausa(value);
        return '<label>' + key + ': <select class="form-control "name="' + key + '" id="' + key + '"><option value="' + value + '">'+nv+'</option></label>';
    } else if(key == 'id_empresa'){
        nv = opcionesEmpresa(value);
        return '<label>' + key + ': <select class="form-control "name="' + key + '" id="' + key + '"><option value="' + value + '">'+nv+'</option></label>';
    } else return '<label>' + key + ': <input class="form-control" type="text" value="' + value + '" name="' + key + '" id="' + key + '"></label>';
}

function newHiddenInput(key, value) {
    return '<input readonly type="hidden" name="' + key + '" value="' + value + '" id="' + key + '">';
}

var d = document.querySelector('.radial-gradient');
document.onmousemove = function(e){
    d.style.background = 'radial-gradient(at ' + e.pageX + 'px ' + e.pageY + 'px, #3078c1, #113d63)';
}
