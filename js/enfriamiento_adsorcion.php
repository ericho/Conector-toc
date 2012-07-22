<?

// Enfriamiento por adsorcion

function enfriamiento_adsorcion(){
  $consulta = "SELECT idenfriamiento_adsorcion,
                                                                fecha_hora,
                                                                presion,
                                                                presion_domo,
                                                                presion_tuberia,
                                                                temp_agua_fria,
                                                                temp_agua_caliente,
                                                                temp_salida_caliente,
                                                                temp_tuberia
                                                                FROM enfriamiento_adsorcion ORDER BY idenfriamiento_adsorcion DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);
  
  $arreglo = array("id" => $fila[0],
                   "fecha_hora" => $fila[1],
                   "presion" => $fila[2],
                   "presion_domo" => $fila[3],
                   "presion_tuberia" => $fila[4],
                   "temp_agua_fria" => $fila[5],
                   "temp_agua_caliente" => $fila[6],
                   "temp_salida_caliente" => $fila[7],
                   "temp_tuberia" => $fila[8]
                   );

  echo json_encode($arreglo);
}


function enfriamiento_adsorcion_diario($fecha, $act)
{
  if ($act==2)  
{
 $consulta = "SELECT idenfriamiento_adsorcion,
                                                                fecha_hora,
                                                                presion,
                                                                presion_domo,
                                                                presion_tuberia,
                                                                temp_agua_fria,
                                                                temp_agua_caliente,
                                                                temp_salida_caliente,
                                                                temp_tuberia
                                                                FROM enfriamiento_adsorcion
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
  
  $arreglo = array("id" => $fila[0],
                   "fecha_hora" => $fila[1],
                   "presion" => $fila[2],
                   "presion_domo" => $fila[3],
                   "presion_tuberia" => $fila[4],
                   "temp_agua_fria" => $fila[5],
                   "temp_agua_caliente" => $fila[6],
                   "temp_salida_caliente" => $fila[7],
                   "temp_tuberia" => $fila[8]
                   );
  
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function enfriamiento_adsorcion_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

      $consulta = "SELECT idenfriamiento_adsorcion,
                                                                fecha_hora,
                                                                presion,
                                                                presion_domo,
                                                                presion_tuberia,
                                                                temp_agua_fria,
                                                                temp_agua_caliente,
                                                                temp_salida_caliente,
                                                                temp_tuberia
                                                                FROM enfriamiento_adsorcion
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
                   "fecha_hora" => $fila[1],
                   "presion" => $fila[2],
                   "presion_domo" => $fila[3],
                   "presion_tuberia" => $fila[4],
                   "temp_agua_fria" => $fila[5],
                   "temp_agua_caliente" => $fila[6],
                   "temp_salida_caliente" => $fila[7],
                   "temp_tuberia" => $fila[8]
                   );
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}
?>