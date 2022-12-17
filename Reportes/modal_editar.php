<form id="editar_estacion">
<div class="modal fade" id="modal_editar_estacion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div  style="border-radius: 30px 30px 30px 30px;" class=" modal-content panel panel-primary">
                    
                    <div style="border-radius: 30px 30px 0px 0px;" class="modal-header panel-heading">
                    <h4>Editar Estacion</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                    </div>

                        <div class="modal-body container" style="text-align:center">

                                                    <input type="hidden" id="id_estacion" name="id_estacion">


                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Nombre de estacion</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" style='width:100%' name="nombre_estacion_e"  id="nombre_estacion_e" autocomplete="off" class="form-control"  placeholder='Escriba el nombre..' required>
                                                            </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Regional</label>
                                                        <div class="col-sm-8">
                                                            <select name="id_regional_e" id="id_regional_e" class="form-control" required>
                                                               
                                                                <?php
                                                                $sql="SELECT * FROM tblRegional";
                                                                $query_sql=sqlsrv_query($con,$sql);
                                                                $count=sqlsrv_has_rows($query_sql);
                                                                if($count!=false){
                                                                    while($row=sqlsrv_fetch_array($query_sql)){
                                                                        echo "<option value='".$row['idRegional']."'>".$row['regional']."</option>";
                                                                    }  
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Provincia</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" style='width:100%' id="provincia_e" name="provincia_e"  autocomplete="off" class="form-control"  placeholder='Escriba la provincia..' required>
                                                            </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Municipio</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="municipio_e" name="municipio_e" autocomplete="off" class="form-control"   placeholder='Escriba el municipio..' >
                                                            </div>
                                                    </div> 

                                                         
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Localidad</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="localidad_e" id="localidad_e" autocomplete="off" class="form-control"   placeholder='Escriba el localidad..' >
                                                            </div>
                                                    </div> 

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Ubicacion ambiente</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="ubicacion_e" name="ubicacion_e" autocomplete="off" class="form-control"   placeholder='Escriba la ubicacion..'  required/>
                                                            </div>
                                                    </div>

                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">id</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" id="id_e" name="id_e" autocomplete="off" class="form-control"   placeholder='Escriba el id..' required >
                                                            </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Sistema</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="sistema_e" name="sistema_e" autocomplete="off" class="form-control"   placeholder='Escriba el sistema..'  required>
                                                            </div>
                                                    </div>

                                                    
                                                    <div class="form-group">                               
                                                        <div class="panel panel-primary"> 
                                                                    <div class="panel-heading" style='font-weight:bold;font-size:200%'>Ubique la dirección</div>

                                                                                <div class="panel-body" style='padding-top:0px'>
                                                                                    <div id="refresh2"><div id="map2"></div></div>
                                                                                    <input type="text" name="longitud_e" value="-68.13047964471085" hidden=true id="inputLongitud_e">
                                                                                    <input type="text" name="latitud_e" value="-16.483609396261936" hidden=true id="inputLatitud_e">
                                                                                </div>
                                                                
                                                        </div>            
                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Distancia en (Km)</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" id="distancia_e" name="distancia_e" autocomplete="off" class="form-control"   placeholder='Escriba la distancia..'  required><i>Solo digite numeros</i>
                                                            </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Ruteo</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="ruteo_e" name="ruteo_e"  autocomplete="off" class="form-control"   placeholder='Escriba el ruteo..'  required>
                                                            </div>
                                                    </div>  
                        </div>         
        
                        <div class="modal-footer">

                            <input type="submit" name="add" class="btn btn-success" style='color:white;border-radius: 10px;' value="Guardar datos">
                            <a type="button" class="btn btn-danger" style='color:white;border-radius: 10px;' data-dismiss="modal">Cerrar</a>
                            
                        </div>
             
         </div>
    </div>
</div>
</form>
