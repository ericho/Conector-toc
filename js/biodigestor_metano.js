
$(document).ready(function(){

	llenarPestanasDeck();
	window.datos = new Array();
	window.temp_reactor = new Array();
	window.nivel_reactor = new Array();
	window.nivel_deposito = new Array();
	window.reporte_temp_mezcla = new Array();
	window.reporte_temp_reactor = new Array();
	window.reporte_nivel_deposito = new Array();
	window.reporte_nivel_reactor = new Array();
	window.reporte_presion = new Array();
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



	$("#forma_configuracion").submit(function(){
		var motor1b = $("#motor1b").val();
		var motor1c = $("#motor1c").val();
		var mensaje = "Se ha enviado la configuracion : Motor 1B : " + motor1b + " Motor 1C : " + motor1c;
		$("#mensaje_configuracion").text(mensaje);
		return false;
        });

        $("#forma_eventos").submit(function(){
            var fecha = $("#fecha_evento").val();
            obtenerReporteEventos(fecha);
	});	

});


function llenarPestanasDeck(){
    var html = "<div width='100%' height:'250'><canvas id='termo_reactor' width='80px' height='250px' style='float:left'></canvas><canvas id='termo_mezcla' width='80' height='250' style='float:left'></canvas><canvas id='grafica_niveles' height='250' style='width:300px;float:left'></canvas></div><br/><div><div><canvas id='presion' width='200' height='200' style='float:left'></canvas></div><div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div></div>";

    var html_reporte  = '<div id="div_forma_reporte" style="float:left"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="650" height="250" ></canvas><br/><canvas id="grafica_nivel_reporte" width="650" height="250"></canvas><br /><canvas id="grafica_presion_reporte" width="650" height="250"></canvas></div>';

    var html_configuracion = '<form id="forma_configuracion"><label>Motor Agitador 1B : </label><input type="text" name="motor_1b" id="motor1b"><br/><label>Motor Agitador 1C : </label><input type="text" name="motor_1c" id="motor1c"><br/><button id="boton_config">Enviar configuraci&oacute;n</button></form><div id="mensaje_configuracion"></div>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Cargar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#configuracion").html(html_configuracion);
    $("#eventos").html(html_eventos);
}

function iniciar(){
    var url = window.URLaJSON + "?id=1";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}

function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_termo_mezcla = "termo_mezcla";
    var id_termo_reactor = "termo_reactor";
    var id_grafica_niveles = "grafica_niveles";
    var id_grafica_presion = "presion";
    var id_tabla_datos = "#tabla_datos_reciente";
    

    // Limpiando canvas
    RGraph.Clear(document.getElementById(id_termo_mezcla));
    RGraph.Clear(document.getElementById(id_termo_reactor));
    RGraph.Clear(document.getElementById(id_grafica_niveles));
    RGraph.Clear(document.getElementById(id_grafica_presion));

    var termo_mezcla = obtenerTermometroMezcla(id_termo_mezcla, json.temp_mezcla);
    var termo_reactor = obtenerTermometroReactor(id_termo_reactor, json.temp_reactor);
    var grafica_niveles = obtenerGraficaNiveles(id_grafica_niveles, json);
    var grafica_presion = obtenerGraficaPresion(id_grafica_presion, json.presion_gas)
    var tabla_datos_reciente = obtenerTablaRecientes(json);


    // Dibujando graficas
    termo_mezcla.Draw();
    termo_reactor.Draw();
    grafica_niveles.Draw();
    grafica_presion.Draw();
    $(id_tabla_datos).html(tabla_datos_reciente);

}

function obtenerTermometroMezcla(id, dato){
    var termo = new RGraph.Thermometer(id, 0,300, dato);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', 'Temperatura mezcla (°C)');
    return termo;
}

function obtenerTermometroReactor(id, dato){
    var termo = new RGraph.Thermometer(id, 0, 300, dato);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', 'Temperatura reactor (°C)');
    return termo;
}

function obtenerGraficaNiveles(id, json){
    
    var grafica_niveles = new RGraph.Bar(id, [[parseInt(json.nivel_reactor), parseInt(json.nivel_deposito)]]);
    grafica_niveles.Set('chart.labels', ['Reactor', 'Deposito']);
    grafica_niveles.Set('chart.background.barcolor1', 'white');
    grafica_niveles.Set('chart.background.barcolor2', 'white');
    grafica_niveles.Set('chart.background.grid', true);
    grafica_niveles.Set('chart.ymax', 170);
    grafica_niveles.Set('chart.tooltips', [json.nivel_reactor + " cm", json.nivel_deposito + " cm"]);
    grafica_niveles.Set('chart.title', 'Niveles');
    grafica_niveles.Set('chart.colors', ['#3366ff', '#0000cc']);
    grafica_niveles.Set('chart.fillstyle', ['rgba(33,66,ff,0.3)', 'rgba(0,0,cc,0.3)']);
//    grafica_niveles.Set('chart.key', ['Nivel Reactor', 'Nivel depósito de gas']);
    return grafica_niveles;
}

function obtenerGraficaPresion(id, presion){
    var grafica_presion = new RGraph.Gauge(id, 0, 1000, parseInt(presion));
    grafica_presion.Set('chart.title', 'Gas');
    grafica_presion.Set('chart.title.size', 14);
    grafica_presion.Set('chart.title.bottom', presion.toString());
    grafica_presion.Set('chart.title.bottom.size', 12);
    return grafica_presion;
}


