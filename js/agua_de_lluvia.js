$(document).ready(function(){
    llenarPestanasDeck();

    // Arreglos para los reportes

    window.reporte_nivel_1 = new Array();
    window.reporte_nivel_2 = new Array();
    window.reporte_nivel_3 = new Array();
    window.reporte_nivel_4 = new Array();
    window.reporte_nivel_5 = new Array();
    window.reporte_nivel_6 = new Array();
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
    var html = "<div width='100%' height:'250'><canvas id='niveles' width='480px' height='250px' style='float:left'></canvas></div><div id='tabla_bombas' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button><button id="boton_descargar">Descargar datos</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_nivel_reporte" width="650" height="210" ></canvas><br/></div>';

    var html_eventos = '<div id="div_forma_eventos"><form id="forma_eventos"><legend>Seleccionar fecha :<input type="text" name="fecha" id="fecha_evento"> <button id="boton_evento">Mostrar eventos</button></form></div><div id="tabla_eventos"></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
    $("#eventos").html(html_eventos);
}


function iniciar(){
    var url = window.URLaJSON + "?id=13";
//    alert(url);
    $.getJSON(url, function(json){
	
	    dibujarGraficasRecientes(json);
    });
}

function descargarDatosReporte(fecha){
    var url = window.URLaJSON + "?id=13" + String.fromCharCode(38) + "act=5"  + String.fromCharCode(38) + "fecha=" + fecha;
    window.location.href = url;
}

function dibujarGraficasRecientes(json){
    // ID de cada canvas 
    var id_niveles = "niveles";
    var id_tabla_bombas = "#tabla_bombas";

    // limpiando canvas 
    RGraph.Clear(document.getElementById(id_niveles));
//    RGraph.Clear(document.getElementById(id_tabla_bombas));

    // Obteniendo graficas 

    var grafica_niveles = obtenerGraficaNiveles(id_niveles, json);
    var tabla_bombas = obtenerTablaRecientes(json);

    
    //Dibujando graficas

    grafica_niveles.Draw();
    $(id_tabla_bombas).html(tabla_bombas);
    
}

function obtenerGraficaNiveles(id_niveles, json){
    var grafica = new RGraph.Bar(id_niveles, [[parseInt(json.nivel_1), parseInt(json.nivel_2), parseInt(json.nivel_3), parseInt(json.nivel_4), parseInt(json.nivel_5), parseInt(json.nivel_6)]]);
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    grafica.Set('chart.labels', ['Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4', 'Nivel 5', 'Nivel 6']);
    grafica.Set('chart.background.grid', true);
    grafica.Set('chart.ymax', 100);
    grafica.Set('chart.tooltips', [json.nivel_1 + ' %', json.nivel_2 + ' %', json.nivel_3 + ' %', json.nivel_4 + ' %', json.nivel_5 + ' %', json.nivel_6 + ' %']);
    grafica.Set('chart.title', 'Niveles');
    grafica.Set('chart.colors', ['#2295d7', '#d76722', '#6b22d7', '#309f14', '#d53a26', '#263cd5']);
//    grafica.Set('chart.key', ['Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4', 'Nivel 5', 'Nivel 6']);
    return grafica;
}

function obtenerTablaRecientes(json){
    var html = 'Ultima actividad :' + json.fecha + '<table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variables</b></td><td><b>Estado</b></td></tr></thead>';
    html += "<tr><td>Bomba 1</td>";
    if (json.bomba_1 == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Bomba 2</td>";
    if (json.bomba_2 == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "</table>";
    return html;
}

function obtenerJSONReporte(fecha){
    var url = window.URLaJSON + "?id=13" + String.fromCharCode(38) + "act=2"  + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
	window.reporte_nivel_1 = [];
	window.reporte_nivel_2 = [];
	window.reporte_nivel_3 = [];
	window.reporte_nivel_4 = [];
	window.reporte_nivel_5 = [];
	window.reporte_nivel_6 = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){
	    window.reporte_nivel_1.push(parseInt(ejson.nivel_1));
	    window.reporte_nivel_2.push(parseInt(ejson.nivel_2));
	    window.reporte_nivel_3.push(parseInt(ejson.nivel_3));
	    window.reporte_nivel_4.push(parseInt(ejson.nivel_4));
	    window.reporte_nivel_5.push(parseInt(ejson.nivel_5));
	    window.reporte_nivel_6.push(parseInt(ejson.nivel_6));
	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}

function obtenerReporteRango(fecha1, fecha2){
    var url = window.URLaJSON + "?id=13&act=3&fecha=" + fecha1 + "&fecha2=" + fecha2;
    $.getJSON(url, function(json){
	window.reporte_nivel_1 = [];
	window.reporte_nivel_2 = [];
	window.reporte_nivel_3 = [];
	window.reporte_nivel_4 = [];
	window.reporte_nivel_5 = [];
	window.reporte_nivel_6 = [];
	window.reporte_fechas = [];
	$.each(json, function(index, ejson){
	    window.reporte_nivel_1.push(parseInt(ejson.nivel_1));
	    window.reporte_nivel_2.push(parseInt(ejson.nivel_2));
	    window.reporte_nivel_3.push(parseInt(ejson.nivel_3));
	    window.reporte_nivel_4.push(parseInt(ejson.nivel_4));
	    window.reporte_nivel_5.push(parseInt(ejson.nivel_5));
	    window.reporte_nivel_6.push(parseInt(ejson.nivel_6));
	    window.reporte_fechas.push(ejson.fecha);
	});
	dibujarGraficasReporte();
    });
}

function dibujarGraficasReporte(){
    var id_grafica_niveles = "grafica_nivel_reporte";
    
    // Limpiando Canvas 
    RGraph.Clear(document.getElementById(id_grafica_niveles));

    var reporte_nivel = obtenerGraficaNivel(id_grafica_niveles);

    reporte_nivel.Draw();
}

function crearTooltipsNiveles(){
    var arreglo = new Array();
    for (var i=0; i<window.reporte_nivel_1.length; i++){
	arreglo.push("<b>" + window.reporte_nivel_1[i].toString() + " %</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_nivel_2.length; i++){
	arreglo.push("<b>" + window.reporte_nivel_2[i].toString() + " %</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_nivel_3.length; i++){
	arreglo.push("<b>" + window.reporte_nivel_3[i].toString() + " %</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_nivel_4.length; i++){
	arreglo.push("<b>" + window.reporte_nivel_4[i].toString() + " %</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_nivel_5.length; i++){
	arreglo.push("<b>" + window.reporte_nivel_5[i].toString() + " %</b><br />" + window.reporte_fechas[i]);
    }
    for (var i=0; i<window.reporte_nivel_6.length; i++){
	arreglo.push("<b>" + window.reporte_nivel_6[i].toString() + " %</b><br />" + window.reporte_fechas[i]);
    }
    return arreglo;
}

function obtenerReporteEventos(fecha){
   
   var url = window.URLaJSON + "?id=13" + String.fromCharCode(38) + "act=4" + String.fromCharCode(38) + "fecha=" + fecha;
    $.getJSON(url, function(json){
	var html = "<table><tr><td>Fecha</td><td>Evento</td></tr>";
       
	$.each(json, function(index, ejson){
		html += '<tr><td>' + ejson.fecha + '</td><td>' + ejson.evento + '</td></tr>';
	});
	html += "</table>";
        
	$("#tabla_eventos").html(html);
    });
}

function obtenerGraficaNivel(id){
    var grafica = new RGraph.Line(id, [window.reporte_nivel_1, window.reporte_nivel_2, window.reporte_nivel_3, window.reporte_nivel_4, window.reporte_nivel_5, window.reporte_nivel_6]);
    var arreglo = crearTooltipsNiveles();
    grafica.Set('chart.background.barcolor1', 'white');
    grafica.Set('chart.background.barcolor2', 'white');
    //grafica.Set('chart.title', 'Niveles');
    grafica.Set('chart.outofbounds', true);
    grafica.Set('chart.title.vpos', 0.65);
    grafica.Set('chart.title.hpos', 0.1);
    grafica.Set('chart.tickmarks', 'circle');
    grafica.Set('chart.key', ['Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4', 'Nivel 5', 'Nivel 6']);
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
    grafica.Set('chart.title.xaxis', 'Lecturas')

    grafica.Set('chart.text.angle', 45);
    grafica.Set('chart.filled', false);
    grafica.Set('chart.colors', ['#2295d7', '#d76722', '#6b22d7', '#309f14', '#d53a26', '#263cd5']);
    grafica.Set('chart.title.xaxis.pos', 0.5);
    grafica.Set('chart.gutter.bottom', 50);

    return grafica;
}
