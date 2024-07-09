<style>
    .datepicker .datepicker-days tr:hover td {
        color: #000;
        background: #e5e2e3;
        border-radius: 0;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="header-title mb-4">INFORME DE SALIDAS POR TRABAJOS REALIZADOS</h4>
            <form method="post" id="formSalidas">
                <div class="form-group">
                    <label for="sal_Semana">* Semana</label>
                    <input type="text" class="input-sm form-control datepicker" name="txtFechas" id="txtFechas" placeholder="Selecciona la semana" />
                </div>
                <div id="divDias" class="mb-2">
                    <h5 style="vertical-align: middle !important;" for="">Dias fuera&nbsp;&nbsp;
                        <i id="btnNuevoDia" class="fe-plus-circle btnAddDia" style="color: #00c100" data-toggle="tooltip" data-placement="top" title="Agregar día"></i>
                        <i id="btnEliminarDia" class="fe-minus-circle btnRemoveDia" style="color: red" data-toggle="tooltip" data-placement="top" title="Quitar día"></i>
                    </h5>
                    <div id="dia_1" class="form-row border-primary border-bottom mb-2">
                        <div class="form-group col-md-6">
                            <label for="fecha1"> * Fecha </label>
                            <select class="form-control" id="fecha1" name="fecha[]" data-placeholder="Seleccione" required>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="socap1"> * Sucursal/Lugar </label>
                            <select class="form-control select2 socap" id="socap1" name="socap[]" data-placeholder="Seleccione" required style="width: 100%;">
                                <?php foreach ($sucursales as $sucursal) {
                                    echo '<option value="' . $sucursal['suc_SucursalID'] . '">' . $sucursal['suc_Sucursal'] . '</option>';
                                } ?>
                                <option value='0'> FEDERACION </option>
                                <option value='10001'> OTRO </option>
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="objetivo1"> * Objetivo de la visita </label>
                            <textarea rows="2" class="form-control" id="objetivo1" name="objetivo[]" placeholder="Escriba el objetivo" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="logros1"> * Logros obtenidos </label>
                            <textarea rows="2" class="form-control" id="logros1" name="logros[]" placeholder="Escriba los logros" required></textarea>
                        </div>
                    </div>
                </div>
                <button id="btnGuardar" class="btn btn-primary waves-effect waves-light">Guardar</button>
            </form>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <table id="tblSalidas" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">Acciones</th>
                                    <th>#</th>
                                    <th>Semana</th>
                                    <th>Dias</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>