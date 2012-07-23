$(document).ready(function(){
	llenarPestanasDeck();
	window.reporte_temp_ambiente = new Array();
	window.reporte_temp_interior = new Array();
	window.reporte_temp_agua = new Array();
	window.reporte_humedad_1 = new Array();
	window.reporte_humedad_2 = new Array();
	window.reporte_ldr_estado = new Array();
	window.reporte_motor_estado = new Array();
	window.reporte_nivel_agua = new Array();

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
    var id_termo_ambiente = "termo_tub_fria";
    var id_termo_interior = "termo_tub_caliente";
    var id_termo_agua = "termo_sal_caliente";
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
    grafica.Set('chart.outofbounds', true);
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

unction obtenerGraficaNivel(id, json){
    
    var grafica_humedad = new RGraph.Bar(id, [json.flujo_agua]);
    grafica_humedad.Set('chart.labels', [json.fecha]);
    grafica_humedad.Set('chart.background.barcolor1', 'white');
    grafica_humedad.Set('chart.background.barcolor2', 'white');
    grafica_humedad.Set('chart.background.grid', true);
    grafica_humedad.Set('chart.ymax', 100);
    grafica.Set('chart.outofbounds', true);
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

function obtenerTablaRecientes(json){
    
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


}
