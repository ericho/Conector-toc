$(document).ready(function(){
	llenarPestanasDeck();
	window.reporte_temp_sol = new Array();
	window.reporte_temp_lente = new Array();
	window.reporte_temp_interna = new Array();
	window.reporte_nivel = new Array();
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
    var html = "<div width='100%' height:'250'><canvas id='termo_sol' width='80px' height='250px' style='float:left'></canvas><canvas id='termo_lente' width='80' height='250' style='float:left'></canvas><canvas id='termo_interna' width='80' height='250' style='float:left'></canvas><canvas id='grafica_nivel' width='200' height='200' style='float:left'></canvas></div><div id='ultima_actividad'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button><button id="boton_descargar">Descargar datos</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_temps_reporte" width="500" height="210" ></canvas><br/><canvas id="grafica_nivel_reporte" width="500" height="180"></canvas></div>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Mostrar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#eventos").html(html_eventos);
}


function iniciar(){
    var url = window.URLaJSON + "?id=11";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}

function descargarDatosReporte(fecha){
    var url = window.URLaJSON + "?id=11" + String.fromCharCode(38) + "act=5"  + String.fromCharCode(38) + "fecha=" + fecha;
    window.location.href = url;
}

function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_termo_sol = "termo_sol";
    var id_termo_lente = "termo_lente";
    var id_termo_interna = "termo_interna";
    var id_grafica_nivel = "grafica_nivel";
    var id_ultima_actividad = "#ultima_actividad";

    // limpiando canvas
    RGraph.Clear(document.getElementById(id_termo_sol));    
    RGraph.Clear(document.getElementById(id_termo_lente));
    RGraph.Clear(document.getElementById(id_termo_interna));
    RGraph.Clear(document.getElementById(id_grafica_nivel));

    // Obteniendo graficas 

    var termo_sol = obtenerTermoSol(id_termo_sol, json.temperatura_sol);
    var termo_lente = obtenerTermoLente(id_termo_lente, json.temperatura_lente);
    var termo_interna = obtenerTermoInterna(id_termo_interna, json.temperatura_interna);
    var grafica_nivel = obtenerGraficaNivelActual(id_grafica_nivel, json);

    html = "Ultima Actividad : " + json.fecha;
    // Dibujando graficas
    termo_sol.Draw();
    termo_lente.Draw();
    termo_interna.Draw();
    grafica_nivel.Draw();
    $(id_ultima_actividad).html(html);
}

function obtenerTermoSol(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 80, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Temperatura Sol");
    return termo;
}

function obtenerTermoLente(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 500, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Temperatura Lente");
    return termo;
}

function obtenerTermoInterna(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 80, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Temperatura Interna");
    return termo;
}

function obtenerGraficaNivelActual(id, json){
    
    var grafica_niveles = new RGraph.Bar(id, [parseInt(json.nivel_contenedor)]);
    grafica_niveles.Set('chart.labels', [json.fecha]);
    grafica_niveles.Set('chart.background.barcolor1', 'white');
    grafica_niveles.Set('chart.background.barcolor2', 'white');
    grafica_niveles.Set('chart.background.grid', true);
    grafica_niveles.Set('chart.ymax', 100);
    grafica.Set('chart.outofbounds', true);
    grafica_niveles.Set('chart.tooltips', [json.nivel_contenedor + ""]);
    grafica_niveles.Set('chart.tooltips.effect', 'contract');
    //grafica_niveles.Set('chart.title', 'Nivel contenedor');
    //grafica_niveles.Set('chart.title.vpos', 0.65);
    //grafica_niveles.Set('chart.title.hpos', 0.1);
    grafica_niveles.Set('chart.colors', ['#3366ff']);
    grafica_niveles.Set('chart.fillstyle', ['rgba(33,66,ff,0.3)']);
    grafica_niveles.Set('chart.key', ['Nivel Contenedor']);
    grafica_niveles.Set('chart.key.position', ['gutter']);
    grafica_niveles.Set('chart.key.position.gutter.boxed', false);
    if (!RGraph.isIE8()){
	   grafica_niveles.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
	   grafica_niveles.Set('chart.zoom.delay', 10);
	   grafica_niveles.Set('chart.zoom.frames', 25);
	   grafica_niveles.Set('chart.zoom.vdir', 'center');
    }
    return grafica_niveles;
}

