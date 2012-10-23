$(document).ready(function(){
    llenarPestanasDeck();
    window.reporte_presion = new Array();   
    window.reporte_presion_domo = new Array();
    window.reporte_presion_tuberia = new Array();
    window.reporte_temp_agua_fria = new Array();
    window.reporte_temp_agua_caliente = new Array();
    window.reporte_temp_salida_caliente = new Array();
    window.reporte_temp_tuberia = new Array();
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
    var html = "<div width='100%' height:'250'><canvas id='termo_agua_fria' width='80' height='250' style='float:left'></canvas><canvas id='termo_agua_caliente' width='80' height='250' style='float:left'></canvas><canvas id='termo_sal_caliente' width='80' height='250' style='float:left'></canvas><canvas id='termo_tuberia' width='80' height='250' style='float:left'></canvas><br /><br /><br /><br /><br /><br /><br /><br /><br /><canvas id='presion_1' width='200px' height='200px' style='float:left'></canvas><canvas id='presion_domo' width='200px' height='200px' style='float:left'></canvas><canvas id='presion_tuberia' width='200px' height='200px' style='float:left'></canvas></div><div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button><button id="boton_descargar">Descargar datos</button></form></div><div id="id_exportar"></div><center><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="650" height="250" ></canvas><br/><canvas id="grafica_presion_reporte" width="500" height="180"></canvas></div></center>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Mostrar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#eventos").html(html_eventos);
}


function iniciar(){
    var url = window.URLaJSON + "?id=15";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}
    
function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_presion_1 = "presion_1";
    var id_presion_domo = "presion_domo";
    var id_presion_tuberia = "presion_tuberia";
    var id_termo_agua_fria = "termo_agua_fria";
    var id_termo_agua_caliente = "termo_agua_caliente";
    var id_termo_sal_caliente = "termo_sal_caliente";
    var id_termo_tuberia = "termo_tuberia";
    var id_tabla_reciente = "#tabla_datos_reciente";
    

    // limpiando canvas
    RGraph.Clear(document.getElementById(id_presion_1));
    RGraph.Clear(document.getElementById(id_presion_domo));
    RGraph.Clear(document.getElementById(id_presion_tuberia));        
    RGraph.Clear(document.getElementById(id_termo_agua_fria));    
    RGraph.Clear(document.getElementById(id_termo_agua_caliente));
    RGraph.Clear(document.getElementById(id_termo_sal_caliente));
    RGraph.Clear(document.getElementById(id_termo_tuberia));

    // Obteniendo graficas 

    var presion_1 = obtenerPresion1(id_presion_1, json.presion);
    var presion_domo = obtenerPresionDomo(id_presion_domo, json.presion_domo);
    var presion_tuberia = obtenerPresionTuberia(id_presion_tuberia, json.presion_tuberia);
    var termo_tub_fria = obtenerTermoAguaFria(id_termo_agua_fria, json.temp_agua_fria);
    var termo_tub_caliente = obtenerTermoAguaCaliente(id_termo_agua_caliente, json.temp_agua_caliente);
    var termo_tub_salida = obtenerTermoTubSalida(id_termo_sal_caliente, json.temp_salida_caliente);
    var termo_tuberia = obtenerTermoTuberia(id_termo_tuberia, json.temp_tuberia);
//    var tabla_reciente = obtenerTablaRecientes(json);

    var html = "Ultima actividad : " + json.fecha_hora;

    // Dibujando graficas
    presion_1.Draw();
    presion_domo.Draw();
    presion_tuberia.Draw();
    termo_tub_fria.Draw();
    termo_tub_caliente.Draw();
    termo_tub_salida.Draw();
    termo_tuberia.Draw();
    $(id_tabla_reciente).html(html);

}

function obtenerPresion1(id, presion)
{
    var grafica_presion = new RGraph.Gauge(id, 0, 1000, parseInt(presion));
    grafica_presion.Set('chart.title', 'Presion');
    grafica_presion.Set('chart.title.size', 14);
    grafica_presion.Set('chart.title.bottom', presion.toString());
    grafica_presion.Set('chart.title.bottom.size', 12);
    return grafica_presion;
}

function obtenerPresionDomo(id, presion)
{
    var grafica_presion = new RGraph.Gauge(id, 0, 1000, parseInt(presion));
    grafica_presion.Set('chart.title', 'Presion domo');
    grafica_presion.Set('chart.title.size', 14);
    grafica_presion.Set('chart.title.bottom', presion.toString());
    grafica_presion.Set('chart.title.bottom.size', 12);
    return grafica_presion;
}

function obtenerPresionTuberia(id, presion)
{
    var grafica_presion = new RGraph.Gauge(id, 0, 1000, parseInt(presion));
    grafica_presion.Set('chart.title', 'Presion tuberia');
    grafica_presion.Set('chart.title.size', 14);
    grafica_presion.Set('chart.title.bottom', presion.toString());
    grafica_presion.Set('chart.title.bottom.size', 12);
    return grafica_presion;
}


function obtenerTermoAguaFria(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Agua fria");
    return termo;
}

function obtenerTermoAguaCaliente(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Agua caliente");
    return termo;
}

function obtenerTermoTubSalida(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Salida tuberia");
    return termo;
}

function obtenerTermoTuberia(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 100, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Tuberia");
    return termo;
}


function obtenerReporteEventos(fecha){
   
   var url = window.URLaJSON + "?id=15" + String.fromCharCode(38) + "act=4" + String.fromCharCode(38) + "fecha=" + fecha;
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
    var url = window.URLaJSON + "?id=15" + String.fromCharCode(38) + "act=5"  + String.fromCharCode(38) + "fecha=" + fecha;
    window.location.href = url;
}

