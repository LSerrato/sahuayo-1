<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row clearfix">
    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="card-box ">
            <div class="body pt-2">
                <div class="collapse show text-center" id="frmRegistroCliente">
                    <div class="col-md-12 thumb-lg member-thumb mx-auto text-center">
                        <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $empleado['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    </div>
                    <div class="col-md-12 text-center">
                        <h4 class="nombre"><?= $empleado['emp_Nombre'] ?></h4>
                        <label class="col-md-12 mb-0">Puesto</label>
                        <span class="text-muted"><?= $empleado['pue_Nombre'] ?></span>
                        <h4><span class="badge badge-light"> Número de Colaborador: <strong><?= $empleado['emp_Numero'] ?></strong></span></h4>
                        <h4><span class="badge badge-light"> Fecha de Ingreso: <strong><?= shortDate($empleado['emp_FechaIngreso']) ?></strong></span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="card-box pt-2">
            <div class="body pt-2">
                <div class="collapse show" id="frmRegistroPermiso">
                    <form id="frmPermiso" method="post" autocomplete="off">
                        <div class="position-relative row form-group">
                            <div class="col-md-12 mb-2">
                                <label>*Tipo de permiso</label>
                                <select name="txtTipoPermiso" id="txtTipoPermiso" class="form-control " data-placeholder="Seleccionar tipo de permiso" style="width: 100% !important;" required>
                                    <option value="" hidden>Seleccione</option>
                                    <?php
                                    if (isset($catalogoPermisos)) {
                                        if (count($catalogoPermisos) > 0) {
                                            foreach ($catalogoPermisos as $cat) {
                                                $id = (int)$cat['cat_CatalogoPermisoID'];
                                                $name = $cat['cat_Nombre'];
                                                if ($empleado['emp_EstadoCivil'] == 'CASADO (A)' && ($cat['cat_Identificador'] == 'permisoCumpleanios' || $cat['cat_Identificador'] == 'permisoBoda')) $readonly = 'hidden';
                                                elseif ($empleado['emp_EstadoCivil'] != 'CASADO (A)' && $cat['cat_Identificador'] == 'aniversarioBoda') $readonly = 'hidden';
                                                else $readonly = "";
                                                if ($id == 7 && $horasExtra == 0) $readonly = 'hidden';
                                                echo '<option ' . $readonly . '   value="' . $id . '">' . $name . '</option>';
                                            }
                                        } else
                                            echo '<option disabled>No hay tipos de permisos registrados</option>';
                                    } else
                                        echo '<option disabled>No hay tipos de permisos registrados</option>';
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label>*Período del permiso</label>
                                    <div class="input-daterange input-group datepicker">
                                        <input type="text" class="input-sm form-control datepicker" name="txtFechaInicio" id="txtFechaInicio" placeholder="Fecha Inicio" required>
                                        <span class="input-group-addon"></span>
                                        <input type="text" class="input-sm form-control datepicker" name="txtFechaFin" id="txtFechaFin" placeholder="Fecha Fin" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" id="divMisHoras">
                                <div class="position-relative form-group">
                                    <label>Mis horas</label>
                                    <input id="totalHoras" name="totalHoras" class="form-control" readonly value="<?= $horasExtra ?>">
                                    <input id="dia" name="dia" class="form-control" readonly hidden value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-md-5" id="divHoraSalida">
                                <div class="position-relative form-group">
                                    <label id="labelInicio">Hora Inicio</label>
                                    <input class="form-control timepicker" placeholder="Seleccione la hora" id="txtHoraI" name="txtHoraI">
                                </div>
                            </div>
                            <div class="col-md-5" id="divHoraRegreso">
                                <div class="position-relative form-group">
                                    <label id="labelFin">Hora Fin</label>
                                    <input class="form-control timepicker" placeholder="Seleccione la hora" id="txtHoraF" name="txtHoraF">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="per_Motivos" class="">
                                        <span>Motivos</span>
                                    </label>
                                    <textarea name="txtMotivos" id="txtMotivos" placeholder="Motivo del permiso" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-left align-self-center">
                                <button class="btn btn-success" id="btnRegistarPermiso"><span><i class="fe-plus"></i> Registrar</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Tabla de mis permiso-->
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <table id="tblPermisos" class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="5%">Acciones</th>
                        <th>Tipo permiso</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de fin</th>
                        <th>Días</th>
                        <th>Motivos</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>