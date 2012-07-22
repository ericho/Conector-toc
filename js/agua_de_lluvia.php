<?

// Agua de lluvia

function agua_de_lluvia(){
  $consulta = "SELECT idagua_de_lluvia, 
                             fecha_hora, 
                             Nivel_1,
                             nivel_2,
                             nivel_3,
                             nivel_4,
                             nivel_5,
                             nivel_6,
                             bomba_1,
                             bomba_2
                             FROM agua_de_lluvia ORDER BY idagua_de_lluvia DESC LIMIT 1";

  $res = mysql_query($consulta);
  $fila = mysql_fetch_array($res);
  
  $arreglo = array("id" => $fila[0],
		   "fecha" => $fila[1],
		   "nivel_1" => $fila[2],
		   "nivel_2" => $fila[3],
		   "nivel_3" => $fila[4],
                   "nivel_4" => $fila[5],
                   "nivel_5" => $fila[6],
                   "nivel_6" => $fila[7],
		   "bomba_1" => $fila[8],
		   "bomba_2" => $fila[9]
 );

  echo json_encode($arreglo);
}

// Agua de lluvia DIARIO

function agua_de_lluvia_diario($fecha, $act){
  $consulta = "SELECT idagua_de_lluvia, 
                             fecha_hora, 
                             nivel_1,
                             nivel_2,
                             nivel_3,
                             nivel_4,
                             nivel_5,
                             nivel_6,
                             bomba_1,
                             bomba_2
                             FROM agua_de_lluvia
                             WHERE fecha_hora > '$fecha' AND fecha_hora < DATE_ADD('$fecha', INTERVAL 1 DAY) 
                             GROUP BY HOUR(fecha_hora)";
      

    
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "nivel_1" => $fila[2],
			   "nivel_2" => $fila[3],
			   "nivel_3" => $fila[4],
			   "nivel_4" => $fila[5],
			   "nivel_5" => $fila[6],
			   "nivel_6" => $fila[7],
			   "bomba_1" => $fila[8],
			   "bomba_2" => $fila[9]
			   );

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

// Agua de lluvia RANGOS
function agua_de_lluvia_rangos($fecha, $fecha2, $act){
  $consulta = "SELECT idagua_de_lluvia, 
                             fecha_hora, 
                             nivel_1,
                             nivel_2,
                             nivel_3,
                             nivel_4,
                             nivel_5,
                             nivel_6,
                             bomba_1,
                             bomba_2
                             FROM agua_de_lluvia
                             WHERE fecha_hora > '$fecha' AND fecha_hora < '$fecha2' 
                             GROUP BY YEAR(fecha_hora), MONTH(fecha_hora), DAY(fecha_hora) ORDER BY DATE(fecha_hora)";
      
    
  $res = mysql_query($consulta);
  $arreglo = array();
  while($fila = mysql_fetch_array($res))
    {
      $arreglo_tmp = array("id" => $fila[0],
			   "fecha" => $fila[1],
			   "nivel_1" => $fila[2],
			   "nivel_2" => $fila[3],
			   "nivel_3" => $fila[4],
			   "nivel_4" => $fila[5],
			   "nivel_5" => $fila[6],
			   "nivel_6" => $fila[7],
			   "bomba_1" => $fila[8],
			   "bomba_2" => $fila[9]
			   );

      array_push($arreglo, $arreglo_tmp);
    }

  echo json_encode($arreglo);

}

?>