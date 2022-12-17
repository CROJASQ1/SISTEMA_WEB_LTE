<form id="agregar_estacion">
    <div class="modal fade" id="modal_agregar_estacion" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div  style="border-radius: 30px 30px 30px 30px;" class=" modal-content panel panel-primary">
                        
                        <div style="border-radius: 30px 30px 0px 0px;" class="modal-header panel-heading">
                        <h4 id='response_cabezera'>Agregar Estación</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            
                        </div>

                            <div class="modal-body panel-body">
                            
                                            <div class='form-horizontal' action="">

                                            

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Nombre de estacion</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" style='width:100%' name="nombre_estacion"  autocomplete="off" class="form-control"  placeholder='Escriba el nombre..' required>
                                                            </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Regional</label>
                                                        <div class="col-sm-8">
                                                            <select name="id_regional" class="form-control" required>
                                                               
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
                                                                <input type="text" style='width:100%' name="provincia"  autocomplete="off" class="form-control"  placeholder='Escriba la provincia..' required>
                                                            </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Municipio</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="municipio"  autocomplete="off" class="form-control"   placeholder='Escriba el municipio..' >
                                                            </div>
                                                    </div> 

                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Localidad</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="localidad"  autocomplete="off" class="form-control"   placeholder='Escriba el localidad..' >
                                                            </div>
                                                    </div> 

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Ubicacion ambiente</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="ubicacion"  autocomplete="off" class="form-control"   placeholder='Escriba la ubicacion..'  required/>
                                                            </div>
                                                    </div>

                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">id</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="id"  autocomplete="off" class="form-control"   placeholder='Escriba el id..' required >
                                                            </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Sistema</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="sistema"  autocomplete="off" class="form-control"   placeholder='Escriba el sistema..'  required>
                                                            </div>
                                                    </div>

 

                                                    <div class="form-group">                               
                                                        <div class="panel panel-primary"> 
                                                                    <div class="panel-heading" style='font-weight:bold;font-size:200%'>Ubique la dirección</div>

                                                                                <div class="panel-body" style='padding-top:0px'>
                                                                                    <div id="refresh"><div id="map"></div></div>
                                                                                    <input type="text" name="longitud" value="-68.13047964471085" hidden=true id="inputLongitud">
                                                                                    <input type="text" name="latitud" value="-16.483609396261936" hidden=true id="inputLatitud">
                                                                                </div>
                                                                
                                                        </div>            
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Distancia en (Km)</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="distancia"  autocomplete="off" class="form-control"   placeholder='Escriba la distancia..'  required>
                                                            </div>
                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label">Ruteo</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="ruteo"  autocomplete="off" class="form-control"   placeholder='Escriba el ruteo..'  required>
                                                            </div>
                                                    </div>

                                                                                            
                                            </div>


                            </div>
                                        
            
                            <div class="modal-footer">
                            
                                    <button type="submit" class="btn btn-success" style='color:white;border-radius: 10px 10px 10px 10px;'>Guardar</button>
                                    <button type="button" class="btn btn-danger" style='color:white;border-radius: 10px 10px 10px 10px;' data-dismiss="modal">Cerrar</button>
                        
                            </div>
                
            </div>
        </div>
    </div>
</form>
