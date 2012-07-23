$(document).ready(function(){
	llenarPestanasDeck();
	window.reporte_tuberia_1 = new Array();
	window.reporte_tuberia_2 = new Array();
	window.reporte_caliente = new Array();
	window.reporte_fria = new Array();


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

    $("#reporte_rango").click(function(){
	    if($("#reporte_rango").is(":checked")){
		  $("#fecha2_reporte").attr("disabled", false);
		  $("#l_fecha").text("Fecha inicial : ");
	    }
	    else{
		  $("#fecha2_reporte").attr("disabled", true);
	    }
	});

    $("#reporte_diario").click(function(){
	    if($("#reporte_diario").is(":checked")){
		  $("#fecha2_reporte").attr("disabled", true);
		  $("#l_fecha").text("Seleccionar fecha : ");
	    }
	    else{
		  $("#fecha2_reporte").attr("disabled", false);
	    }
	});

	
    });


function llenarPestanasDeck(){
    var html = "<div width='100%' height:'250'><canvas id='termo_tub_fria' width='80px' height='250px' style='float:left'></canvas><canvas id='termo_tub_caliente' width='80' height='250' style='float:left'></canvas><canvas id='termo_sal_caliente' width='80' height='250' style='float:left'></canvas><canvas id='termo_tuberia' width='80' height='250' style='float:left'></canvas></div><div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button><button id="boton_descargar">Descargar datos</button></form></div><div id="id_exportar"></div><center><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="650" height="250" ></canvas><br/><canvas id="grafica_temps_reporte" width="500" height="180"></canvas></div></center>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Mostrar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#eventos").html(html_eventos);
}


function iniciar(){
    var url = window.URLaJSON + "?id=4";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}



function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_termo_tub_fria = "termo_tub_fria";
    var id_termo_tub_caliente = "termo_tub_caliente";
    var id_termo_sal_caliente = "termo_sal_caliente";
    var id_termo_tuberia = "termo_tuberia";
    var id_tabla_reciente = "#tabla_datos_reciente";

    // limpiando canvas
    RGraph.Clear(document.getElementById(id_termo_tub_fria));    
    RGraph.Clear(document.getElementById(id_termo_tub_caliente));
    RGraph.Clear(document.getElementById(id_termo_sal_caliente));
    RGraph.Clear(document.getElementById(id_termo_tuberia));

    // Obteniendo graficas 

    var termo_tub_fria = obtenerTermoTubFria(id_termo_tub_fria, json.temp_tuberia_1);
    var termo_tub_caliente = obtenerTermoTubCaliente(id_termo_tub_caliente, json.temp_tuberia_2);
    var termo_tub_salida = obtenerTermoTubSalida(id_termo_sal_caliente, json.temp_agua_caliente);
    var termo_tuberia = obtenerTermoTuberia(id_termo_tuberia, json.temp_agua_fria);
//    var tabla_reciente = obtenerTablaRecientes(json);

    var html = "Ultima actividad : " + json.fecha_hora;

    // Dibujando graficas
    termo_tub_fria.Draw();
    termo_tub_caliente.Draw();
    termo_tub_salida.Draw();
    termo_tuberia.Draw();
    $(id_tabla_reciente).html(html);

}

function obtenerTermoTubFria(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Tuberia 1");
    return termo;
}

function obtenerTermoTubCaliente(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Tuberia 2");
    return termo;
}

function obtenerTermoTubSalida(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Agua caliente");
    return termo;
}

function obtenerTermoTuberia(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Agua fria");
    return termo;
}



