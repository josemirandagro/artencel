<?php

/*  =======================  RUTINAS GENERALES APLICABLES A TODOS LOS PROYECTOS ===========================
* Es muy importante respaldarlo a menudo en el directorio de los fuentes y base de datos del proyecto en el cual se esta trabajando 
*   ======================================================================================================  */

/***************************************************************************************
* Manda llamar directamente la pagina especificada. Se le pueden incluir parametros
* Realmente la pongo por que no me acuerdo bien de la instruccion header y para no cometer errores
***********************************************************************************************************/
function Redireccionar($pagina) {
  //mysql_close(); Funciona hasta versión 5.5 de MySQL
  mysql_close();  // Cerramos la coneccion actual MySQL para que no salga el error de muchas conecciones abiertas
  header('Location:'. $pagina);      
  exit;                     
}


function Pon_Header_Footer() {
   global $Language;
  //  PONEMOS EL NOMBRE DEL USUARIO SI ES QUE YA ESTA LOGGEADO
  if (! (strtoupper(CurrentUserName())=="")) {
    $usr = " USUARIO:" . strtoupper (CurrentUserName()) ." -- "; // Traemos el Nombre del Usuario     
                    
    $PiePag = $Language->ProjectPhrase("FooterText") . $usr . ". ";
    $GLOBALS["Language"]->setProjectPhrase("FooterText", $PiePag );   // PONEMOS EL NOMBRE DEL USUARIO EN EL FOOTER              
    $GLOBALS["Language"]->setProjectPhrase("BodyTitle", $usr );   // PONEMOS EL NOMBRE DEL USUARIO EN EL HEADER 
  }     
                                    
  if (Id_Tienda_Actual()!=0) { // SI YA ESTA ESTABLECIDA LA TIENDA                        
      // TRAEMOS EL NOMBRE DE LA TIENDA
    $TiendaActual = ew_ExecuteScalar("SELECT Almacen FROM ca_almacenes WHERE Id_Almacen=" . Id_Tienda_Actual() );                                                       
  } else {
    $TiendaActual = "TIENDA NO ESTABLECIDA";
  }                                        
            
      // LA AGREGAMOS AL FOOTER        
  $PiePag = $Language->ProjectPhrase("FooterText") . " TIENDA :" . $TiendaActual;
  $GLOBALS["Language"]->setProjectPhrase("FooterText", $PiePag );   
                          
      // LA AGREGAMOS AL HEADER                              
  $HeadPag = $Language->ProjectPhrase("BodyTitle") . "  TIENDA :" . $TiendaActual;
  $HeadPag = "<hr />". $HeadPag;   // Le ponemos la linea horizontal
  $GLOBALS["Language"]->setProjectPhrase("BodyTitle", $HeadPag );   
}

function Pon_nombre_pestana() {

  global $Language;
/*****  ESTA SECCION ES LA QUE PONE EL NOMBRE LE LA PAGINA EN LA PESTAÑA DEL NAVEGADOR  **********/
// OJO.. Estas paginas NO traen establecido el TableName, asi que asignamos el título en forma manual
// echo " Pagina : ". CurrentPage()->PageObjName;
switch (CurrentPage()->PageObjName) { 
  case "login":  $Cap = "INGRESAR"; break;      
  case "register": $Cap = "REGISTRO"; break;
  case "forgotpwd": $Cap = "RECUPERAR PASSWORD"; break;
  case "userpriv": $Cap = "PERMISOS"; break;
  case "op_elige_tienda_list": $Cap = "ESTABLECER TIENDA"; break;
  case "custompage" : $Cap = ""; break;                 
  default:                         
    $Cap = $Language->TablePhrase(CurrentTable()->TableName, "TblCaption");                           
} // switch              

// PONEMOS EL CAPTION DE LA TABLA O VISTA EN LA PESTAÑA DEL NAVEGADOR
echo "<script type=\"text/javascript\">$(document).ready(function() {" .
         "document.title = '" . $Cap . "';" .
         "});" .
         "</script>";                                          
         

}

/*********************************************************************************************
* Ejecuta una sentencia en la base de datos. La sentencia va en $AuxSQL
* Si Verla es 0 no la muestra, si es 1 la muestra en ECHO, si es 2 la muestra en ALERT
********************************************************************************************/
function DB_Ejecuta($AuxSQL,$Verla=0) {                           
    global $conn;                                                                    
                               
  switch ($Verla) {                   
    case 1:  // Se muestra como letrero (Se interrumpe la ejecucion)            
        echo "<br>".$AuxSQL;                            
        exit();  // Si no pongo exit, no muestra el letrero, pues carga la pagina completa en chinga
        break;                                                     
    case 2:   // Se muestra como Alerta (Se interrumpe la ejecucion)
        Alertame("Ejecutando: " . $AuxSQL);                  
        exit();  // Si no le pongo exit, no muestra la ventana
        break;   
  }                          
  //  Si no le pusieron 1 o 2 en Verla, Se ejecuta la operacion
  $GLOBALS["conn"]->Execute($AuxSQL);
  $GLOBALS["conn"]->CommitTrans();
}                                                                                 


