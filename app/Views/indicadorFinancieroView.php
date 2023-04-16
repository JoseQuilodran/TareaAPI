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
                    tooltipFormat:'MM/dd/yyyy', 
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
    $.ajax({
        data: $('#filtrarFecha').serialize(),
        url: '<?php echo site_url('/getgraph'); ?>',
        type: "POST",
        dataType: 'json',
        success: function (res) {                           
            chart.data.datasets[0].data = res['y'];
            chart.data.labels =res['x'];
            chart.update();
            var fInicio =$('#fechaInicio');
            var fFin =$('#fechaFin');   
            fInicio.val(res['x'][res['x'].length -1]);
            fFin.val(res['x'][0]);
            $('#fechaLabel').hide()
            toastr.info('Datos grafico cargados');
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
    <div class=" d-flex container-fluid flex-wrap-reverse justify-content-center my-3">    
        <div class="">
            <button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#addModal">Nuevo valor UF</button>
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
        <div class=" mx-5 " >           
            <form  id="filtrarFecha" name ="filtrarFecha" onSubmit="getGrafico()" action="javascript:void(0);" method="post">
                <div class="d-flex flex-row justify-content-center " >                
                    <div class="mx-3 form-group">
                        <label for="fechInicio" class="col-form-label">Desde:</label>
                        <input type="date"  required class="form-control" id="fechaInicio" name="fechaInicio">
                    </div>
                    <div class=" mx-3 form-group">
                        <label for="fechaFin" class="col-form-label">Hasta:</label>
                        <input type="date"  required class="form-control" id="fechaFin" name="fechaFin">
                    </div>    
                    <div class="d-flex flex-column mt-4 mx-2">
                        <button type="submit" class="btn btn-primary" id="fechaButton" name="fechaButton" >Filtrar Grafico</button>
                        <label  for="fechaButton" id="fechaLabel" class="col-form-label" style="color:red;font-size:12px;">"Desde" debe ser menor o igual a "Hasta"</label>                         

                    </div>   
                    
                </div>          
            </form>
            <canvas id="chartContainer" ></canvas>
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
        <form id="addIndicador" name ="addIndicador" onSubmit="createIndicador()" action="javascript:void(0);" method="post">
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
                <button type="submit"  class="btn btn-primary">Confirmar Registro</button>
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
        <form id="updateIndicador" name ="updateIndicador" onSubmit="modificarIndicador()" action="javascript:void(0);" method="post">
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
        <form id="deleteIndicador" name ="deleteIndicador" onSubmit="eliminarIndicador()" action="javascript:void(0);" method="post">
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
    <!-- Inicio Modal Acerca de --> 
    <div class="modal fade " id="aboutModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Acerca De:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>        
            <div class="modal-body">              
            <h1 id="-tareaapi">#TareaAPI -Jose Quilodran 2023</h1>
            <p><strong>Mini proyecto para mostrar consumo de API y grafico de Unidad de Fomento en codeigniter 4</strong> </p>
            <h3 id="acerca-de">Acerca de</h3>
            <ul>
            <li>Se utiliza el Framework Codeigniter 4. para montar rapidamente, utilizar "php spark serve"</li>
            <li>PostgreSql 15, crear base de datos en este caso &#39;TestAPIDB&#39;, ingresar datos en archivo .env (renombrar archivo env).</li>
            <li>El sistema utiliza crud, por lo que el certificado cacert.pem debe estar configurado correctamente en php.ini para solicitudes seguras.</li>
            <li>El sistema utiliza la api de <a href="https://postulaciones.solutoria.cl/index.html">https://postulaciones.solutoria.cl/index.html</a> , se asume que el Schema de esta pagina es el correcto.</li>
            <li>El sistema hace una solicidtud de token JWT, el usuario debe ser proporsionado por usted en el campo API_USERNAME de .env .</li>
            </ul>
            <h3 id="consideraciones">Consideraciones</h3>
            <ul>
            <li>Solo se almacenan en la base de datos los datos relacionados con la unidad de Fomento</li>
            <li>Se asume que solo los campos de fecha y valor pueden cambiar, el resto se ingresan a la base de datos estaticamente.</li>
            </ul>
            <h3 id="dependencias">Dependencias</h3>
            <h5 id="el-sistema-utiliza-los-siguientes-cdn-para-su-funcionamiento-">El sistema utiliza los siguientes cdn para su funcionamiento:</h5>
            <ul>
            <li>Bootstrap 5 y su stylesheet</li>
            <li>JQuery 3.6.3</li>
            <li>Datatables 1.13.1 y su stylesheet</li>
            <li>Toastr 2.1.4 y su stylesheet</li>
            <li>Chart.js 4.2.0 y chartjs-adapter-date-fns</li>
            </ul>
            <h5 id="las-siguientes-configuraciones-de-php-ini-se-descomentaron-para-su-utilizacion-">Las siguientes configuraciones de php.ini se descomentaron para su utilizacion:</h5>
            <ul>
            <li>curl.cainfo</li>
            <li>extension=curl</li>
            <li>extension=intl</li>
            <li>extension=mbstring</li>
            <li>extension=pgsql</li>
            </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> 
            </div>
        </div>
    </div>
    </div>
    <!-- Fin Modal Acerca De-->
    <!-- Inicio scripts solicitudes AJAX -->
    <script>
    // solicita un array con dos listas xy para el grafico con las fechas entregadas, si la solicitud esta vacia, se reciben todos los puntos -->
    function getGrafico(){
        
        $.ajax({
            data: $('#filtrarFecha').serialize(),
            url: '<?php echo site_url('/getgraph'); ?>',
            type: "POST",
            dataType: 'json',
            success: function (res) {     
                chart.data.datasets[0].data = res['y'];
                chart.data.labels =res['x'];
                chart.update();                   
                toastr.info('Datos grafico actualizados correctamente');
            },
            error: function (data) {
                toastr.error('Ocurrio un problema,intente nuevamente');
            }
        });
    }
    //Inicio script de solicitud AJAX modal addModal -->
    function createIndicador(){
        $.ajax({
            data: $('#addIndicador').serialize(),
            url:  '<?php echo site_url('/create'); ?>',
            type: "POST",
            dataType: 'json',
            success: function (res) {                           
                $('#tablaIndicadores').DataTable().ajax.reload();
                $('#addModal').modal('hide');                 
                getGrafico();           
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
     //Inicio script de solicitud AJAX modal updateModal -->
    function modificarIndicador(){
        $.ajax({
            data: $('#updateIndicador').serialize(),
            url: '<?php echo site_url('/update'); ?>',
            type: "POST",
            dataType: 'json',
            success: function (res) {                           
                $('#tablaIndicadores').DataTable().ajax.reload();
                $('#updateModal').modal('hide');
                getGrafico();
                toastr.success('Indicador modificado correctamente');
            },
            error: function (data) {
                toastr.error('Ocurrio un problema,intente nuevamente');
            }
        });
        
    }
     // Inicio script de solicitud AJAX modal deleteModal -->
    function eliminarIndicador(){
        $.ajax({
            data: $('#deleteIndicador').serialize(),
            url:  '<?php echo site_url('/delete'); ?>',
            type: "POST",
            dataType: 'json',
            success: function (res) {                           
                $('#tablaIndicadores').DataTable().ajax.reload();
                $('#deleteModal').modal('hide');
                getGrafico();                
                toastr.success('Indicador eliminado correctamente');
            },
            error: function (data) {
                toastr.error('Ocurrio un problema,intente nuevamente');
            }
        });
    }
    //Inicio script de configuracion Datatable -->
    $(document).ready( function () {
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
        });
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

    <!-- Configuracion Toastr -->
    <script>
        $(document).ready( function () {
            toastr.options.positionClass = "toast-bottom-right";
            toastr.options.closeButton = true;
    });    
    // Inicio script de validacion fechas grafico -->       
        var fInicio =$('#fechaInicio');
        var fFin =$('#fechaFin');   
        var fButton =$('#fechaButton'); 
        var fLabel =$('#fechaLabel'); 
        fInicio.on('change', function(){
            var dataInicio = fInicio.val();  
            var dataFin = fFin.val();  
            if(dataInicio>dataFin){
                fButton.attr('disabled','disabled');
                fLabel.show();
            }else{
                fButton.removeAttr('disabled');
                fLabel.hide();
            }            
        });
        fFin.on('change', function(){
            var dataInicio = fInicio.val();  
            var dataFin = fFin.val();  
            if(dataInicio>dataFin){
                fButton.attr('disabled','disabled');
                fLabel.show();
            }else{
                fButton.removeAttr('disabled');
                fLabel.hide();
            }            
        });
       
    //-- Fin script de validacion fechas grafico -->       
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>
