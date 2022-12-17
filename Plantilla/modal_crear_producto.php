<div class="modal fade" id="modal_crear_producto" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div  style="border-radius: 30px 30px 30px 30px;" class=" modal-content panel panel-primary">
                    
                    <div style="border-radius: 30px 30px 0px 0px;" class="modal-header panel-heading">
                    <h4>Crear Producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                    </div>

                        <div class="modal-body panel-body">
                        
                                <div id='error2'></div>

                                    <div id="imagen_2" style='text-align:center'>
                                     
                                    </div> 

                                        <form id="form_subir2">

                                                    <div class="container">
                                                            <div class="box" style="text-align:center">
                                                                <input type="file" name="archivo" id="miarchivo2" required class="inputfile inputfile-6" accept=".jpg">
                                                                <label for="miarchivo2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>Elige un archivo&hellip;</span></label>
                                                            </div>
                                                    </div>
                                                        
                                                    <div class="barra" style="color:white">
                                                        <div class="barra_azul" id="barra_estado2">
                                                            <span></span>
                                                        </div>
                                                    </div>                                        
                                          <br>
                                                    <div class='form-horizontal' action="">
                                                
                                                            <div class="form-group row">
                                                                     <label class="col-sm-3 control-label">Producto</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" style='width:100%' name="nombre_2"  autocomplete="off" class="form-control"  placeholder='Escriba el nombre..' required>
                                                                        </div>
                                                            </div>
            
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Costo</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="number" name="costo_2"  autocomplete="off" class="form-control"   placeholder='Escriba el costo..' ><i>en Bs.</i>
                                                                    </div>
                                                            </div> 

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Unidad</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="unidad_2"  autocomplete="off" class="form-control"   placeholder='Escriba la unidad..'  required/>
                                                                    </div>
                                                            </div>

                                                            
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Piezas por caja</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="number" name="piezas_2"  autocomplete="off" class="form-control"   placeholder='Escriba las piezas..' required >
                                                                    </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 control-label">Barras</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="barras_2"  autocomplete="off" class="form-control"   placeholder='Escriba el codigo de barras..'  required>
                                                                    </div>
                                                            </div>

                                                            <input type="hidden" value="<?php echo $id_empresa1?>" id="input_empresa_crear" name="id_empresa">                                                  
                                                    </div>

                                                    <div class="acciones" style="text-align:center">
                                                            <input type="submit"  style='color:white;border-radius: 20px 0px 0px 20px;' class="btn btn-primary" value="Guardar">
                                                            <input type="button"  style='color:white;border-radius: 0px 20px 20px 0px;' class="btn btn-danger" id="cancelar_2" value="Cancelar">          
                                                    </div> 
                                         </form>                   
                        </div>
                                    
        
                        <div class="modal-footer">
                        
                           <!--  <a type="button" class="btn btn-primary" style='color:white'>Modificar</a> -->
                            <a type="button" class="btn btn-danger" style='color:white;border-radius: 20px 20px 20px 20px;' data-dismiss="modal">Cerrar</a>
                      
                        </div>
             
         </div>
    </div>
</div>
