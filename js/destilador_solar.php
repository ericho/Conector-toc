<?

// Destilador solar 

function destilador_solar(){
  $consulta = "SELECT iddestilador_solar,
                                                fecha_hora,
                                                temp_sol,
                                                temp_lente,
                                                temp_interna,
                                                nivel_contenedor
                                                FROM destilador_solar ORDER BY iddestilador_solar DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temperatura_sol" => $fila[2],
		   "temperatura_lente" => $fila[3],
		   "temperatura_interna" => $fila[4],
		   "nivel_contenedor" => $fila[5]
);

  echo json_encode($arreglo);
}

function destilador_solar_diario($fecha, $act)
{
  if ($act==2)  
{
  $consulta = "SELECT iddestilador_solar,
                                                fecha_hora,
                                                temp_sol,
                                                temp_lente,
                                                temp_interna,
                                                nivel_contenedor
                                                FROM destilador_solar
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temperatura_sol" => $fila[2],
		   "temperatura_lente" => $fila[3],
		   "temperatura_interna" => $fila[4],
		   "nivel_contenedor" => $fila[5]
                       );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function destilador_solar_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {
      $consulta = "SELECT iddestilador_solar,
                                                fecha_hora,
                                                temp_sol,
                                                temp_lente,
                                                temp_interna,
                                                nivel_contenedor
                                                FROM destilador_solar
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
  $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temperatura_sol" => $fila[2],
		   "temperatura_lente" => $fila[3],
		   "temperatura_interna" => $fila[4],
		   "nivel_contenedor" => $fila[5]
);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

?>