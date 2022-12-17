<div class="modal fade" id="modal_pregunta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
        <div  style="border-radius: 30px 30px 30px 30px;" class=" modal-content panel panel-primary">
                    
                    <div style="border-radius: 30px 30px 0px 0px;" class="modal-header panel-heading">
                    <h4 id='response_cabezera'>Estas Seguro?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                    </div>

                        <div class="modal-body panel-body">
                        
                                <h4 id='respuesta_cuerpo'>Esta seguro de eliminar este producto?</h4>
                                <input type="hidden" id="id_borrar">
                        </div>
                                    
        
                        <div class="modal-footer">
                        
                                  <a type="button" class="btn btn-success" style='color:white;border-radius: 10px 10px 10px 10px;' data-dismiss="modal" onclick="borrar_producto($('#id_borrar').val())" >Si</a>
                                  <a type="button" class="btn btn-danger" style='color:white;border-radius: 10px 10px 10px 10px;' data-dismiss="modal">No</a>
                      
                        </div>
             
         </div>
    </div>
</div>
