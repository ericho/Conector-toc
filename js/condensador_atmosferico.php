<?

// Condensador atmosferico

function condensador_atmosferico(){
  $consulta = "SELECT idcondensador_atmosferico,
                                                                fecha_hora,
                                                                temp_ambiente,
                                                                temp_interior,
                                                                temp_agua,
                                                                humedad_1,
                                                                humedad_2,
                                                                ldr_estado,
                                                                motor_estado,
                                                                nivel_agua
                                                                FROM condensador_atmosferico ORDER BY idcondensador_atmosferico DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_ambiente" => $fila[2],
		   "temp_interior" => $fila[3],
		   "temp_agua" => $fila[4],
		   "humedad_1" => $fila[5],
                   "humedad_2" => $fila[6],
		   "ldr_estado" => $fila[7],
		   "motor_estado" => $fila[8],
		   "flujo_agua" => $fila[9]
);

  echo json_encode($arreglo);
}

function condensador_atmosferico_diario($fecha, $act)
{
  if ($act==2)  
{
  $consulta = "SELECT idcondensador_atmosferico,
                                                                fecha_hora,
                                                                temp_ambiente,
                                                                temp_interior,
                                                                temp_agua,
                                                                humedad_1,
                                                                humedad_2,
                                                                ldr_estado,
                                                                motor_estado,
                                                                nivel_agua
                                                FROM condensador_atmosferico
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
  
  $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_ambiente" => $fila[2],
		   "temp_interior" => $fila[3],
		   "temp_agua" => $fila[4],
		   "humedad_1" => $fila[5],
                   "humedad_2" => $fila[6],
		   "ldr_estado" => $fila[7],
		   "motor_estado" => $fila[8],
		   "flujo_agua" => $fila[9]
);
  
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function condensador_atmosferico_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idcondensador_atmosferico,
                                                                fecha_hora,
                                                                temp_ambiente,
                                                                temp_interior,
                                                                temp_agua,
                                                                humedad_1,
                                                                humedad_2,
                                                                ldr_estado,
                                                                motor_estado,
                                                                nivel_agua
                                                FROM condensador_atmosferico
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {

      $arreglo_tmp = array("id" => $fila[0],
                           "fecha" => $fila[1],
                           "temp_ambiente" => $fila[2],
                           "temp_interior" => $fila[3],
                           "temp_agua" => $fila[4],
                           "humedad_1" => $fila[5],
                           "humedad_2" => $fila[6],
                           "ldr_estado" => $fila[7],
                           "motor_estado" => $fila[8],
                           "flujo_agua" => $fila[9]
                       );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

?>