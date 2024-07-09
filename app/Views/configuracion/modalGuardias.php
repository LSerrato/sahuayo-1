<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="modalAddGuardiaMasivo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">&nbsp;Importar guardias</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-md-12 text-center mb-2">
                    <h5><a class="text-muted" href="<?=base_url('assets/plantillaGuardias.xlsx')?>">Puedes encontrar la plantilla aquí</a></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <form action="#" class="dropzone" id="id_drop">
                            <input id="centro" name="centro" hidden>
                            <div class="fallback">
                                <input name="file" type="file">
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted mdi mdi-cloud-upload"></i>
                                </div>

                                <h4>Arrastra o da click para subir archivos.</h4>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>