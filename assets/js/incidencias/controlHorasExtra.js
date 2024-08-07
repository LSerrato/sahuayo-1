(function ($) {
    var formHoras = $("#formHoras");
    var btnGuardar = $("#btnGuardar");

    var tblHoras = $("#tblHoras").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getMisHorasExtra",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "count"},
            { "data": "rep_Fecha"},
            { "data": "rep_Horas"},
            { "data": "rep_Motivos"},
            { "data": "rep_TipoPago",render: function(data,type,row){return tipoPago(data,type,row)}},
            { "data": "rep_Estado",render: function (data,type,row) {return estatus(data)}}
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Mis horas extra',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn btn-warning",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Mis horas extra',
                text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
                titleAttr: "Exportar a PDF",
                className: "btn btn-warning",
                orientation: 'landscape',
                pageSize: 'LETTER',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn btn-light",
            }
        ],
        language: {
            paginate: {
                previous:"<i class='mdi mdi-chevron-left'>",
                next:"<i class='mdi mdi-chevron-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:"Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered:"(filtrado de _MAX_ registros)",
            "processing": "Procesando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "<i class='mdi mdi-chevron-right'>",
                "sPrevious": "<i class='mdi mdi-chevron-left'>"
            },

        },
        "order": [[ 1, "asc" ]],
        "processing":false
    });

    function acciones(data,type,row){

        var urlImprimir = BASE_URL+'PDF/imprimirReporteHorasExtra/'+row.rep_ReporteHoraExtraID;

        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Reporte horas" title="Formato reporte">'+
            '<i class="dripicons-print"></i></a>';

        var btnEliminar = '';
        var btnEnviar = '';
        if(row.rep_Estado == 'CREADO') {
            btnEliminar = '<a href="#" class="btn btn-danger btn-block waves-light waves-effect btnEliminarInforme" ' +
                'data-id="'+row.rep_ReporteHoraExtraID+'" title="Eliminar">' +
                '<i class="dripicons-trash"></i></a>';
            btnEnviar = '<a href="#" class="btn btn-primary btn-block waves-light waves-effect btnEnviarInforme" ' +
            'data-id="'+row.rep_ReporteHoraExtraID+'" title="Enviar">' +
            '<i class="mdi mdi-send"></i></a>';
        }//if

        return btnImprimir + btnEliminar + btnEnviar;
    }//accionesPermisosEmpleado

    function tipoPago(data,type,row){
        var html = data;
        switch (data){
            case 'Nomina':html = '<span class="badge badge-success p-1">Via nomina</span>';break;
            case 'Tiempo por tiempo':html = '<span class="badge badge-secondary p-1">Tiempo por tiempo</span>';break;
            case null: html='<span class="badge badge-dark p-1">Pendiente</span>';
        }//switch

        return html;
    }


    function estatus(data,type,row){
        var html = data;
        switch (data){
            case 'CREADO':html = '<span class="badge badge-purple p-1">CREADO</span>';break;
            case 'PENDIENTE':html = '<span class="badge badge-dark p-1">PENDIENTE</span>';break;
            case 'AUTORIZADO':html = '<span class="badge badge-warning p-1">AUTORIZADO</span>';break;
            case 'APLICADO':html = '<span class="badge badge-success p-1">APLICADO</span>';break;
            case 'RECHAZADO':html = '<span class="badge badge-danger p-1">RECHAZADO</span>';break;
            case 'RECHAZADO_RH':html = '<span class="badge badge-danger p-1">RECHAZADO</span>';break;
            case 'PAGADO':html = '<span class="badge badge-info p-1">PAGADO</span>';break;
            case 'DECLINADO':html = '<span class="badge badge-light-danger p-1">DECLINADO</span>';break;
        }//switch

        return html;
    }

    //Guardar
    $("form").submit(function (evt) {
        evt.preventDefault();
        btnGuardar.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...');
        $.ajax({
            url: BASE_URL + "Incidencias/ajaxAddReporteHorasExtras",
            type: "POST",
            data: formHoras.serialize(),
            dataType: "json"
        }).done(function (data) {
            btnGuardar.html('Guardar');
            if(data.code === 1) {
                Swal.fire({
                    type: 'success',
                    title: '¡Solicitud registrado!',
                    text: 'La solicitud se guardó correctamente',
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
            }
            else if(data.code == 2)
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            else
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
            btnGuardar.html('Guardar');
        });//ajax
    });

    //Eliminar reporte
    $("body").on("click",".btnEliminarInforme",function (e) {
        var reporteID = $(this).data("id");

        Swal.fire({
            title: 'Eliminar solicitud',
            text: '¿Esta seguro que desea eliminar la solicitud de horas extra?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value)
                ajax_deleteInforme(reporteID);
        })

    });

    function ajax_deleteInforme(reporteID){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_deleteReporteHorasExtra',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {reporteID:reporteID}
        }).done(function(data){
            if (data.code === 1){
                tblHoras.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Solicitud eliminada!',
                    text: 'La solicitud de horas extra se elimino correctamente.',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });
    }


    //Enviar reporte
    $("body").on("click",".btnEnviarInforme",function (e) {
        var reporteID = $(this).data("id");
        Swal.fire({
            title: 'Enviar solicitud',
            text: '¿Esta seguro que desea enviar a revisión la solicitud de horas extra?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value)
                ajax_sendInforme(reporteID,$(this));
        })

    });

    function ajax_sendInforme(reporteID,button){

        button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Enviando...');

        $.ajax({
            url: BASE_URL+'Incidencias/ajax_enviarReporteHorasExtra',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {reporteID:reporteID}
        }).done(function(data){
            if (data.code === 1){
                tblHoras.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Solicitud enviada!',
                    text: 'La solicitud de horas extra se envio correctamente.',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
            button.html('');
        });
    }

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: false,
        date: false,
        cancelText: 'Cancelar',
        okText: 'Aceptar',
    });

    function showNotification(tipo,msg){
        $.toast({
            text:msg,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    }//showNotification

    $(".datepicker").datepicker({
        todayHighlight:!0,
        autoclose:!0,
        format: "yyyy-mm-dd",
        daysOfWeek:["D","L","M","M","J","V","S"],
        monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
    });

    
})(jQuery);