function obtenerTablaRecientes(datos){
    var html = '<table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variable</b></td><td><b>Estado</b></td></tr></thead>';
    html += "<tr><td>Sensor LDR1</td>";
    if (datos.sensor_ldr1 == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Sensor LDR2</td>";
    if (datos.sensor_ldr2 == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Sensor LDR3</td>";
    if (datos.sensor_ldr3 == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Sensor LDR2</td>";
    if (datos.motor_seguidor == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Posicion Calentador</td><td>" + datos.posicion_calentador + " °</td></tr>";
    html += "</table>";
    return html;
}

function obtenerReporteEventos(fecha){
   
   var url = window.URLaJSON + "?id=4" + String.fromCharCode(38) + "act=4" + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
	var html = "<table><tr><td>Fecha</td><td>Evento</td></tr>";
       
	$.each(json, function(index, ejson){
		html += '<tr><td>' + ejson.fecha + '</td><td>' + ejson.evento + '</td></tr>';
	});
	html += "</table>";
        
	$("#tabla_eventos").html(html);
    });
}

function descargarDatosReporte(fecha){
    var url = window.URLaJSON + "?id=4" + String.fromCharCode(38) + "act=5"  + String.fromCharCode(38) + "fecha=" + fecha;
    window.location.href = url;
}

function obtenerJSONReporte(fecha){
    var url = window.URLaJSON + "?id=4" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
	window.reporte_tuberia_1 = [];
	window.reporte_tuberia_2 = [];
	window.reporte_caliente = [];
	window.reporte_fria = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){
	    window.reporte_tuberia_1.push(ejson.temp_tuberia_1);
	    window.reporte_tuberia_2.push(ejson.temp_tuberia_2);
	    window.reporte_caliente.push(ejson.temp_agua_caliente);
	    window.reporte_fria.push(ejson.temp_agua_fria);
	    window.reporte_fechas.push(ejson.fecha_hora);
	});
	dibujarGraficasReporte();
    });
}

function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=4&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){
	window.reporte_tuberia_1 = [];
	window.reporte_tuberia_2 = [];
	window.reporte_caliente = [];
	window.reporte_fria = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){
	    window.reporte_tuberia_1.push(ejson.temp_tuberia_1);
	    window.reporte_tuberia_2.push(ejson.temp_tuberia_2);
	    window.reporte_caliente.push(ejson.temp_agua_caliente);
	    window.reporte_fria.push(ejson.temp_agua_fria);
	    window.reporte_fechas.push(ejson.fecha_hora);
	});
	dibujarGraficasReporte();
    });
}


function dibujarGraficasReporte(){
    var id_grafica_niveles = "grafica_temp_reporte";
 
   
    // Limpiando Canvas 
    RGraph.Clear(document.getElementById(id_grafica_niveles));

    var reporte_nivel = obtenerGraficaTemps(id_grafica_niveles);

    reporte_nivel.Draw();
}

function crearArregloTooltips(){
    var arreglo = new Array();
    for (var i=0; i<window.reporte_tuberia_1.length; i++){
	arreglo.push("<b>" + window.reporte_tuberia_1[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_tuberia_2.length; i++){
	arreglo.push("<b>" + window.reporte_tuberia_2[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
	//arreglo.push(window.reporte_tuberia_2[i].toString());
    }
    for (var i=0; i<window.reporte_caliente.length; i++){
	arreglo.push("<b>" + window.reporte_caliente[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_fria.length; i++){
	arreglo.push("<b>" + window.reporte_fria[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}


function obtenerGraficaTemps(id){
    var grafica = new RGraph.Line(id, [window.reporte_tuberia_1, window.reporte_tuberia_2, window.reporte_caliente, window.reporte_fria]);
    var arreglos = crearArregloTooltips();
    
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Temperaturas');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.linewidth', 1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key', ['Tuberia 1', 'Tuberia 2', 'Agua Caliente', 'Agua fria']);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    grafica.Set('chart.tooltips', arreglos);
    grafica.Set('chart.tooltips.effect', 'contract');
    if (!RGraph.isIE8()){
	grafica.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
	grafica.Set('chart.zoom.delay', 10);
	grafica.Set('chart.zoom.frames', 25);
	grafica.Set('chart.zoom.vdir', 'center');
    }
    grafica.Set('chart.title.xaxis', 'Lecturas')
    
    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#6b22d7', '#309f14', '#d53a26', '#263cd5']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);

    return grafica;
}