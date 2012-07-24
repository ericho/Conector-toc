$(document).ready(function(){
	llenarPestanasDeck();
	window.reporte_temp_ambiente = new Array();
	window.reporte_temp_interior = new Array();
	window.reporte_temp_agua = new Array();
	window.reporte_humedad_1 = new Array();
	window.reporte_humedad_2 = new Array();
	window.reporte_nivel_agua = new Array();
	window.reporte_fechas = new Array();
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
    var html = "<div width='100%' height:'250'><canvas id='termo_ambiente' width='80px' height='250px' style='float:left'></canvas><canvas id='termo_interior' width='80' height='250' style='float:left'></canvas><canvas id='termo_agua' width='80' height='250' style='float:left'></canvas><canvas id='grafica_humedad' width='200' height='200' style='float:left'></canvas><canvas id='grafica_nivel' width='200' height='200' style='float:left'></canvas><br /></div><div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button><button id="boton_descargar">Descargar datos</button></form></div><div id="id_exportar"></div><center><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="650" height="250" ></canvas><br/><canvas id="grafica_nivel_reporte" width="650" height="250"></canvas><br /><canvas id="grafica_humedad_reporte" width="650" height="250"></canvas></div></center>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Mostrar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#eventos").html(html_eventos);
}

function iniciar(){
    var url = window.URLaJSON + "?id=12";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}

function obtenerReporteEventos(fecha){
   
   var url = window.URLaJSON + "?id=12" + String.fromCharCode(38) + "act=4" + String.fromCharCode(38) + "fecha=" + fecha;
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
    var url = window.URLaJSON + "?id=12" + String.fromCharCode(38) + "act=5"  + String.fromCharCode(38) + "fecha=" + fecha;
    window.location.href = url;
}

function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_termo_ambiente = "termo_ambiente";
    var id_termo_interior = "termo_interior";
    var id_termo_agua = "termo_agua";
    var id_humedad = "grafica_humedad";
    var id_nivel = "grafica_nivel";
    var id_tabla_reciente = "#tabla_datos_reciente";

    // limpiando canvas
    RGraph.Clear(document.getElementById(id_termo_ambiente));    
    RGraph.Clear(document.getElementById(id_termo_interior));
    RGraph.Clear(document.getElementById(id_termo_agua));
    RGraph.Clear(document.getElementById(id_humedad));
    RGraph.Clear(document.getElementById(id_nivel));

    // Obteniendo graficas 

    var termo_ambiente = obtenerTermoAmbiente(id_termo_ambiente, json.temp_ambiente);
    var termo_interior = obtenerTermoInterior(id_termo_interior, json.temp_interior);
    var termo_agua = obtenerTermoAgua(id_termo_agua, json.temp_agua);
    var humedad = obtenerGraficaHumedad(id_humedad, json);
    var nivel = obtenerGraficaNivel(id_nivel, json.flujo_agua);
    var html = obtenerTablaRecientes(json);
//    var tabla_reciente = obtenerTablaRecientes(json);

    // Dibujando graficas
    termo_ambiente.Draw();
    termo_interior.Draw();
    termo_agua.Draw();
    humedad.Draw();
    nivel.Draw();
    $(id_tabla_reciente).html(html);
}

function obtenerTermoAmbiente(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Ambiente");
    return termo;
}

function obtenerTermoInterior(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Interior");
    return termo;
}

function obtenerTermoAgua(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Agua");
    return termo;
}

function obtenerGraficaHumedad(id, json){
    
    var grafica_humedad = new RGraph.Bar(id, [json.humedad_1, json.humedad_2]);
    grafica_humedad.Set('chart.labels', [json.fecha]);
    grafica_humedad.Set('chart.background.barcolor1', 'white');
    grafica_humedad.Set('chart.background.barcolor2', 'white');
    grafica_humedad.Set('chart.background.grid', true);
    grafica_humedad.Set('chart.ymax', 100);
    grafica_humedad.Set('chart.outofbounds', true);
    grafica_humedad.Set('chart.tooltips', [json.humedad_1 + "%", json.humedad_2 + "%"]);
    grafica_humedad.Set('chart.tooltips.effect', 'contract');
    //grafica_humedad.Set('chart.title', 'Nivel contenedor');
    //grafica_humedad.Set('chart.title.vpos', 0.65);
    //grafica_humedad.Set('chart.title.hpos', 0.1);
    grafica_humedad.Set('chart.colors', ['#3366ff']);
    grafica_humedad.Set('chart.fillstyle', ['rgba(33,66,ff,0.3)']);
    grafica_humedad.Set('chart.key', ['Humedad 1', 'Humedad 2']);
    grafica_humedad.Set('chart.key.position', ['gutter']);
    grafica_humedad.Set('chart.key.position.gutter.boxed', false);
    if (!RGraph.isIE8()){
	   grafica_humedad.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
	   grafica_humedad.Set('chart.zoom.delay', 10);
	   grafica_humedad.Set('chart.zoom.frames', 25);
	   grafica_humedad.Set('chart.zoom.vdir', 'center');
    }
    return grafica_humedad;
}

