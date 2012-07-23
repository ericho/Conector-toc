$(document).ready(function(){
	llenarPestanasDeck();
	window.reporte_temp_tub_fria = new Array();
	window.reporte_temp_tub_caliente = new Array();
	window.reporte_temp_sal_caliente = new Array();
	window.reporte_temp_tuberia = new Array();
    window.reporte_alternador = new Array();


	window.URLaJSON = "/js/json.php";
	setInterval("iniciar()", 10000);
	iniciar();
        $(function(){
	    $("#fecha_reporte").datepicker({dateFormat: 'yy-mm-dd'});
	    $("#fecha2_reporte").datepicker({dateFormat: 'yy-mm-dd'});
	    $("#fecha_evento").datepicker({dateFormat: 'yy-mm-dd'});
	});
    
	$("#boton_descargar").click(function(){
        if ($("#reporte_diario").is(":checked")){
            var fecha = $("#fecha_reporte").val();
            descargarDatosReporte(fecha);   
        }
    });
    
    $("#boton_reporte").click(function(){
        if ($("#reporte_diario").is(":checked")){
            var fecha = $("#fecha_reporte").val();
            obtenerJSONReporte(fecha);   
        }
        else if($("#reporte_rango").is(":checked")){
		  var fecha1 = $("#fecha_reporte").val();
		  var fecha2 = $("#fecha2_reporte").val();
		  obtenerReporteRango(fecha1, fecha2);
	    }
    });

    $("#forma_reporte").submit(function(){
	    return false;
	});

    $("#forma_eventos").submit(function(){
            var fecha = $("#fecha_evento").val();
            obtenerReporteEventos(fecha);
            return false;
	});

    });


function llenarPestanasDeck(){
    var html = "<div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button><button id="boton_descargar">Descargar datos</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="500" height="210" ></canvas><br/><canvas id="grafica_nivel_reporte" width="500" height="180"></canvas></div>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Mostrar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#eventos").html(html_eventos);
}


function iniciar(){
    var url = window.URLaJSON + "?id=14";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}


function descargarDatosReporte(fecha){
    var url = window.URLaJSON + "?id=14" + String.fromCharCode(38) + "act=5"  + String.fromCharCode(38) + "fecha=" + fecha;
    window.location.href = url;
}


function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_grafica_rpm = "grafica_rpm";
    var id_tabla_reciente = "#tabla_datos_reciente";

    // limpiando canvas
  //  RGraph.Clear(document.getElementById(id_grafica_rpm));    

    // Obteniendo graficas 

    var html = "Ultima actividad : " + json.fecha_hora + "<br/> <h1>Contador alternador : " + json.alternador +"</h1>";
    
//    var grafica_rpm = obtenerGraficaRPM(id_grafica_rpm, json.rpm);
 //   var tabla_reciente = obtenerTablaRecientes(json);
    
    // Dibujando graficas
    //grafica_rpm.Draw();
    $(id_tabla_reciente).html(html);

}


function obtenerGraficaRPM(id, rpm){

    var min = 0;
    var max = 2000;

    var grafica = new RGraph.Meter(id, min, max, rpm);
            
    var grad1 = grafica.context.createRadialGradient(grafica.canvas.width / 2, grafica.canvas.height - 25,0,grafica.canvas.width / 2,grafica.canvas.height - 25,200);
    grad1.addColorStop(0, 'green');
    grad1.addColorStop(1, 'white');
            
    var grad2 = grafica.context.createRadialGradient(grafica.canvas.width / 2, grafica.canvas.height - 25,0,grafica.canvas.width / 2, grafica.canvas.height - 25,200);
    grad2.addColorStop(0, 'yellow');
    grad2.addColorStop(1, 'white');
            
    var grad3 = grafica.context.createRadialGradient(grafica.canvas.width / 2, grafica.canvas.height - 25,0,grafica.canvas.width / 2, grafica.canvas.height - 25,200);
    grad3.addColorStop(0, 'red');
    grad3.addColorStop(1, 'white');
            
    grafica.Set('chart.labels.position', 'inside');
    grafica.Set('chart.title', 'RPM');
    grafica.Set('chart.title.vpos', 0.5);
    grafica.Set('chart.title.color', 'black');
    grafica.Set('chart.green.color', grad1);
    grafica.Set('chart.yellow.color', grad2);
    grafica.Set('chart.red.color', grad3);
    grafica.Set('chart.border', false);
    grafica.Set('chart.needle.linewidth', 5);
    grafica.Set('chart.needle.tail', true);
    grafica.Set('chart.tickmarks.big.num', 0);
    grafica.Set('chart.tickmarks.small.num', 0);
    grafica.Set('chart.segment.radius.start', 100);
    grafica.Set('chart.needle.radius', 80);
    grafica.Set('chart.needle.linewidth', 2);
    grafica.Set('chart.linewidth.segments', 15);
    grafica.Set('chart.strokestyle', 'white');
    grafica.Set('chart.text.size', 10);
    grafica.Draw();

    return grafica;
}

function obtenerTablaRecientes(datos){
    var html = '<table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variables</b></td><td><b>Estado</b></td></tr></thead>';
    html += "<tr><td>Sensor inclinacion</td>";
    if (datos.inclinacion_estado == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Alternador</td>";
    if (datos.alternador == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "</table>";
    return html;
}

function obtenerReporteEventos(fecha){
   
   var url = window.URLaJSON + "?id=14" + String.fromCharCode(38) + "act=4" + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
	var html = "<table><tr><td>Fecha</td><td>Evento</td></tr>";
       
	$.each(json, function(index, ejson){
		html += '<tr><td>' + ejson.fecha + '</td><td>' + ejson.evento + '</td></tr>';
	});
	html += "</table>";
        
	$("#tabla_eventos").html(html);
    });
}
