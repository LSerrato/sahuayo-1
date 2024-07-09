<link href="<?=base_url("assets/plugins/fileinput/css/fileinput.css")?>" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css")?>" media="all" rel="stylesheet" type="text/css"/>
<script src="<?=base_url("assets/plugins/fileinput/js/fileinput.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/js/locales/es.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/fas/theme.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js")?>" type="text/javascript"></script>


<div class="row">
    <div class="col-12">

        <div class="card-box  ">
            
            <div class="col-md-12 mb-2">
                <?php if(revisarPermisos('Agregar',$this)){ ?>
                <a href="#" class="btn btn-success waves-light waves-effect btnModalPolitica">
                    <i class="dripicons-plus" style="top: 2px !important; position: relative"></i>
                    Agregar
                </a>
                <?php } ?>
                <?php if(revisarPermisos('Notificar',$this)){ ?>
                <a href="#" class="btn btn-warning waves-light waves-effect btnModalComCambios">
                    <i class="fas fa-concierge-bell" style="top: 2px !important; position: relative"></i>
                    Notificar 
                </a>
            <?php } ?>
            </div>
           
            <div class="table-responsive">
                <table id="tblPoliticas" class=" table table-hover " cellspacing="0" width="100%" >
                    <thead>
                    <tr>
                        <th width="5%" >Acciones</th>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Puestos</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--Modal-->
<div id="modalPolitica" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <form id="form"  method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <input id="pol_PoliticaID" name="pol_PoliticaID" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="pol_Nombre">* Nombre del documento </label>
                            <input type="text" id="pol_Nombre" class="form-control" name="pol_Nombre"  placeholder="Escriba nombre" required>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="pol_Puestos" class="col-form-label">* Puestos</label>
                            <select id="pol_Puestos" name="pol_Puestos[]" class="select2 form-control select2-multiple"  style="width: 100%" multiple="multiple" required>
                                <?php
                                    echo '<option value="0" >TODOS</option>';
                                    foreach ($puestos as $puesto){
                                        echo '<option value="'.$puesto['pue_PuestoID'].'">'.trim($puesto['pue_Nombre']).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="filePolitica" class="col-form-label">* Documento</label>
                            <div class="file-loading">
                                <input id="filePolitica" name="filePolitica" type="file" class="file" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="click" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal historial documentos ----------------->
<div id="modalHistDoctos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Historial de documentos</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="historial">

                </div>
            </div>
        </div>
    </div>
</div>


<!--------------- Modal cambios politica ----------------->
<div id="modalCambios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Historial de cambios</h4>
            </div>
            <form id="formCambios" action="<?=base_url('Comunicados/saveHistorialCambios')?>" method="post" autocomplete="off" >
                <input type="hidden" name="politicaID" id="politicaID" value="0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label for="pol_Cambios">Por favor describa el cambio en el documento, asi como algun comentario u observaciones.</label>
                                <textarea type="text" class="form-control" rows="3" name="pol_Cambios" id="pol_Cambios" ></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal notificar cambios politica ----------------->
<div id="modalNotifCambios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Notificar cambios</h4>
            </div>
            <form id="formNotCambios"  method="post" autocomplete="off" >
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="pol_Politicas" class="col-form-label">* Políticas </label>
                            <select id="pol_Politicas" name="pol_Politicas[]" class="select2 form-control select2-multiple" style="width: 100%" multiple="multiple" required>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="btnNotifCambios">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!--------------- Modalremitentes ----------------->
<div id="modalRemitentes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Destinatarios</h4>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 p-4">
                        <table class="table table-hover m-0 table-centered  nowrap" cellspacing="0" width="100%" id="tableColaboradores">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Empleado</th>
                                <th>Visto</th>
                                <th>Enterado</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('#filePolitica').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['pdf'],
        dropZoneEnabled: false,
        showUpload:false,
    });
</script>