function obtenerGraficaNivel(id, json){
    
    var grafica_humedad = new RGraph.Bar(id, [json.flujo_agua]);
    grafica_humedad.Set('chart.labels', [json.fecha]);
    grafica_humedad.Set('chart.background.barcolor1', 'white');
    grafica_humedad.Set('chart.background.barcolor2', 'white');
    grafica_humedad.Set('chart.background.grid', true);
    grafica_humedad.Set('chart.ymax', 100);
    grafica_humedad.Set('chart.outofbounds', true);
    grafica_humedad.Set('chart.tooltips', [json.flujo_agua]);
    grafica_humedad.Set('chart.tooltips.effect', 'contract');
    //grafica_humedad.Set('chart.title', 'Nivel contenedor');
    //grafica_humedad.Set('chart.title.vpos', 0.65);
    //grafica_humedad.Set('chart.title.hpos', 0.1);
    grafica_humedad.Set('chart.colors', ['#3366ff']);
    grafica_humedad.Set('chart.fillstyle', ['rgba(33,66,ff,0.3)']);
    grafica_humedad.Set('chart.key', ['Nivel agua']);
    grafica_humedad.Set('chart.key.position', ['gutter']);
    grafica_humedad.Set('chart.key.position.gutter.boxed', false);
    if (!RGraph.isIE8()){
	   grafica_humedad.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
	   grafica_humedad.Set('chart.zoom.delay', 10);
	   grafica_humedad.Set('chart.zoom.frames', 25);
	   grafica_humedad.Set('chart.zoom.vdir', 'center');
    }
    return grafica_humedad;
}

