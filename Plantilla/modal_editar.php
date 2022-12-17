<form id="crear_paciente">
<div class="modal fade" id="modal_editar_paciente" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div  style="border-radius: 30px 30px 30px 30px;" class=" modal-content panel panel-primary">
                    
                    <div style="border-radius: 30px 30px 0px 0px;" class="modal-header panel-heading">
                    <h4>Editar Paciente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                    </div>

                        <div class="modal-body container" style="text-align:center">
                
                     
                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Apellido Paterno</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="ape_paterno"  name="ape_paterno" class="form-control" placeholder="Escriba el apellido..." required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Apellido Materno</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="ape_materno" name="ape_materno" class="form-control" placeholder="Escriba el apellido..." required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Nombres</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="nombres" name="nombres" class="form-control" placeholder="Escriba los nombres..." required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Categoria</label>
                                    <div class="col-sm-3">
                                        <select id="categoria_select" name="categoria" class="form-control" required>
                                            <option value=""> Seleccionar </option>
                                            <option value="SI">Recien nacido</option>
                                            <option value="NO">No recien nacido</option>
                                        </select>
                                    </div>
                                </div>

                                 <div id="resultado_editar"></div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Dirección</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="direccion" name="Direccion" class="form-control" placeholder="Escriba la dirección..." required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Departamento</label>
                                    <div class="col-sm-3">
                                        <select id="departamento" name="departamento" class="form-control" required>
                                            <option value=""> Seleccionar </option>
                                            <option value="Lapaz">La Paz</option>
                                            <option value="Oruro">Oruro</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Municipio</label>
                                    <div class="col-sm-3">
                                        <select id="municipio" name="municipio" class="form-control" required>
                                            <option value=""> Seleccionar </option>
                                            <option value="yyyy">yyyy</option>
                                            <option value="pppp">pppp</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Localidad</label>
                                    <div class="col-sm-3">
                                        <select id="localidad" name="localidad" class="form-control" required>
                                            <option value=""> Seleccionar </option>
                                            <option value="aaaaaa">aaaaaa</option>
                                            <option value="bbbbbbb">bbbbbbb</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Nombre Apoderado</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="nombre_apo" name="nombre_apo" class="form-control" placeholder="Nombre apoderado..." required >
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">C.I. Apoderado</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="ci_apo" name="ci_apo" class="form-control" placeholder="C.I. apoderado..." required >
                                    </div>
                                </div> 


                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Telefonos Apoderado</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="tel_apo" name="tel_apo" class="form-control" placeholder="Telefono asegurado..." required >
                                    </div>
                                </div> 

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Direccion Apoderado</label>
                                    <div class="col-sm-4">
                                        <input type="text" id="dir_apo" name="dir_apo" class="form-control" placeholder="Dirección apoderado..." required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Fecha de nacimiento apoderado</label>
                                    <div class="col-sm-4">
                                        <input type="date" id="fec_apo" name="fec_apo" class="input-group date form-control" date="" data-date-format="dd/mm/yyyy" autocomplete="off" placeholder="00/00/0000" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Grupo sanguineo</label>
                                    <div class="col-sm-3">
                                        <select id="grupo_san_apo" name="grupo_san_apo" class="form-control" required>
                                            <option value=""> Seleccionar </option>
                                            <option value="O Rh+">O Rh+</option>
                                            <option value="O Rh-">O Rh-</option>
                                            <option value="A Rh+">A Rh+</option>
                                            <option value="A Rh-">A Rh-</option>
                                            <option value="B Rh+">B Rh+</option>
                                            <option value="B Rh-">B Rh-</option>
                                            <option value="AB Rh+">AB Rh+</option>
                                            <option value="AB Rh-">AB Rh-</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Sexo</label>
                                    <div class="col-sm-3">
                                        <select id="sexo_apo" name="sexo_apo" class="form-control" required>
                                            <option value=""> Seleccionar </option>
                                            <option value="O Rh+">Masculino</option>
                                            <option value="O Rh-">Femenino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-6 control-label">Antecedentes patologicos</label>
                                    <div class="col-sm-4">
                                    <textarea style='height:100px;resize: none;' id="antecedentes" name="antecedentes" class="input-group date form-control"  autocomplete="off" placeholder="Escribe los antecedentes" required></textarea>
                                    </div>
                                </div>

                                

                                <br>

               
                         
                        </div>         
        
                        <div class="modal-footer">

                            <input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
                            <a type="button" class="btn btn-danger" style='color:white;border-radius: 20px 20px 20px 20px;' data-dismiss="modal">Cerrar</a>
                            
                        </div>
             
         </div>
    </div>
</div>
</form>