/*********************************************************************************************
* Ejecuta una sentencia SQL en modo SACALAR en la base de datos. La sentencia va en $AuxSQL
* Esto sirve para buscar UN VALOR especifico en la tabla. Regresa el valor de ew_ExecuteScalar
* Si Verla es 0 no la muestra, si es 1 la muestra en ECHO, si es 2 la muestra en ALERT
********************************************************************************************/
function DB_EjecutaScalar($AuxSQL,$Verla=0) {                           
  $Res=ew_ExecuteScalar ("$AuxSQL");      

  switch ($Verla) {              
    case 1:  // Se muestra como letrero (Se interrumpe la ejecucion)            
        echo "<br> ".$AuxSQL;                            
        echo "<br> Resultado = " . $Res;                            
        exit();  // Si no pongo exit, no muestra el letrero, pues carga la pagina completa en chinga
        break;                                                     
    case 2:   // Se muestra como Alerta (Se interrumpe la ejecucion)
        Alertame("Ejecutando: " . $AuxSQL. " Resultado = " . $Res);           
        exit();  // Si no le pongo exit, no muestra la ventana
        break;   
  }  // Switch                          
  return $Res;  // Devolvemos el resultado  
}                                                                                 

            
/*********************************************************************************************
* Ejecuta la sentencia contenida en $AuxSQL en modo $Rs, la sentencia siempre debe ir FILTRADA A UN SOLO REGISTRO 
* CON UNA CLAUSULA WHERE. Esto sirve para buscar Solo ciertos campos DEL REGISTRO EN UNA VISTA O TABLA
* Regresa una variable tipo registro en el modo $Rs->fields; (Para acceder los campos solo hay que poner $result['NombreCampo']
* donde $esult es la variabale que usamos al llamarla : $result=DB_EjecutaRs("SELECT ...  WHERE ..."); 
*  Para usar el resultado, por ejemplo para sebr el nombre del empleado nos referimos a $result['Nombre_Empleado']   
* Si Verla es 0 no la muestra, si es 1 la muestra en ECHO, si es 2 la muestra en ALERT
********************************************************************************************/
function DB_EjecutaRs($AuxSQL,$Verla=0) {                           
  global $conn;                        

// $AuxSQL= "SELECT * FROM prn_nota_venta_equipo WHERE Id_Tel_SIM =" . $Id_Unico;
 $RsAux = $conn->Execute($AuxSQL);                                                                    
            
 // Pasamos los campos a la variable $rs, para referenciarlos rapidamente
 $Rs = $RsAux->fields;                              
  switch ($Verla) {    
    case 1:  // Se muestra como letrero (Se interrumpe la ejecucion)            
        echo "<br>".$AuxSQL . ";  Resultado = " . $Rs[0];                            
        exit();  // Si no pongo exit, no muestra el letrero, pues carga la pagina completa en chinga
        break;                                                     
    case 2:   // Se muestra como Alerta (Se interrumpe la ejecucion)
        Alertame("Ejecutando: ". $AuxSQL. ";   Resultado = " . $Rs[0]);           
        exit();  // Si no le pongo exit, no muestra la ventana
        break;   
  }                          
 return $Rs;
}             



/***********************************************************************************************************       
* Despliega el objeto Identado y con espacios, para una lectura mucho mas facil que print_r,               *          
* Se puede usar con $This,   CurrentPage() , $Language (hay que declarar global $Language al llamarla      *
*  Como ejemplo, se puede leer o midificar un valor en una pagina asi                                      *
*  Print_r_lut($Language->Phrases['ew-language']['global']['phrase']['editbtn']['attr']['value']);         *
*  $Language->Phrases['ew-language']['global']['phrase']['editbtn']['attr']['value']="GENERAR_NOMINA";     *    
********************************************************************************************************** */                                                  
function print_r_lut($val){
  echo '<pre>';
  print_r($val);
  echo  '</pre>';
}
                                          
            
/*******************************************************************************************************
* Emite un Alert de JavaScript desde PHP. Recibe en TxtAlerta el texo que hay que desplegar en la alerta
* Creo que se puede llamar varias veces consecutivas con Salir =False, pero para que se vea el Alert
* forzosamente hay que poner Salir=true, en la ultima llamada
********************************************************************************************************/
function Alertame($TxtAlerta,$Salir=FALSE) {                   
//  echo "<br> Dentro de Alertame, muestro el texto: ". $TxtAlerta ."Lut";  
  echo "<script type=\"text/javascript\"> alert(\" -- " . $TxtAlerta . " -- \"); </script>";

  if ($Salir==TRUE){
    exit(); // Para que se vea la alerta. Esto interrumpe el proceso, pero muestra la alerta.
  }  
}                            

  
/***********************************************************************************************
*  Convierte Monto en la cantidad en letra con el formato Mexicano  XXXXXX  PESOS XX/100 MN
***********************************************************************************************/
function MontoEnLetra($Monto) { 
                    
    $Total=explode(".",$Monto);  // Separa los pesos en dos partes Total[0] es los pesos, Total[1] son los centavos
    $Pesos = $Total[0];     
    $Centavos=round($Total[1],2);
    $CantLetra = num2letras($Pesos, false, false);
    $CantLetra.= " pesos ". str_pad($Centavos,2,'0',STR_PAD_RIGHT). "/100 MN";
    $CantLetra = strtoupper ($CantLetra); 
    return ($CantLetra);                                   
}    
          
/********************************************************************************** 
* Convierte la cantidad dada en el letrero correspondiente en letras (cinco mil novecientos ....)
* Parametros:
*  $num number - Numero a convertir. 
*  $fem bool - Forma femenina (true) o no (false). 
*  $dec bool - Con decimales (true) o no (false). 
***********************************************************************/ 
function num2letras($num, $fem = true, $dec = true) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} 

?>


