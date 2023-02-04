<!-- Inicio script de Grafico ChartJs -->
<script>
    var chart;
    window.onload = function () {       
    chart = new Chart("chartContainer", {
        type: 'line',
        data: {
        datasets: [{
        data: []
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false,
            },
            title: {
                display: true,
                font: {
                    size: 24,                    
                },                
                text: 'Precio Unidad de Fomento (UF) en CLP'
            }
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    tooltipFormat:'MM/dd/yyyy', // <- HERE
                    displayFormats: {
                        quarter: 'MM-YYYY',
                        day: 'd-MM-yyyy',
                        month:'MM-yyyy',
                        hour:'d-MM-yyyy'
                    }
                }
            }
        }
        }
    });
    //conseguir todos los datos al cargar la pagina y mostrarlos en el grafico
    var form_action = $("#filtrarFecha").attr("action");
    $.ajax({
        data: $('#filtrarFecha').serialize(),
        url: form_action,
        type: "POST",
        dataType: 'json',
        success: function (res) {                           
            chart.data.datasets[0].data = res['y'];
            chart.data.labels =res['x'];
            chart.update();
            toastr.success('Datos grafico cargados');
        },
        error: function (data) {
            toastr.error('Ocurrio un problema,intente nuevamente');
        }
    });       
    }
</script>
<!-- Fin script de Grafico -->

<!-- Inicio base html de vista -->
<body>
    <div class="container">
    <div class="row d-flex flex-wrap-reverse mt-5">
        <div class="col-5 ">
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Nuevo valor UF</button>
            <table class="table table-dark table-striped" id="tablaIndicadores">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Fecha</th>
                        <th>Valor</th>  
                        <th>Accion</th>                  
                    </tr>
                </thead>
                <tbody>
                
                
                </tbody>
            </table>
        </div>
        <div class="d-flex  col-5 ">
            <div>
                <form id="filtrarFecha" name ="filtrarFecha" action="<?php echo site_url('/getgraph'); ?>" method="post">
                    <div>                
                        <div class="mb-3 form-group">
                            <label for="fechInicio" class="col-form-label">Desde:</label>
                            <input type="date"  required class="form-control" id="fechaInicio" name="fechaInicio">
                        </div>
                        <div class="mb-3 form-group">
                            <label for="fechaFin" class="col-form-label">Hasta:</label>
                            <input type="date"  required class="form-control" id="fechaFin" name="fechaFin">
                        </div>                                
                        <button type="submit" class="btn btn-primary">Recargar Grafico</button>
                    </div>          
                </form>
            </div>
            
            <canvas id="chartContainer" style="width:100%;max-width:700px"></canvas>
        </div>
    </div>       
    </div>
