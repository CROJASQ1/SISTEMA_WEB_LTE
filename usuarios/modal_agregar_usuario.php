<form id="agregar_usuario">
    <div class="modal fade" id="modal_agregar_usuario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div  style="border-radius: 30px 30px 30px 30px;" class=" modal-content panel panel-primary">
                        
                    <div style="border-radius: 30px 30px 0px 0px;" class="modal-header panel-heading">
                    <h4>Crear Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                        <div class="modal-body panel-body">
  
                                                            <div class="form-group row">
                                                                    <label class="col-sm-3 control-label">Nombres</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" style='width:100%' name="nombres"  autocomplete="off" class="form-control"  placeholder='Escriba el nombre..' required>
                                                                    </div>
                                                            </div>
            
                                                     
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Usuario</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="usuario" autocomplete="off" class="form-control"   placeholder='Escriba el usuario'  required/>
                                                                    </div>
                                                            </div>

                                                            
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Contraseña</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="contraseña"  autocomplete="off" class="form-control"   placeholder='Ingrese la contraseña' required >
                                                                    </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Rol</label>
                                                                    <div class="col-sm-8">
                                                                        <select name="rol" class="form-control">
                                                                                <?php
                                                                                    $sql="SELECT * FROM tblRoles";
                                                                                    $query_sql=sqlsrv_query($con,$sql);
                                                                                    while($row=sqlsrv_fetch_array($query_sql)){
                                                                                        echo "<option value='".$row['idRol']."'>".$row['rol']."</option>";
                                                                                    }
                                                                                ?>
                                                                        </select>
                                                                        
                                                                    </div>
                                                            </div>  

                                                             <div class="form-group row">
                                                                <label class="col-sm-3 control-label">E-mail</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="email" name="email"  autocomplete="off" class="form-control" placeholder="Escriba el email" required >
                                                                    </div>
                                                            </div>     

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Regional</label>
                                                                    <div class="col-sm-8">
                                                                        <select name="regional" class="form-control">
                                                                       
                                                                                <?php
                                                                                $sql="SELECT * FROM tblRegional";
                                                                                $query_sql=sqlsrv_query($con,$sql);
                                                                                while($row=sqlsrv_fetch_array($query_sql)){
                                                                                    echo "<option value='".$row['idRegional']."'>".$row['regional']."</option>";
                                                                                }
                                                                                
                                                                                ?>
                                                                        </select>
                                                                        
                                                                    </div>
                                                            </div>    

                                                
                        </div>
                                    
        
                        <div class="modal-footer">
                        
                            <input type="submit" class="btn btn-primary" style='border-radius: 10px;' value="Guardar"> 
                            <button class="btn btn-danger" style='border-radius: 10px;' data-dismiss="modal">Cerrar</button>
                      
                        </div>
             
            </div>
        </div>
    </div>
</form>