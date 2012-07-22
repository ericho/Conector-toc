<?

// Lombricomposta

function lombricompostario(){
  $consulta = "SELECT idlombricompostario, 
                                                        fecha_hora, 
                                                        motor_estado,
                                                        motor_frecuencia,
                                                        humedad,
                                                        temperatura
                                                        FROM lombricompostario ORDER BY idlombricompostario DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "motor_estado" => $fila[2],
		   "motor_frecuencia" => $fila[3],
		   "humedad" => $fila[4],
		   "temperatura" => $fila[5]
		   );

  echo json_encode($arreglo);

}

function lombricompostario_diario($fecha, $act)
{
  if ($act==2)  
{

  $consulta = "SELECT idlombricompostario, 
                                                        fecha_hora, 
                                                        motor_estado,
                                                        motor_frecuencia,
                                                        humedad,
                                                        temperatura
                                                        FROM lombricompostario
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "motor_estado" => $fila[2],
		   "motor_frecuencia" => $fila[3],
		   "humedad" => $fila[4],
		   "temperatura" => $fila[5]
		   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function lombricompostario_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

  $consulta = "SELECT idlombricompostario, 
                                                        fecha_hora, 
                                                        motor_estado,
                                                        motor_frecuencia,
                                                        humedad,
                                                        temperatura
                                                        FROM lombricompostario
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "motor_estado" => $fila[2],
		   "motor_frecuencia" => $fila[3],
		   "humedad" => $fila[4],
		   "temperatura" => $fila[5]
		   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

?>