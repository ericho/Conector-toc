$(document).ready(function(){
	llenarPestanasDeck();
        // Arreglos para reportes
	window.reporte_temp_ambiente = new Array();
	window.reporte_temp_agua = new Array();
    window.reporte_ph = new Array();
    window.reporte_fechas = new Array();
    window.reporte_eventos = new Array();
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
            obtenerReporteEventos(fecha);
	});

        $("#reporte_rango").click(function(){
	    if($("#reporte_rango").is(":checked")){
		$("#fecha2_reporte").attr("disabled", false);
		$("#l_fecha").text("Fecha inicial : ");
	    }
	    else{
		$("#fecha2_reporte").attr("disabled", true);
	    };
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
    var html = "<div width='100%' height:'250'><canvas id='termo_ambiente' width='80px' height='250px' style='float:left'></canvas><canvas id='termo_agua' width='80px' height='250px' style='float:left'></canvas></div><div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="500" height="210" ></canvas><br/><canvas id="grafica_ph_reporte" width="500" height="180"></canvas></div>';

    var html_configuracion = '<form id="forma_configuracion"><label>Motor Agitador 1B : </label><input type="text" name="motor_1b" id="motor1b"><br/><label>Motor Agitador 1C : </label><input type="text" name="motor_1c" id="motor1c"><br/><button id="boton_config">Enviar configuraci&oacute;n</button></form><div id="mensaje_configuracion"></div>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Cargar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#configuracion").html(html_configuracion);
    $("#eventos").html(html_eventos);
}


function iniciar(){
    var url = window.URLaJSON + "?id=10";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}


function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_termo_ambiente = "termo_ambiente";
    var id_termo_agua = "termo_agua";
    var id_tabla_reciente = "#tabla_datos_reciente";

    // limpiando canvas
    RGraph.Clear(document.getElementById(id_termo_ambiente));    
    RGraph.Clear(document.getElementById(id_termo_agua));    


    // Obteniendo graficas 

    var termo_ambiente = obtenerTermoAmbiente(id_termo_ambiente, json.temp_amb);
    var termo_agua = obtenerTermoAgua(id_termo_agua, json.temp_agua);
    var tabla_reciente = obtenerTablaRecientes(json);
    
    // Dibujando graficas
    termo_ambiente.Draw();
    termo_agua.Draw();
    $(id_tabla_reciente).html(tabla_reciente);

}


function obtenerTermoAmbiente(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 50, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Temperatura ambiente");
    return termo;
}

function obtenerTermoAgua(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 50, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Temperatura agua");
    return termo;
}

function obtenerTablaRecientes(datos){
    var html = 'Ultima actividad registrada:' + datos.fecha + '<table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variables</b></td><td><b>Estado</b></td></tr></thead>';
    html += "<tr><td>PH </td><td>" + datos.ph + "</td></tr>";
    html += "<tr><td>Dispensador 1A</td>";
    if (datos.dispensador_1a == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Dispensador 1B</td><td>" + datos.dispensador_1b_frec + " Horas</td></tr>";
    html += "<tr><td>Dispensador 2A</td>";
    if (datos.dispensador_2a == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Dispensador 2B</td><td>" + datos.dispensador_2b_frec + " Horas</td></tr>";
    html += "<tr><td>Dispensador 3A</td>";
    if (datos.dispensador_3a == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Dispensador 3B</td><td>" + datos.dispensador_3b_frec + " Horas</td></tr>";
    html += "<tr><td>Bomba 1A</td>";
    if (datos.bomba_1a == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Bomba 1B</td><td>" + datos.bomba_1b + "</td></tr>";
    html += "<tr><td>Bomba 1C</td><td>" + datos.bomba_1c + "</td></tr>";
    html += "<tr><td>Bomba 2A</td>";
    if (datos.bomba_2a == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Bomba 2B</td><td>" + datos.bomba_2b + "</td></tr>";
    html += "<tr><td>Bomba 2C</td><td>" + datos.bomba_2c + "</td></tr>";
    html += "</table>";
    return html;
}


function obtenerReporteEventos(fecha){
   
   var url = window.URLaJSON + "?id=0" + String.fromCharCode(38) + "act=4" + String.fromCharCode(38) + "fecha=" + fecha;
   alert(url);
    $.getJSON(url, function(json){
	//window.reporte_eventos = [];
	var html = "<table><tr><td>Fecha</td><td>Evento</td></tr>";
       alert(json);
//       $.each(json, function(index, ejson){
//		html += '<tr><td>' + ejson.fecha + '</td><td>' + ejson.evento + '</td></tr>';
//	});
	html += "</table>";
        
	$("#tabla_eventos").html(html);
    });
}

function obtenerJSONReporte(fecha){
    var url = window.URLaJSON + "?id=10" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
            window.reporte_temp_ambiente = [];
            window.reporte_temp_agua = [];
            window.reporte_fechas = [];        
            window.reporte_ph = [];
	    $.each(json, function(index, ejson){
		    window.reporte_temp_ambiente.push(parseFloat(ejson.temp_amb));
		    window.reporte_temp_agua.push(parseFloat(ejson.temp_agua));
		    window.reporte_ph.push(parseFloat(ejson.ph));
		    window.reporte_fechas.push(ejson.fecha);
		});
	    dibujarGraficasReporte();
	});
}


function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=10&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){
            window.reporte_temp_ambiente = [];
            window.reporte_temp_agua = [];
            window.reporte_fechas = [];        
            window.reporte_ph = [];
	    $.each(json, function(index, ejson){
		    window.reporte_temp_ambiente.push(parseFloat(ejson.temp_amb));
		window.reporte_temp_agua.push(parseFloat(ejson.temp_agua));
                    window.reporte_ph.push(parseFloat(ejson.ph));
		    window.reporte_fechas.push(ejson.fecha);
		});

	    dibujarGraficasReporte();
	});
}

