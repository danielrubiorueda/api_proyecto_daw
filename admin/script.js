var lastEdit;

$(document).ready(function () {

    // Agrega botones para la inserción de filas
    $('h3').append(
        '<button class="ml-2 btn btn-success">+</button>'
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
            url: 'http://localhost/fct/api/public/api/alumnos',
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
            url: 'http://localhost/fct/api/public/api/editproyectos',
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
            url: 'http://localhost/fct/api/public/api/empresas',
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
            url: 'http://localhost/fct/api/public/api/cursos',
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
            url: 'http://localhost/fct/api/public/api/centros',
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
            url: 'http://localhost/fct/api/public/api/causas',
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
            url: 'http://localhost/fct/api/public/api/mensajes',
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
        modal.append(newHiddenInput('api', 'http://fct.api/api/update/cursos'));
        modal.append(newHiddenInput('api', 'http://fct.api/api/delete/cursos'));
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
        modal.append(newHiddenInput('api', 'http://fct.api/api/update/centros'));
        modal.append(newHiddenInput('api', 'http://fct.api/api/delete/centros'));
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
        modal.append(newHiddenInput('api', 'http://fct.api/api/update/empresas'));
        modal.append(newHiddenInput('api', 'http://fct.api/api/delete/empresas'));
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
        modal.append(newHiddenInput('api', 'http://fct.api/api/update/causas'));
        modal.append(newHiddenInput('api', 'http://fct.api/api/delete/causas'));
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
        modal.append(newHiddenInput('api', 'http://fct.api/api/update/alumnos'));
        modal.append(newHiddenInput('api', 'http://fct.api/api/delete/alumnos'));
        modal.append(newHiddenInput('id_alumno', data.id_alumno));
        modal.append(newInput('id_strava', data.id_strava));
        modal.append(newInput('curso', data.id_curso));
        $('#modal').modal('show');
    });

    $('#proyectos').on('click', 'button.editbtn', function () {
        lastEdit = this;
        var data = $('#proyectos').DataTable().row(this.parentElement.parentElement).data();
        var modal = $('#modal .form-group');
        modal.html('');
        modal.append(newHiddenInput('api', 'http://fct.api/api/update/editproyectos'));
        modal.append(newHiddenInput('api', 'http://fct.api/api/delete/editproyectos'));
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
    return '<label>' + key + ': <input class="form-control" type="text" value="' + value + '" name="' + key + '" id="' + key + '"></label>';
}

function newHiddenInput(key, value) {
    return '<input readonly type="hidden" name="' + key + '" value="' + value + '" id="' + key + '">';
}