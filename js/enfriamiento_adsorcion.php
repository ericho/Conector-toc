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

function descargar_enfriamiento_adsorcion($fecha)
{
    $archivo = "enfriamiento_adsorcion_$fecha.csv";
     $consulta = "SELECT                                        fecha_hora,
                                                                presion,
                                                                presion_domo,
                                                                presion_tuberia,
                                                                temp_agua_fria,
                                                                temp_agua_caliente,
                                                                temp_salida_caliente,
                                                                temp_tuberia
                                                                FROM enfriamiento_adsorcion
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                            GROUP BY ROUND(UNIX_TIMESTAMP(fecha_hora) / 300)";

    $res = mysql_query($consulta);
    
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Description: File Transfer');
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$archivo}");
    header("Expires: 0");
    header("Pragma: public");
    
    //$fila = mysql_fetch_array($res);
    
    $cabecera = array();
    array_push($cabecera, 'Fecha');
    array_push($cabecera, 'Presion Generador');
    array_push($cabecera, 'Presion Evaporador Superior');
    array_push($cabecera, 'Presion Evaporador Inferior');
    array_push($cabecera, 'Temperatura Generador');
    array_push($cabecera, 'Temperatura Evaporador Superior');
    array_push($cabecera, 'Temperatura Evaporador Inferior');
    array_push($cabecera, 'Temperatura Inferior');
    
    
    $archivo_csv = @fopen('php://output', 'w');
    fputcsv($archivo_csv, $cabecera);
    while ($fila = mysql_fetch_row($res))
    {
        fputcsv($archivo_csv, $fila);
    }
    
    fclose($archivo_csv);
    exit;
    
}


?>