function dibujarGraficasReporte(){
    var id_grafica_temp = "grafica_temp_reporte";
    var id_grafica_ph = "grafica_ph_reporte";

    //Limpiando canvas 
    RGraph.Clear(document.getElementById(id_grafica_temp));
    RGraph.Clear(document.getElementById(id_grafica_ph));

    var reporte_temp = obtenerGraficaTemp(id_grafica_temp);
    var reporte_ph = obtenerGraficaPh(id_grafica_ph);

    reporte_temp.Draw();
    reporte_ph.Draw();
}

function crearArregloTooltipsTemp()
{
    var arreglo = new Array();
    for (var i=0; i<window.reporte_temp_ambiente.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_ambiente[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_temp_agua.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_agua[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}

function crearArregloTooltipsPh()
{
    var arreglo = new Array();
    for (var i=0; i<window.reporte_ph.length; i++){
	   arreglo.push("<b>" + window.reporte_ph[i].toString() + "</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}



function obtenerGraficaTemp(id){
    // Dibuja la grafica con las temperaturas
    var grafica = new RGraph.Line(id, [window.reporte_temp_ambiente, window.reporte_temp_agua]);
    var arreglo = crearArregloTooltipsTemp();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Temperaturas');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key', ['Temperatura ambiente', 'Temperatura agua']);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    //grafica.Set('chart.labels', window.reporte_fechas);
    grafica.Set('chart.tooltips', arreglo);
    grafica.Set('chart.tooltips.effect', 'contract');
    if (!RGraph.isIE8()){
	   grafica.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
	   grafica.Set('chart.zoom.delay', 10);
	   grafica.Set('chart.zoom.frames', 25);
	   grafica.Set('chart.zoom.vdir', 'center');
    }
    grafica.Set('chart.title.xaxis', 'Lecturas')
    grafica.Set('chart.text.angle', 45);
    //    grafica.Set('chart.title.xaxis', 'Tiempo');
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['red', 'blue']);
    grafica.Set('chart.gutter.bottom', 50);
    return grafica;
}

function obtenerGraficaPh(id){
    // Dibuja la grafica con las temperaturas
    var grafica = new RGraph.Line(id, [window.reporte_ph]);
    var arreglo = crearArregloTooltipsPh();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'PH');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.key', ['ph']);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    //grafica.Set('chart.labels', window.reporte_fechas);
    grafica.Set('chart.tooltips', arreglo);
    grafica.Set('chart.tooltips.effect', 'contract');
    if (!RGraph.isIE8()){
	   grafica.Set('chart.contextmenu', [['Zoom in', RGraph.Zoom], ['Cancel', function(){}]]);
	   grafica.Set('chart.zoom.delay', 10);
	   grafica.Set('chart.zoom.frames', 25);
	   grafica.Set('chart.zoom.vdir', 'center');
    }
    grafica.Set('chart.title.xaxis', 'Lecturas')
    grafica.Set('chart.text.angle', 45);
    //    grafica.Set('chart.title.xaxis', 'Tiempo');
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#8000FF']);
    grafica.Set('chart.gutter.bottom', 50);
    return grafica;
}


