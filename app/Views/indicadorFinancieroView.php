<?php
 
$dataPoints = array();

foreach ($indicadores_uf as $row) {
	
	array_push($dataPoints, array("x" => strtotime($row['fechaindicador'])*1000, "y" => $row['valorindicador']));
}

?>

<script>
window.onload = function () {
CanvasJS.addCultureInfo("es", 
{                     
    shortMonths: ["En", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Agto", "Sept", "Oct", "Nov", "Dic"]
    
});
 
var chart = new CanvasJS.Chart("chartContainer", {
    culture:  "es",
	animationEnabled: true,
	//theme: "light2",
	title:{
		text: "Precio de la Unidad De Fomento (UF)"
	},
	axisX:{
        title: "Fecha",
        valueFormatString: "DD MMM YYYY",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY:{
		title: "Pesos Chilenos (CLP)",
		includeZero: true,
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	toolTip:{
		enabled: false
	},
	data: [{
		type: "area",
        xValueType: "dateTime",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<body>
    <div class="container">
    <div class="row mt-5">
        <div class="  col ">
            <table class="table table-dark table-striped" id="tablaIndicadores">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Fecha</th>
                        <th>Valor</th>                    
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($indicadores_uf as $row) {
                ?>        
                <tr id= "<?php echo $row['id']; ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fechaindicador']; ?></td>
                    <td><?php echo $row['valorindicador']; ?></td>
                </tr>
                <?php } ?>   
                
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center col-8 ">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        </div>
    </div>
        

    </div>
    
    
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
                "zeroRecords":    "NO se encontro el registro",
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
            "lengthMenu": [ 10, 25,31, 50, 75, 100 ]
        });
        
        } );
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
