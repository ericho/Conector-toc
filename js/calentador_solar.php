<?


// Calentador Solar

function calentador_solar(){
  $consulta = "SELECT idcalentador_solar,
                                                fecha_hora,
                                                temp_tuberia_1,
                                                temp_tuberia_2,
                                                temp_agua_caliente,
                                                temp_agua_fria
                                                FROM calentador_solar ORDER BY idcalentador_solar DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha_hora" => $fila[1],
		   "temp_tuberia_1" => $fila[2],
		   "temp_tuberia_2" => $fila[3],
		   "temp_agua_caliente" => $fila[5], // Los campos estan al reves
		   "temp_agua_fria" => $fila[4]);
  echo json_encode($arreglo);
}

function calentador_solar_diario($fecha, $act)
{
  if ($act==2)
    {
     
$consulta = "SELECT idcalentador_solar,
                                                fecha_hora,
                                                temp_tuberia_1,
                                                temp_tuberia_2,
                                                temp_agua_caliente,
                                                temp_agua_fria
                        	         	 FROM calentador_solar
                                         WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                         GROUP BY HOUR(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
    $arreglo_tmp = array("id" => $fila[0],
		   "fecha_hora" => $fila[1],
		   "temp_tuberia_1" => $fila[2],
		   "temp_tuberia_2" => $fila[3],
		   "temp_agua_caliente" => $fila[5], // Campos invertidos ;)
		   "temp_agua_fria" => $fila[4]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

function calentador_solar_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {
$consulta = "SELECT idcalentador_solar,
                                                fecha_hora,
                                                temp_tuberia_1,
                                                temp_tuberia_2,
                                                temp_agua_caliente,
                                                temp_agua_fria
                        	         	 FROM calentador_solar
                                 WHERE fecha_hora >= '$fecha' AND fecha_hora <= '$fecha2'
                                 GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
		   "fecha_hora" => $fila[1],
		   "temp_tuberia_1" => $fila[2],
		   "temp_tuberia_2" => $fila[3],
		   "temp_agua_caliente" => $fila[5], // Campos invertidos.
		   "temp_agua_fria" => $fila[4]);
      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Genera una consulta y descarga al informacion en formato CSV. 
function descargar_calentador_solar($fecha)
{
    $archivo = "calentador_solar_$fecha.csv";
    $consulta = "SELECT fecha_hora,      
                            temp_tuberia_1,
                            temp_tuberia_2,
                            temp_agua_caliente,
                            temp_agua_fria
                            FROM calentador_solar
                            WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)";
    $res = mysql_query($consulta);
    
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Description: File Transfer');
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$archivo}");
    header("Expires: 0");
    header("Pragma: public");
    
    $fila = mysql_fetch_array($res);
    
    $archivo_csv = @fopen('php://output', 'w');
    while ($fila = mysql_fetch_array($res))
    {
        fputcsv($archivo_csv, $fila);
    }
    
    fclose($archivo_csv);
    exit;
    
}

?>