function obtenerJSONReporte(fecha){
    var url = window.URLaJSON + "?id=15" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
        window.reporte_presion = [];
        window.reporte_presion_domo = [];
        window.reporte_presion_tuberia = [];
    	window.reporte_temp_agua_fria = [];
	    window.reporte_temp_agua_caliente = [];
	    window.reporte_temp_salida_caliente = [];
        window.reporte_temp_tuberia = [];
        window.reporte_fechas = [];
        $.each(json, function(index, ejson){
            window.reporte_presion.push(ejson.presion);
            window.reporte_presion_domo.push(ejson.presion_domo);
            window.reporte_presion_tuberia.push(ejson.presion_tuberia);
	        window.reporte_temp_agua_fria.push(ejson.temp_agua_fria);
	        window.reporte_temp_agua_caliente.push(ejson.temp_agua_caliente);
	        window.reporte_temp_salida_caliente.push(ejson.temp_salida_caliente);
	        window.reporte_temp_tuberia.push(ejson.temp_tuberia);
            window.reporte_fechas.push(ejson.fecha_hora)
	    });
	    dibujarGraficasReporte();
    });
}

function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=15&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){
        window.reporte_presion = [];
        window.reporte_presion_domo = [];
        window.reporte_presion_tuberia = [];
    	window.reporte_temp_agua_fria = [];
	    window.reporte_temp_agua_caliente = [];
	    window.reporte_temp_salida_caliente = [];
        window.reporte_temp_tuberia = [];
        window.reporte_fechas = [];
        $.each(json, function(index, ejson){
            window.reporte_presion.push(ejson.presion);
            window.reporte_presion_domo.push(ejson.presion_domo);
            window.reporte_presion_tuberia.push(ejson.presion_tuberia);
	        window.reporte_temp_agua_fria.push(ejson.temp_agua_fria);
	        window.reporte_temp_agua_caliente.push(ejson.temp_agua_caliente);
	        window.reporte_temp_salida_caliente.push(ejson.temp_salida_caliente);
	        window.reporte_temp_tuberia.push(ejson.temp_tuberia);
            window.reporte_fechas.push(ejson.fecha_hora);  
	    });
	    dibujarGraficasReporte();
    });
}

function dibujarGraficasReporte(){
    var id_grafica_temps = "grafica_temp_reporte";
    var id_grafica_presion = 'grafica_presion_reporte';
 
   
    // Limpiando Canvas 
    RGraph.Clear(document.getElementById(id_grafica_temps));
    RGraph.Clear(document.getElementById(id_grafica_presion));

    var reporte_temp = obtenerGraficaTemps(id_grafica_temps);
    var reporte_presion = obtenerGraficaPresionReporte(id_grafica_presion);

    reporte_temp.Draw();
    reporte_presion.Draw();
}

function crearArregloTooltips(){
    var arreglo = new Array();
   
    for (var i=0; i<window.reporte_temp_agua_fria.length; i++){
	arreglo.push("<b>" + window.reporte_temp_agua_fria[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_temp_agua_caliente.length; i++){
	arreglo.push("<b>" + window.reporte_temp_agua_caliente[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_temp_salida_caliente.length; i++){
	arreglo.push("<b>" + window.reporte_temp_salida_caliente[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_temp_tuberia.length; i++){
	arreglo.push("<b>" + window.reporte_temp_tuberia[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}

function crearArregloTooltipsPresion(){
    var arreglo = new Array();
    for (var i=0; i<window.reporte_presion.length; i++){
	    arreglo.push("<b>" + window.reporte_presion[i].toString() + "</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_presion_domo.length; i++){
	    arreglo.push("<b>" + window.reporte_presion_domo[i].toString() + "</b><br />" + window.reporte_fechas[i]);
	//arreglo.push(window.reporte_tuberia_2[i].toString());
    }
    for (var i=0; i<window.reporte_presion_tuberia.length; i++){
	    arreglo.push("<b>" + window.reporte_presion_tuberia[i].toString() + "</b><br />" + window.reporte_fechas[i]);
    }
}

function obtenerGraficaTemps(id){
    var grafica = new RGraph.Line(id, [window.reporte_temp_agua_fria, window.reporte_temp_agua_caliente, window.reporte_temp_salida_caliente, window.reporte_temp_tuberia]);
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
    grafica.Set('chart.key', ['Agua fria', 'Agua caliente', 'Salida Caliente', 'Tuberia']);
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




function obtenerGraficaPresionReporte(id){
    var grafica = new RGraph.Line(id, [window.reporte_presion, window.reporte_presion_domo, window.reporte_presion_tuberia]);
    var arreglo = crearArregloTooltipsPresion();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Presion');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.ymax', 400);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key', ['Presion', 'Presion domo', 'Presion tuberia']);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.tooltips', arreglo);
    grafica.Set('chart.tooltips.effect', 'contract');
    if (!RGraph.isIE8()){
	   grafica.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
	   grafica.Set('chart.zoom.delay', 10);
	   grafica.Set('chart.zoom.frames', 25);
	   grafica.Set('chart.zoom.vdir', 'center');
    }
    grafica.Set('chart.title.xaxis', 'Lecturas')
    //    grafica.Set('chart.title.xaxis', 'Tiempo');
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#3366ff', '#0000cc', '#facc2e']);
    grafica.Set('chart.gutter.bottom', 50);
    return grafica;
}
