<?

// Acuaponia

function acuaponia(){
  $consulta = "SELECT idacuaponia,
                                        fecha_hora,
                                        temp_amb,
                                        temp_agua,
                                        ph,
                                        dispensador_1a,
                                        dispensador_1b_frec,
                                        dispensador_2a,
                                        dispensador_2b_frec,
                                        dispensador_3a,
                                        dispensador_3b_frec,
                                        bomba_1a,
                                        bomba_1b,
                                        bomba_1c,
                                        bomba_2a,
                                        bomba_2b,
                                        bomba_2c
                                        FROM acuaponia ORDER BY idacuaponia DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);

  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "temp_amb" => $fila[2],
		   "temp_agua" => $fila[3],
		   "ph" => $fila[4],
		   "dispensador_1a" => $fila[5],
		   "dispensador_1b_frec" => $fila[6],
		   "dispensador_2a" => $fila[7],
		   "dispensador_2b_frec" => $fila[8],
		   "dispensador_3a" => $fila[9],
		   "dispensador_3b_frec" => $fila[10],
		   "bomba_1a" => $fila[11],
		   "bomba_1b" => $fila[12],
		   "bomba_1c" => $fila[13],
		   "bomba_2a" => $fila[14],
		   "bomba_2b" => $fila[15],
		   "bomba_2c" => $fila[16]
);

  echo json_encode($arreglo);
}

// Acuaponia diario

function acuaponia_diario($fecha, $act)
{
  if ($act==2)
    {

      $consulta = "SELECT idacuaponia,
                                        fecha_hora,
                                        temp_amb,
                                        temp_agua,
                                        ph,
                                        dispensador_1a,
                                        dispensador_1b_frec,
                                        dispensador_2a,
                                        dispensador_2b_frec,
                                        dispensador_3a,
                                        dispensador_3b_frec,
                                        bomba_1a,
                                        bomba_1b,
                                        bomba_1c,
                                        bomba_2a,
                                        bomba_2b,
                                        bomba_2c
                                        FROM acuaponia
                                        WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY)
                                        GROUP BY HOUR(fecha_hora)";


    }

  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "temp_amb" => $fila[2],
			   "temp_agua" => $fila[3],
			   "ph" => $fila[4],
			   "dispensador_1a" => $fila[5],
			   "dispensador_1b_frec" => $fila[6],
			   "dispensador_2a" => $fila[7],
			   "dispensador_2b_frec" => $fila[8],
			   "dispensador_3a" => $fila[9],
			   "dispensador_3b_frec" => $fila[10],
			   "bomba_1a" => $fila[11],
			   "bomba_1b" => $fila[12],
			   "bomba_1c" => $fila[13],
			   "bomba_2a" => $fila[14],
			   "bomba_2b" => $fila[15],
			   "bomba_2c" => $fila[16]);

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Acuaponia rangos

function acuaponia_rangos($fecha, $fecha2, $act)
{
  if ($act==3) // Rango de fechas
    {

      $consulta = "SELECT idacuaponia,
                                        fecha_hora,
                                        temp_amb,
                                        temp_agua,
                                        ph,
                                        dispensador_1a,
                                        dispensador_1b_frec,
                                        dispensador_2a,
                                        dispensador_2b_frec,
                                        dispensador_3a,
                                        dispensador_3b_frec,
                                        bomba_1a,
                                        bomba_1b,
                                        bomba_1c,
                                        bomba_2a,
                                        bomba_2b,
                                        bomba_2c
                                        FROM acuaponia
                                        WHERE fecha_hora > '$fecha' AND fecha_hora < '$fecha2'
                                        GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";

    }
//	echo $consulta;
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {

      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "temp_amb" => $fila[2],
			   "temp_agua" => $fila[3],
			   "ph" => $fila[4],
			   "dispensador_1a" => $fila[5],
			   "dispensador_1b_frec" => $fila[6],
			   "dispensador_2a" => $fila[7],
			   "dispensador_2b_frec" => $fila[8],
			   "dispensador_3a" => $fila[9],
			   "dispensador_3b_frec" => $fila[10],
			   "bomba_1a" => $fila[11],
			   "bomba_1b" => $fila[12],
			   "bomba_1c" => $fila[13],
			   "bomba_2a" => $fila[14],
			   "bomba_2b" => $fila[15],
			   "bomba_2c" => $fila[16]);

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);
  
}



?>