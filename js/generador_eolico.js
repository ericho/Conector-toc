$(document).ready(function(){
	llenarPestanasDeck();
	window.reporte_temp_tub_fria = new Array();
	window.reporte_temp_tub_caliente = new Array();
	window.reporte_temp_sal_caliente = new Array();
	window.reporte_temp_tuberia = new Array();

	window.URLaJSON = "/js/json.php";
	setInterval("iniciar()", 10000);
	iniciar();
	
    });


function llenarPestanasDeck(){
    var html = "<div width='100%' height:'250'><div><div style='float:left'><canvas id='grafica_voltaje' width='180px' height='180px'></canvas><br/><center><h1>Voltaje</h1></center></div><div style='float:left'><canvas id='grafica_viento' width='180px' height='180px'></canvas><br/><center><h1>Viento</h1></center></div></div><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><div><div style='float:left'><canvas id='grafica_potencia' width='180px' height='180px'></canvas><br/><center><h1>Potencia</h1></center></div><div style='float:left'><canvas id='grafica_rpm' width='180px' height='180px'></canvas><br/><center><h1>RPM</h1></center></div></div></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="500" height="210" ></canvas><br/><canvas id="grafica_nivel_reporte" width="500" height="180"></canvas></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
}


function iniciar(){
    var url = window.URLaJSON + "?id=5";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}


function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_grafica_viento = "grafica_viento";
    var id_grafica_voltaje = "grafica_voltaje";
    var id_grafica_rpm = "grafica_rpm";
    var id_grafica_potencia = "grafica_potencia";


    // limpiando canvas
    RGraph.Clear(document.getElementById(id_grafica_viento));    
    RGraph.Clear(document.getElementById(id_grafica_voltaje));    
    RGraph.Clear(document.getElementById(id_grafica_rpm));    
    RGraph.Clear(document.getElementById(id_grafica_potencia));    


    // Obteniendo graficas 
    var grafica_viento = obtenerGraficaViento(id_grafica_viento, json.velocidad_viento);
    var grafica_voltaje = obtenerGraficaVoltaje(id_grafica_voltaje, json.voltaje);  
    var grafica_potencia = obtenerGraficaPotencia(id_grafica_potencia, json.potencia);   
    var grafica_rpm = obtenerGraficaRPM(id_grafica_rpm, json.rpm);

    
    // Dibujando graficas
    grafica_viento.Draw();
    grafica_voltaje.Draw();
    grafica_potencia.Draw();
    grafica_rpm.Draw();

}


function obtenerGraficaViento(id, viento){
    var grafica_presion = new RGraph.Gauge(id, 0, 255, parseFloat(viento));
    grafica_presion.Set('chart.scale.decimals', 0);
    grafica_presion.Set('chart.tickmarks.small', 50);
    grafica_presion.Set('chart.tickmarks.big',5);
    
    return grafica_presion;
}

function obtenerGraficaVoltaje(id, voltaje){
    var grafica_presion = new RGraph.Gauge(id, 0, 255, parseFloat(voltaje));
    //    grafica_presion.Set('chart.title', 'Voltaje');
    grafica_presion.Set('chart.title.size', 12);
    return grafica_presion;
}

function obtenerGraficaRPM(id, rpm){
    var grafica_presion = new RGraph.Gauge(id, 0, 2500, parseInt(rpm));
    //    grafica_presion.Set('chart.title', 'RPM');
    grafica_presion.Set('chart.title.size', 12);
    return grafica_presion;
}


function obtenerGraficaPotencia(id, potencia){
    var grafica_presion = new RGraph.Gauge(id, 0, 255, parseInt(potencia));
    //    grafica_presion.Set('chart.title', 'RPM');
    grafica_presion.Set('chart.title.size', 12);
    return grafica_presion;
}