function obtenerTablaRecientes(datos){
    
    var html = 'Ultima actividad registrada:' + datos.fecha + '<br /><table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variables</b></td><td><b>Estado</b></td></tr></thead>';
     html += "<tr><td>Estado LDR</td>";
    if (datos.ldr_estado == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Estado motor</td>";
    if (datos.motor_estado == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }

    html += "</table>";
    return html;
}

function obtenerJSONReporte(fecha){
    var url = window.URLaJSON + "?id=12" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){

	window.reporte_temp_ambiente = [];
	window.reporte_temp_interior = [];
	window.reporte_temp_agua = [];
	window.reporte_humedad_1 = [];
	window.reporte_humedad_2 = [];
	window.reporte_nivel_agua = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){
	    window.reporte_temp_ambiente.push(parseFloat(ejson.temp_ambiente));
	    window.reporte_temp_interior.push(parseFloat(ejson.temp_interior));
	    window.reporte_temp_agua.push(parseFloat(ejson.temp_agua));
	    window.reporte_humedad_1.push(parseInt(ejson.humedad_1));
	    window.reporte_humedad_2.push(parseInt(ejson.humedad_2));
	    window.reporte_nivel_agua.push(parseInt(ejson.flujo_agua));
	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}

function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=12&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){
	window.reporte_temp_ambiente = [];
	window.reporte_temp_interior = [];
	window.reporte_temp_agua = [];
	window.reporte_humedad_1 = [];
	window.reporte_humedad_2 = [];
	window.reporte_nivel_agua = [];
	window.reporte_fechas = [];

	$.each(json, function(index, ejson){
	    window.reporte_temp_ambiente.push(parseFloat(ejson.temp_ambiente));
	    window.reporte_temp_interior.push(parseFloat(ejson.temp_interior));
	    window.reporte_temp_agua.push(parseFloat(ejson.temp_agua));
	    window.reporte_humedad_1.push(parseInt(ejson.humedad_1));
	    window.reporte_humedad_2.push(parseInt(ejson.humedad_2));
	    window.reporte_nivel_agua.push(parseInt(ejson.flujo_agua));
	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}

function dibujarGraficasReporte(){
    var id_grafica_temps = "grafica_temp_reporte";
    var id_grafica_nivel = "grafica_nivel_reporte";
    var id_grafica_humedad = "grafica_humedad_reporte";
    
    // Limpiando Canvas 
    RGraph.Clear(document.getElementById(id_grafica_temps));
    RGraph.Clear(document.getElementById(id_grafica_niveles));
    RGraph.Clear(document.getElementById(id_grafica_humedad));

    var reporte_temp = obtenerGraficaTempReporte(id_grafica_temps);
    var reporte_nivel = obtenerGraficaNivelReporte(id_grafica_nivel);
    var reporte_humedad = obtenerGraficaHumedadReporte(id_grafica_humedad);

    reporte_temp.Draw();
    reporte_nivel.Draw();
    reporte_humedad.Draw();
}

function crearArregloTooltipsTemp()
{
    var arreglo = new Array();
    for (var i=0; i<window.reporte_temp_ambiente.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_ambiente[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_temp_interior.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_interior[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
	//arreglo.push(window.reporte_tuberia_2[i].toString());
    }
    for (var i=0; i<window.reporte_temp_agua.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_agua[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}

function crearArregloTooltipsHumedad()
{
    var arreglo = new Array();
    for (var i=0; i<window.reporte_humedad_1.length; i++){
	   arreglo.push("<b>" + window.reporte_humedad_1[i].toString() + "%</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_humedad_2.length; i++){
	   arreglo.push("<b>" + window.reporte_humedad_2[i].toString() + "%</b><br />" + window.reporte_fechas[i]);
    }

    return arreglo;
}


function crearArregloTooltipsNivel()
{
    var arreglo = new Array();
    for (var i=0; i<window.reporte_nivel_agua.length; i++){
	   arreglo.push("<b>" + window.reporte_nivel_agua[i].toString() + "%</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}

function obtenerGraficaTempReporte(id){
    var grafica = new RGraph.Line(id, [window.reporte_temp_ambiente, window.reporte_temp_interior, window.reporte_temp_agua]);
    var arreglo = crearArregloTooltipsTemp();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Temperaturas');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.key', ['Ambiente', 'Interna', 'Agua']);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    grafica.Set('chart.tooltips', arreglo);
    grafica.Set('chart.tooltips.effect', 'contract');
    if (!RGraph.isIE8()){
        grafica.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
        grafica.Set('chart.zoom.delay', 10);
        grafica.Set('chart.zoom.frames', 25);
        grafica.Set('chart.zoom.vdir', 'center');
    }
    grafica.Set('chart.title.xaxis', 'Lecturas');
//    grafica.Set('chart.labels', ['Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4', 'Nivel 5', 'Nivel 6']);
    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#2295d7', '#d76722', '#6b22d7']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);

    return grafica;
}


function obtenerGraficaNivelReporte(id){
    var grafica = new RGraph.Line(id, [window.reporte_nivel_agua]);
    var arreglo = crearArregloTooltipsTemp();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Nivel');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.key', ['Nivel agua']);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    grafica.Set('chart.tooltips', arreglo);
    grafica.Set('chart.tooltips.effect', 'contract');
    if (!RGraph.isIE8()){
        grafica.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
        grafica.Set('chart.zoom.delay', 10);
        grafica.Set('chart.zoom.frames', 25);
        grafica.Set('chart.zoom.vdir', 'center');
    }
    grafica.Set('chart.title.xaxis', 'Lecturas');
//    grafica.Set('chart.labels', ['Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4', 'Nivel 5', 'Nivel 6']);
    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#6b22d7']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);

    return grafica;
}

function obtenerGraficaHumedadReporte(id){
    var grafica = new RGraph.Line(id, [window.reporte_humedad_1, window.reporte_humedad_2]);
    var arreglo = crearArregloTooltipsTemp();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Humedad');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.key', ['Humedad 1', 'Humedad 2']);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    grafica.Set('chart.tooltips', arreglo);
    grafica.Set('chart.tooltips.effect', 'contract');
    if (!RGraph.isIE8()){
        grafica.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
        grafica.Set('chart.zoom.delay', 10);
        grafica.Set('chart.zoom.frames', 25);
        grafica.Set('chart.zoom.vdir', 'center');
    }
    grafica.Set('chart.title.xaxis', 'Lecturas');
//    grafica.Set('chart.labels', ['Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4', 'Nivel 5', 'Nivel 6']);
    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#2295d7', '#309f14']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);

    return grafica;
}
