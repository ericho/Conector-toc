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


function descargar_destilador_solar($fecha)
{
    $archivo = "destilador_solar_$fecha.csv";
    $consulta = "SELECT                         fecha_hora,
                                                temp_sol,
                                                temp_lente,
                                                temp_interna,
                                                nivel_contenedor
                                                FROM destilador_solar
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
    array_push($cabecera, 'Temperatura sol');
    array_push($cabecera, 'Temperatura lente');
    array_push($cabecera, 'Temperatura interna');
    array_push($cabecera, 'Nivel contenedor');
    
    
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