function obtenerReporteEventos(fecha){
   
   var url = window.URLaJSON + "?id=11" + String.fromCharCode(38) + "act=4" + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
	var html = "<table><tr><td>Fecha</td><td>Evento</td></tr>";
       
	$.each(json, function(index, ejson){
		html += '<tr><td>' + ejson.fecha + '</td><td>' + ejson.evento + '</td></tr>';
	});
	html += "</table>";
        
	$("#tabla_eventos").html(html);
    });
}

function obtenerJSONReporte(fecha){
    var url = window.URLaJSON + "?id=11" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){

	window.reporte_temp_sol = [];
	window.reporte_temp_lente = [];
	window.reporte_temp_interna = [];
	window.reporte_nivel = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){

	    window.reporte_temp_sol.push(parseFloat(ejson.temperatura_sol));
	    window.reporte_temp_lente.push(parseFloat(ejson.temperatura_lente));
	    window.reporte_temp_interna.push(parseFloat(ejson.temperatura_interna));
	    window.reporte_nivel.push(parseInt(ejson.nivel_contenedor));
	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}

function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=11&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){

	window.reporte_temp_sol = [];
	window.reporte_temp_lente = [];
	window.reporte_temp_interna = [];
	window.reporte_nivel = [];
	window.reporte_fechas = [];

	$.each(json, function(index, ejson){
	    window.reporte_temp_sol.push(parseFloat(ejson.temperatura_sol));
	    window.reporte_temp_lente.push(parseFloat(ejson.temperatura_lente));
	    window.reporte_temp_interna.push(parseFloat(ejson.temperatura_interna));
	    window.reporte_nivel.push(parseInt(ejson.nivel_contenedor));


	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}

function dibujarGraficasReporte(){
    var id_grafica_temps = "grafica_temps_reporte";
    var id_grafica_niveles = "grafica_nivel_reporte";
    
    // Limpiando Canvas 
    RGraph.Clear(document.getElementById(id_grafica_temps));
    RGraph.Clear(document.getElementById(id_grafica_niveles));

    var reporte_temp = obtenerGraficaTemp(id_grafica_temps);
    var reporte_nivel = obtenerGraficaNivel(id_grafica_niveles);

    reporte_temp.Draw();
    reporte_nivel.Draw();
}

function crearArregloTooltipsTemp()
{
    var arreglo = new Array();
    for (var i=0; i<window.reporte_temp_sol.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_sol[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_temp_lente.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_lente[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
	//arreglo.push(window.reporte_tuberia_2[i].toString());
    }
    for (var i=0; i<window.reporte_temp_interna.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_interna[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}

function crearArregloTooltipsNivel()
{
    var arreglo = new Array();
    for (var i=0; i<window.reporte_nivel.length; i++){
	   arreglo.push("<b>" + window.reporte_nivel[i].toString() + "</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}

function obtenerGraficaTemp(id){
    var grafica = new RGraph.Line(id, [window.reporte_temp_sol, window.reporte_temp_lente, window.reporte_temp_interna]);
    var arreglo = crearArregloTooltipsTemp();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Temperaturas');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.key', ['Sol', 'Lente', 'Interna']);
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
    grafica.Set('chart.colors', ['#2295d7', '#d76722', '#6b22d7', '#309f14']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);

    return grafica;
}


function obtenerGraficaNivel(id){
    var grafica = new RGraph.Line(id, [window.reporte_nivel]);
    var arreglo = crearArregloTooltipsNivel();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Nivel');
    grafica.Set('chart.title', 'Temperaturas');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.key', ['Contenedor']);
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
    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#2295d7']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);

    return grafica;
}
