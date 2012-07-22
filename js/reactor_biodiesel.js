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
    var html = "<div width='100%' height:'250'><canvas id='termo_reactor' width='80px' height='250px' style='float:left'></canvas></div><div id='tabla_datos_reciente' style='float:left; width:auto; padding-left:10px;'></div>";

    var html_reporte  = '<div id="div_forma_reporte"><form id="forma_reporte"><legend>Tipo de reporte :</legend><input type="radio" name="tipo_reporte" id="reporte_diario" checked="checked"> Diario<input type="radio" name="tipo_reporte" id="reporte_rango"> Rango de fechas<br><label id="l_fecha">Seleccionar fecha : </label><input type="text" name="fecha" id="fecha_reporte"><br/><label>Fecha final : </label><input type="text" name="fecha2" id="fecha2_reporte" disabled="disabled"><br/><button id="boton_reporte">Generar reporte</button></form></div><div id="id_exportar"></div><div id="canvas_reporte"><canvas id="grafica_temp_reporte" width="500" height="210" ></canvas><br/><canvas id="grafica_nivel_reporte" width="500" height="180"></canvas></div>';

    $("#condiciones_actuales").html(html);
    $("#reportes").html(html_reporte);
}


function iniciar(){
    var url = window.URLaJSON + "?id=3";
    $.getJSON(url, function(json){
	    dibujarGraficasRecientes(json);
    });
}


function dibujarGraficasRecientes(json){
    // ID de cada canvas
    var id_termo_reactor = "termo_reactor";
    var id_tabla_reciente = "#tabla_datos_reciente";

    // limpiando canvas
    RGraph.Clear(document.getElementById(id_termo_reactor));    

    // Obteniendo graficas 

    var termo_reactor = obtenerTermoReactor(id_termo_reactor, json.temp_reactor);
    var tabla_reciente = obtenerTablaRecientes(json);
    
    // Dibujando graficas
    termo_reactor.Draw();
    $(id_tabla_reciente).html(tabla_reciente);

}


function obtenerTermoReactor(id, temp){
    var termo = new RGraph.Thermometer(id, 0, 255, temp);
    termo.Set('chart.colors', ['red']);
    termo.Set('chart.title.side', "Temperatura Reactor");
    return termo;
}

function obtenerTablaRecientes(datos){
    var html = '<table class="tablavariables_1" id="t_reciente"><thead><tr><td><b>Otras Variables</b></td><td><b>Estado</b></td></tr></thead>';
    html += "<tr><td>Bomba 1</td>";
    if (datos.bomba_1 == "1"){
	html += "<td id='activo' style='color: green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Bomba 2</td>";
    if (datos.bomba_2 == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Agitador 1A</td>";
    if (datos.agitador_1a_estado == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }

    html += "<tr><td>Agitador 1B </td><td>" + datos.agitador_2b_tiempo_enc + " Minutos</td></tr>";
    html += "<tr><td>Agitador 2A</td>";
    if (datos.agitador_2a_estado == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Agitador 2B </td><td>" + datos.agitador_2b_tiempo_enc + " Horas</td></tr>";
    html += "<tr><td>Agitador 2C </td><td>" + datos.agitador_2c_tiempo_enc + " Minutos</td></tr>";
    html += "<tr><td>Resistencia calentador</td>";
    if (datos.res_calentador_estado == "1"){
	html += "<td id='Activo' style='color:green'>Activo</td></tr>";
    }
    else{
	html += "<td id='inactivo' style='color:red'>Inactivo</td></tr>";
    }
    html += "<tr><td>Resistencia calentador tiempo</td><td>" + datos.res_calentador_tiempo + " Horas</td></tr>";
    html += "</table>";
    return html;
}