function obtenerTablaRecientes(datos){
    var html = 'Ultima actividad = ' + datos.fecha + '<table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variable</b></td><td><b>Estado</b></td></tr></thead>';
    html += "<tr><td>Calentador Agua</td>";
    if (datos.calentador_agua == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Motor agitador A</td>";
    if (datos.motor_agitador_a == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Motor Agitador B tiempo</td><td>" + datos.motor_agitador_b_tiempo + "</td></tr>";
    html += "<tr><td>Motor Agitador C frecuencia</td><td>" + datos.motor_agitador_c_frec + " por d&iacute;a</td></tr>";
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
    var url = window.URLaJSON + "?id=1" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
            window.reporte_temp_mezcla = [];
            window.reporte_temp_reactor = [];
            window.reporte_nivel_deposito = [];
            window.reporte_nivel_reactor = [];
            window.reporte_presion = [];
            window.reporte_fechas = [];        
	    $.each(json, function(index, ejson){

		    window.reporte_temp_mezcla.push(parseFloat(ejson.temp_mezcla));
		    window.reporte_temp_reactor.push(parseFloat(ejson.temp_reactor));
		    window.reporte_nivel_deposito.push(parseInt(ejson.nivel_deposito));
		    window.reporte_nivel_reactor.push(parseInt(ejson.nivel_reactor));
		    window.reporte_presion.push(parseInt(ejson.presion_gas));
		    window.reporte_fechas.push(ejson.fecha);
		});
	    dibujarGraficasReporte();
	});
}


function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=1&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){
            window.reporte_temp_mezcla = [];
            window.reporte_temp_reactor = [];
            window.reporte_nivel_deposito = [];
            window.reporte_nivel_reactor = [];
            window.reporte_presion = [];
            window.reporte_fechas = [];        
	    $.each(json, function(index, ejson){

		    window.reporte_temp_mezcla.push(parseFloat(ejson.temp_mezcla));
		    window.reporte_temp_reactor.push(parseFloat(ejson.temp_reactor));
		    window.reporte_nivel_deposito.push(parseInt(ejson.nivel_deposito));
		    window.reporte_nivel_reactor.push(parseInt(ejson.nivel_reactor));
  		    window.reporte_presion.push(parseInt(ejson.presion_gas));
		    window.reporte_fechas.push(ejson.fecha);
		});
	    dibujarGraficasReporte();
	});
}


function dibujarGraficasReporte(){
    // ID de cada canvas
    var id_grafica_temp = "grafica_temp_reporte";
    var id_grafica_nivel = "grafica_nivel_reporte";
    var id_grafica_presion = "grafica_presion_reporte";
    // Limpiando canvas
    RGraph.Clear(document.getElementById(id_grafica_temp));
    RGraph.Clear(document.getElementById(id_grafica_nivel));
    RGraph.Clear(document.getElementById(id_grafica_presion));
    
    var reporte_temp = obtenerGraficaTemp(id_grafica_temp);
    var reporte_nivel = obtenerGraficaNivel(id_grafica_nivel);
    var reporte_presion = obtenerGraficaPresionReporte(id_grafica_presion);

    reporte_temp.Draw();
    reporte_nivel.Draw();
    reporte_presion.Draw();
}

function crearArregloTooltipsTemps(){
    var arreglo = new Array();
    for (var i=0; i<window.reporte_temp_mezcla.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_mezcla[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_temp_reactor.length; i++){
	   arreglo.push("<b>" + window.reporte_temp_reactor[i].toString() + "° C</b><br />" + window.reporte_fechas[i]);
	//arreglo.push(window.reporte_tuberia_2[i].toString());
    }
    return arreglo;
}


function crearArregloTooltipsNiveles(){
    var arreglo = new Array();
    for (var i=0; i<window.reporte_nivel_reactor.length; i++){
	   arreglo.push("<b>" + window.reporte_nivel_reactor[i].toString() + " cm</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_nivel_deposito.length; i++){
	   arreglo.push("<b>" + window.reporte_nivel_deposito[i].toString() + " cm</b><br />" + window.reporte_fechas[i]);
	//arreglo.push(window.reporte_tuberia_2[i].toString());
    }
    return arreglo;
}

function crearArregloTooltipsPresion(){
    var arreglo = new Array();
    for (var i=0; i<window.reporte_presion.length; i++){
	   arreglo.push("<b>" + window.reporte_presion[i].toString() + "</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}


function obtenerGraficaTemp(id){
    var grafica = new RGraph.Line(id, [window.reporte_temp_mezcla, window.reporte_temp_reactor]);
    var arreglo = crearArregloTooltipsTemps();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Temperaturas');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.key', ['Temperatura mezcla', 'Temperatura reactor']);
    grafica.Set('chart.key.position', ['gutter']);
    grafica.Set('chart.key.position.gutter.boxed', false);
    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.outofbounds', true);
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
    grafica.Set('chart.colors', ['red', 'blue']);
    grafica.Set('chart.gutter.bottom', 50);
    return grafica;
}

function obtenerGraficaNivel(id){
    var grafica = new RGraph.Line(id, [window.reporte_nivel_reactor, window.reporte_nivel_deposito]);
    var arreglo = crearArregloTooltipsNiveles();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Niveles');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key', ['Nivel reactor', 'Nivel deposito']);
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
    grafica.Set('chart.colors', ['#3366ff', '#0000cc']);
    grafica.Set('chart.gutter.bottom', 50);
    return grafica;
}

function obtenerGraficaPresionReporte(id){
    var grafica = new RGraph.Line(id, [window.reporte_presion]);
    var arreglo = crearArregloTooltipsPresion();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.title', 'Presion');
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.ymax', 400);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.key', ['Presion']);
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
    grafica.Set('chart.colors', ['#facc2e']);
    grafica.Set('chart.gutter.bottom', 50);
    return grafica;
}






