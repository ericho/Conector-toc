$(document).ready(function(){
	llenarPestanasDeck();
	window.reporte_humedad = new Array();
	window.reporte_temperatura = new Array();
	window.reporte_fechas = new Array();

	window.URLaJSON = "/js/json.php";
	setInterval("iniciar()", 10000);
	iniciar();
	
	
    $(function(){
	    $("#fecha_reporte").datepicker({dateFormat: 'yy-mm-dd'});
	    $("#fecha2_reporte").datepicker({dateFormat: 'yy-mm-dd'});
	    $("#fecha_evento").datepicker({dateFormat: 'yy-mm-dd'});
	});
    

    $("#forma_reporte").submit(function(){
	    if($("#reporte_diario").is(":checked")){
		  var fecha = $("#fecha_reporte").val();
		  obtenerJSONReporte(fecha);
	    }
	    else if($("#reporte_rango").is(":checked")){
		  var fecha1 = $("#fecha_reporte").val();
		  var fecha2 = $("#fecha2_reporte").val();
		  obtenerReporteRango(fecha1, fecha2);
	    }
	    return false;
	});

    $("#forma_eventos").submit(function(){
        var fecha = $("#fecha_evento").val();
//      obtenerReporteEventos(fecha);

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
    var html = "<div width='100%' height:'250'><canvas id='temperatura' width='80px' height='250px' style='float:left'></canvas></div><div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_humedad_reporte" width="650" height="250" ></canvas><br/><canvas id="grafica_temperatura_reporte" width="650" height="250"></canvas></div>';

    var html_configuracion = '<form id="forma_configuracion"><label>Motor d&iacute;as : </label><input type="text" name="motor_dias" id="motor1b"><br/><button id="boton_config">Enviar configuraci&oacute;n</button></form><div id="mensaje_configuracion"></div>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Cargar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#configuracion").html(html_configuracion);
    $("#eventos").html(html_eventos);
}


function iniciar(){
    var url = window.URLaJSON + "?id=9";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}


function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_temperatura = "temperatura";
    var id_tabla_reciente = "#tabla_datos_reciente";

    // limpiando canvas
    RGraph.Clear(document.getElementById(id_temperatura));    

    // Obteniendo graficas 

    var termo = obtenerTermo(id_temperatura, json.temperatura);
    var tabla_reciente = obtenerTablaRecientes(json);
    
    // Dibujando graficas
    termo.Draw();
    $(id_tabla_reciente).html(tabla_reciente);

}

function obtenerTermo(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 50, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Temperatura");
    return termo;
}

function obtenerTablaRecientes(datos){
    var html = 'Ultima actividad : ' + datos.fecha + '<table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variables</b></td><td><b>Estado</b></td></tr></thead>';
    html += "<tr><td>Motor estado</td>";
    if (datos.motor_estado == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }

    html += "<tr><td>Frecuencia </td><td>" + datos.motor_frecuencia + " d&iacute;as</td></tr>";
    html += "<tr><td>Humedad </td><td>" + datos.humedad + " %</td></tr>";
    html += "</table>";
    return html;
}


function obtenerJSONReporte(fecha){
    var url = window.URLaJSON + "?id=9" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
	window.reporte_humedad = [];
	window.reporte_temperatura = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){
	    window.reporte_humedad.push(ejson.humedad);
	    window.reporte_temperatura.push(ejson.temperatura);
	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}

function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=9&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){
	window.reporte_humedad = [];
	window.reporte_temperatura = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){
	    window.reporte_humedad.push(ejson.humedad);
	    window.reporte_temperatura.push(ejson.temperatura);
	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}


function dibujarGraficasReporte(){
    var id_grafica_humedad = "grafica_humedad_reporte";
    var id_grafica_temperatura = "grafica_temperatura_reporte"
 
   
    // Limpiando Canvas 
    RGraph.Clear(document.getElementById(id_grafica_humedad));
    RGraph.Clear(document.getElementById(id_grafica_temperatura));

    var reporte_humedad = obtenerGraficaHumedad(id_grafica_humedad);
    var reporte_temperatura = obtenerGraficaTemp(id_grafica_temperatura);

    reporte_humedad.Draw();
    reporte_temperatura.Draw();
}

function crearArregloTooltipsHumedad(){
    var arreglo = new Array();
    for (var i=0; i<window.reporte_humedad.length; i++){
	   arreglo.push("<b>" + window.reporte_humedad[i].toString() + " %</b><br />" + window.reporte_fechas[i]);
    }
    
    return arreglo;
}

function crearArregloTooltipsTemperatura(){
    
    var arreglo = new Array();
    for (var i=0; i<window.reporte_temperatura.length; i++){
	   arreglo.push("<b>" + window.reporte_temperatura[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}


function obtenerGraficaHumedad(id){
    var grafica = new RGraph.Line(id, window.reporte_humedad);
    var arreglos = crearArregloTooltipsHumedad();
    
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Humedad');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.linewidth', 1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key', ['Humedad']);
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
    grafica.Set('chart.colors', ['#6b22d7']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);
//  '#309f14', '#d53a26', '#263cd5'
    return grafica;
}


function obtenerGraficaTemp(id){
    var grafica = new RGraph.Line(id, window.reporte_temperatura);
    var arreglos = crearArregloTooltipsTemperatura();
    
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Temperatura');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.linewidth', 1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key', ['Temperatura']);
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
    grafica.Set('chart.colors', ['#d53a26']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);
//  '#309f14', '#d53a26', '#263cd5'
    return grafica;
}