<!-- Fin base html de vista -->
<!-- Inicio Modales -->     
    <!-- Inicio Modal Create Indicador --> 
    <div class="modal fade " id="addModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Registrar nuevo valor UF</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form id="addIndicador" name ="addIndicador" action="<?php echo site_url('/create'); ?>" method="post">
            <div class="modal-body">
                
                <div class="mb-3 form-group">
                    <label for="addDate" class="col-form-label">Fecha:</label>
                    <input type="date" required class="form-control" id="addDate" name="addDate">
                </div>
                <div class="mb-3 form-group">
                    <label for="addValue" class="col-form-label">Valor en CLP:</label>
                    <input type="number" min="0" required class="form-control" id="addValue" name="addValue"></textarea>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Confirmar Registro</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Inicio Modal Update Indicador --> 
    <div class="modal fade " id="updateModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modificar valor UF</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form id="updateIndicador" name ="updateIndicador" action="<?php echo site_url('/update'); ?>" method="post">
            <div class="modal-body">                
                <div class="mb-3 form-group">
                    <label for="updateDate" class="col-form-label">Fecha(No se puede modificar):</label>
                    <input type="date" readonly required class="form-control" id="updateDate" name="updateDate">
                </div>
                <div class="mb-3 form-group">
                    <label for="updateValue" class="col-form-label">Valor en CLP:</label>
                    <input type="number" min="0" required class="form-control" id="updateValue" name="updateValue"></textarea>
                </div>
                <div class="mb-3 form-group">                    
                    <input type="hidden" required class="form-control" id="updateId" name="updateId"></textarea>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Confirmar Modificacion</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Inicio Modal Delete Indicador --> 
    <div class="modal fade " id="deleteModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Eliminar valor UF</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form id="deleteIndicador" name ="deleteIndicador"  action="<?php echo site_url('/delete'); ?>" method="post">
            <div class="modal-body">                
                <div class="mb-3 form-group">
                    <label for="deleteDate" class="col-form-label">Fecha:</label>
                    <input type="date" readonly required class="form-control" id="deleteDate" name="deleteDate">
                </div>
                <div class="mb-3 form-group">
                    <label for="deleteValue" class="col-form-label">Valor en CLP:</label>
                    <input type="number" min="0" readonly required class="form-control" id="deleteValue" name="deleteeValue"></textarea>
                </div>
                <div class="mb-3 form-group">                    
                    <input type="hidden" required class="form-control" id="deleteId" name="deleteId"></textarea>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Confirmar Eliminacion Registro</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Inicio script de datatable -->
    <script>$(document).ready( function () {
        $('#tablaIndicadores').DataTable({
            "language": {
                "decimal":        "",
                "emptyTable":     "No existen datos disponibles",
                "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered":   "(filtrado desde _MAX_ entradas totales)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrando _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing":     "",
                "search":         "Busqueda rapida:",
                "zeroRecords":    "No se encontro registro",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Ultimo",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activar para ordenar ascendentemente",
                    "sortDescending": ": activar para ordenar descendentemente"
                }
            },
            "pageLength": 31,
            "lengthMenu": [ 10, 25,31, 50, 75, 100 ],
            "columnDefs": [ {
                "targets": -1,
                "data":null,
                "defaultContent": "<button type='button' class='btn btn-primary me-3 btnModificar' data-bs-toggle='modal' data-bs-target='#updateModal'>Modificar</button><button type='button' class='btn btn-danger btnEliminar' data-bs-toggle='modal' data-bs-target='#deleteModal'>Eliminar</button>",
                } 
            ],
            "order": [[1, 'desc']],
            "columns": [
                { "data": "id" },
                { "data": "fechaindicador" },
                { "data": "valorindicador" },
                { "data": null },
                
            ],
            "ajax": {
                "url": "/get",
                "type": "GET"
            }
            
            
        });
        
        } );
        //script que inserta los datos de la fila del boton Modificar en el modal udpdateModal
        $('#tablaIndicadores tbody').on('click', '.btnModificar', function () {
            let rowData = $('#tablaIndicadores ').DataTable().row($(this).parents('tr')).data();            
            $('#updateIndicador #updateDate').val(rowData['fechaindicador']);
            $('#updateIndicador #updateValue').val(rowData['valorindicador']);
            $('#updateIndicador #updateId').val(rowData['id']);            
        });
        //script que inserta los datos de la fila del boton Eliminar en el modal deleteModal
        $('#tablaIndicadores tbody').on('click', '.btnEliminar', function () {
            let rowData = $('#tablaIndicadores ').DataTable().row($(this).parents('tr')).data();            
            $('#deleteIndicador #deleteDate').val(rowData['fechaindicador']);
            $('#deleteIndicador #deleteValue').val(rowData['valorindicador']);
            $('#deleteIndicador #deleteId').val(rowData['id']);            
        });
    </script>
    <!-- Fin script de datatable -->

    <!-- Inicio scripts de validaciones y solicitudes AJAX -->
    <!-- Inicio script de validacion y solicitud AJAX modal addModal -->
    <script>
        $(document).ready( function () {
            toastr.options.positionClass = "toast-bottom-right";
            toastr.options.closeButton = true;
            $("#addIndicador").validate({                
                messages:{

                },
                submitHandler: function (form) {
                    var form_action = $("#addIndicador").attr("action");
                    $.ajax({
                        data: $('#addIndicador').serialize(),
                        url: form_action,
                        type: "POST",
                        dataType: 'json',
                        success: function (res) {                           
                            $('#tablaIndicadores').DataTable().ajax.reload();
                            $('#addModal').modal('hide');                            
                            toastr.success('Indicador registrado correctamente');
                        },
                        statusCode: {
                            402: function (response) {
                                toastr.error('Indicador con esta fecha ya existe,intente nuevamente');
                            }
                        },
                        error: function (data) {
                            toastr.error('Ocurrio un problema,intente nuevamente');
                        }
                    });
                }
            });
        });    
    </script>
    <!-- Inicio script de validacion y solicitud AJAX modal updateModal -->
    <script>
        $(document).ready( function () {
            $("#updateIndicador").validate({                
                messages:{

                },
                submitHandler: function (form) {
                    var form_action = $("#updateIndicador").attr("action");
                    $.ajax({
                        data: $('#updateIndicador').serialize(),
                        url: form_action,
                        type: "POST",
                        dataType: 'json',
                        success: function (res) {                           
                            $('#tablaIndicadores').DataTable().ajax.reload();
                            $('#updateModal').modal('hide');
                            toastr.success('Indicador modificado correctamente');
                        },
                        error: function (data) {
                            toastr.error('Ocurrio un problema,intente nuevamente');
                        }
                    });
                }
            });
        });    
    </script>
    <!-- Inicio script de validacion y solicitud AJAX modal deleteModal -->
    <script>
        $(document).ready( function () {
            $("#deleteIndicador").validate({                
                messages:{

                },
                submitHandler: function (form) {
                    var form_action = $("#deleteIndicador").attr("action");
                    $.ajax({
                        data: $('#deleteIndicador').serialize(),
                        url: form_action,
                        type: "POST",
                        dataType: 'json',
                        success: function (res) {                           
                            $('#tablaIndicadores').DataTable().ajax.reload();
                            $('#deleteModal').modal('hide');
                            
                            toastr.success('Indicador eliminado correctamente');
                        },
                        error: function (data) {
                            toastr.error('Ocurrio un problema,intente nuevamente');
                        }
                    });
                }
            });
        });    
    </script>
    <!-- Inicio script de validacion y solicitud AJAX fechas grafico -->
    <script>
        $(document).ready( function () {
            $("#filtrarFecha").validate({                
                messages:{

                },
                submitHandler: function (form) {
                    var form_action = $("#filtrarFecha").attr("action");
                    $.ajax({
                        data: $('#filtrarFecha').serialize(),
                        url: form_action,
                        type: "POST",
                        dataType: 'json',
                        success: function (res) {     
                            chart.data.datasets[0].data = res['y'];
                            chart.data.labels =res['x'];
                            chart.update();                   
                            toastr.success('Datos grafico actualizados correctamente');
                        },
                        error: function (data) {
                            toastr.error('Ocurrio un problema,intente nuevamente');
                        }
                    });
                }
            });
        });    
    </script>
    <!-- Fin scripts de validacion y solicitudes modal AJAX-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>
