
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>


<?php
/*****************************************************************************************************************
* AQUI SE VAN A DEFINIR LAS FUNCIONES AJAX, PARA OBTENER DATOS DINAMICAMENTE DE LA BASE DE DATOS 
* Este archivo recibe dos parametros por el metodo GET: 
* func : El nombre de la funcion que se va a ejecutar 
* param: El valor del parametro a buscar en la base de datos,
* Regresa mediante echo, los valores encontrados o el aviso correspondiente, para ser procesado en javascript mediante miAjax.responseText
* (miAjax es el objeto que voy esta creado en el proyecto, y es de tipo XMLHttpRequest();, que es el corazón de Ajax
**********************************************************************************************************************/

 
 $mi_param=$_REQUEST["param"];  //  Obtenemos el parametro, que puede ser un Id, un IMEI o lo que queramos buscar
 
 switch ($_REQUEST["func"]) { 
  case "checa_equipo_para_venta"      :  checa_equipo_para_venta(strval($mi_param));      break;   //  Tambien sirve para traspasos   
  case "checa_simcard_para_traspaso"  :  checa_simcard_para_traspaso(strval($mi_param));  break;      
  case "checa_sim_para_venta"         :  checa_sim_para_venta(strval($mi_param));         break;  //  Tambien va a servir para traspasos   
  case "checa_sim_para_ingreso"       :  checa_sim_para_ingreso(strval($mi_param));       break;  //  Checa si el SIM ya existe al momento de comprarlo o ingresarlo, ya sea como SIM_Card o asignado a un telefono, incluso si es historico. 
  case "db_ejecuta_ajax"			  :  db_ejecuta_ajax(strval($mi_param));			  break;  // Esta recibe el SQL que hay que ejecutar
  case "cierra_conexion"              :  $conn->Close();  								  break;  // Cierra la conección, para poderla llamar desde Javascript mediante Ajax
  default:                         
    echo "No_Function"; //  Esto nunca DEBE suceder
 } // switch              


/*******************************************************************************
* Esta rutina es llamada desde Db_Ejecuta_ajax, que esta en global (Client_Evets) 
* Recibe el SQL a ejecutar  ... INSERT, UPDATE, DELETE  (No regresa nada, solo ejecuta la sentencia que se le pasa
* Ya veremos despues como validamos el exito o fracaso e la operacion, por lo pronto está regresando el numero de registros afectados, y lo hace bien
/*****************************************************************************/
 function db_ejecuta_ajax($AuxSQL) {  
  global $conn;
  if (!isset($conn)) $conn = ew_Connect();  // Si no esta establecida la establecemos con el proyecto que esta en el direcotorio actual
  $conn->Execute($AuxSQL);  	     //  Ejecuta la sentencia
  $Renglones=$conn->Affected_Rows(); // Sacamos el numero de renglones afectados (Parece que solo jala para update y delete)
  $conn->CommitTrans();   			 // Cierra transacciones
  $conn->Close(); 					 // Cerramos la coneccion, para que no se acumulen conecciones abiertas
  echo $Renglones;         			 //  Regresa el numero de renglones afectados
} 

 
/********************************************************************************************************
*  Checa si el IMEI especificado para Venta o Traspaso, (KIT O lIBRE) esta disponible en la tienda actual, 
* está en otra tienda, fué traspasado desde o hacia esta tienda o incluso si fue traspasado a otra tienda.                	
*  En cada caso devuelve la "Situacion" como primer dato y los valores pertinentes en los demas. Son 10 datos.
/*******************************************************************************************************/
 function checa_equipo_para_venta($Imei) {
  global $conn;
  if (!isset($conn)) $conn = ew_Connect();  // Si no esta establecida la establecemos con el proyecto que esta en el direcotorio actual

  $Tienda=Id_Tienda_actual(); 
  $AuxSQL="SELECT * FROM aux_sel_equipo_venta WHERE Num_IMEI ='" .$Imei ."'";  //  Ahora se puede vender el equipo aun cuando NO este en la tienda, incluso si NO haya habido un traspaso
  $RsAux = $conn->Execute($AuxSQL); 
  $RsAux->MoveFirst();
  $rs=$RsAux->fields;  // Nomas para indexar directo sin tener que poner fields en cada campo
 
  $Situacion= "Error";  // Si no entra en ninguno de los Ifs siguientes hubo un error
  If ($RsAux->EOF) {  // Si NO encontro el registro, regresamos "NotFound", que quiere decir que el teléfono NO ha sido registrado en el sistema
    $Situacion= "NotFound";
  } else {    // "Encontrado" Vamos a ver si esta en transito o en Tienda
    if ($rs['Status']=="Transito") {  // El teléfono fué enviado y no se ha registrado el recibo
		if ($rs['Id_Almacen_Enviado']==Id_Tienda_actual()) {	  // Si me lo enviaron
			$Situacion= "MeLoEnviaron";
		} elseif  ($rs['Id_Almacen']==Id_Tienda_actual()) {	  // Si yo lo envié
			$Situacion= "YoLoEnvie";
		}  else { // Si está en transito, pero ni lo envie yo ni me lo enviaron  Hay que ver que hacer 	
			$Situacion= "TransitoAjeno";
		}  //  Si no esta en transito
	} elseif ($rs['Status']=="Tienda") {  //  Si esta en una Tienda
		if ($rs['Id_Almacen']==Id_Tienda_actual()) {   // Si está en mi tienda
		   $Situacion= "EnMiTienda";
		} else {   // Si esta en otra Tienda
		   $Situacion= "EnOtraTienda";
		}
	}  //  elseif
  }  // fin "Encontrado"
   //  Regresamos la Situacion , junto con los datos que se pueden ocupar en JavaScript
  echo $Situacion.",".$rs['Id_Tel_SIM'].",".$rs['EquipoAcabado'].",".$rs['Num_ICCID'].",".$rs['Num_CEL'].",".$rs['Num_IMEI'].",".$rs['Con_SIM'].","
      .$rs['Almacen'].",".$rs['Precio_Venta'].",".$rs['Almacen_Enviado'].",".$rs['Id_Almacen_Enviado'].",".$rs['Id_Articulo'].",".$rs['Descuento_Sin_Chip'];  
  $conn->Close(); // Cerramos la coneccion, para que no se acumulen conecciones abiertas
}




/********************************************************************************************************
/*  Checa si el ICCID especificado ya existe en el sistema, como Sim, asignado a un teléfono, o incluso si ya fue vendido
/*  Si no existe, devuelve la palabra "NotFound". (OJO, Por lo pronto solo estoy verificando si existe, ya despues haremos validaciones   															
/*******************************************************************************************************/
 function checa_sim_para_ingreso($Iccid) {
  global $conn;
  if (!isset($conn)) $conn = ew_Connect();  // Si no esta establecida la establecemos con el proyecto que esta en el direcotorio actual

  $Tienda=Id_Tienda_actual(); 
  $AuxSQL="SELECT * FROM aux_sel_sim_para_ingreso WHERE Num_ICCID ='" .$Iccid ."'";  //  Checa si el SIM ya existe, no importa si está como SIM o asignado a un teléfono, incluso si ya fué vendido
  $RsAux = $conn->Execute($AuxSQL); 
  $RsAux->MoveFirst();
  $rs=$RsAux->fields;  // Nomas para indexar directo sin tener que poner fields en cada campo
 
  $Situacion= "Error";  // Si no entra en ninguno de los Ifs siguientes hubo un error
  If ($RsAux->EOF) {  // Si NO encontro el registro, regresamos "NotFound", que quiere decir que el SIM NO ha sido registrado en el sistema
    $Situacion= "NotFound";
  } else {    // "Encontrado" Vamos a ver si esta en transito o en Tienda
    if ($rs['Status']=="Transito") {  // El teléfono fué enviado y no se ha registrado el recibo
		if ($rs['Id_Almacen_Enviado']==Id_Tienda_actual()) {	  // Si me lo enviaron
			$Situacion= "MeLoEnviaron";
		} elseif  ($rs['Id_Almacen']==Id_Tienda_actual()) {	  // Si yo lo envié
			$Situacion= "YoLoEnvie";
		}  else { // Si está en transito, pero ni lo envie yo ni me lo enviaron  Hay que ver que hacer 	
			$Situacion= "TransitoAjeno";
		}  //  Si no esta en transito
	} elseif ($rs['Status']=="Tienda") {  //  Si esta en una Tienda
		if ($rs['Id_Almacen']==Id_Tienda_actual()) {   // Si está en mi tienda
		   $Situacion= "EnMiTienda";
		} else {   // Si esta en otra Tienda
		   $Situacion= "EnOtraTienda";
		}
	} elseif ($rs['Status']=="Vendido") {  //  Si esta registrado como vendido
	   $Situacion= "Vendido";
	}  // 
  }  // fin "Encontrado"
   //  Regresamos la $Situacion , junto con los datos que se pueden ocupar en JavaScript
  echo $Situacion.",".$rs['Id_Tel_SIM'].",".$rs['Articulo'].",".$rs['Num_ICCID'].",".$rs['Num_CEL'].",".$rs['Precio_Venta'].","
					.$rs['Almacen'].",".$rs['Almacen_Enviado'].",".$rs['Id_Articulo'].",".$rs['Id_Almacen_Enviado'];  
  $conn->Close(); // Cerramos la coneccion, para que no se acumulen conecciones abiertas
}


/********************************************************************************************************
/*  Checa si el IMEI especificado para Venta (KIT)esta disponible en la tienda actual, está en otra tienda, fué traspasado desde o hacia                	
/*  Si no, devuelve la palabra "NotFound"   															
/*******************************************************************************************************/

 function checa_sim_para_venta($Iccid) {
  global $conn;
  if (!isset($conn)) $conn = ew_Connect();  // Si no esta establecida la establecemos con el proyecto que esta en el direcotorio actual

  $Tienda=Id_Tienda_actual(); 
  $AuxSQL="SELECT * FROM aux_sel_trasp_sim WHERE Num_ICCID ='" .$Iccid ."'";  //  Ahora se puede vender o traspasar el SIM aun cuando NO este en la tienda, incluso si NO haya habido un traspaso
  $RsAux = $conn->Execute($AuxSQL); 
  $RsAux->MoveFirst();
  $rs=$RsAux->fields;  // Nomas para indexar directo sin tener que poner fields en cada campo
 
  $Situacion= "Error";  // Si no entra en ninguno de los Ifs siguientes hubo un error
  If ($RsAux->EOF) {  // Si NO encontro el registro, regresamos "NotFound", que quiere decir que el SIM NO ha sido registrado en el sistema
    $Situacion= "NotFound";
  } else {    // "Encontrado" Vamos a ver si esta en transito o en Tienda
    if ($rs['Status']=="Transito") {  // El teléfono fué enviado y no se ha registrado el recibo
		if ($rs['Id_Almacen_Enviado']==Id_Tienda_actual()) {	  // Si me lo enviaron
			$Situacion= "MeLoEnviaron";
		} elseif  ($rs['Id_Almacen']==Id_Tienda_actual()) {	  // Si yo lo envié
			$Situacion= "YoLoEnvie";
		}  else { // Si está en transito, pero ni lo envie yo ni me lo enviaron  Hay que ver que hacer 	
			$Situacion= "TransitoAjeno";
		}  //  Si no esta en transito
	} elseif ($rs['Status']=="Tienda") {  //  Si esta en una Tienda
		if ($rs['Id_Almacen']==Id_Tienda_actual()) {   // Si está en mi tienda
		   $Situacion= "EnMiTienda";
		} else {   // Si esta en otra Tienda
		   $Situacion= "EnOtraTienda";
		}
	} elseif ($rs['Status']=="Vendido") {  //  Si esta registrado como vendido
	   $Situacion= "Vendido";
	}  //
  }  // fin "Encontrado"
   //  Regresamos la $Situacion , junto con los datos que se pueden ocupar en JavaScript
  echo $Situacion.",".$rs['Id_Tel_SIM'].",".$rs['Articulo'].",".$rs['Num_ICCID'].",".$rs['Num_CEL'].",".$rs['Precio_Venta'].","
					 .$rs['Almacen'].",".$rs['Almacen_Enviado'].",".$rs['Id_Articulo'].",".$rs['Id_Almacen_Enviado'].",".$rs['Activacion_Movi'];  
  $conn->Close(); // Cerramos la coneccion, para que no se acumulen conecciones abiertas
}


 
/*****************************************************************************************************
*  Checa si el ICCID especificado para traspaso esta disponible en la tienda actual                 
*  Si enconto el registro devuelve  Status , Articulo,  Num_CEL , Id_Tel_SIM
*    Si esta en tienda, Status = "Tienda"
*    Si ya fue enviado, Status = "Transito",Almacen_Destino									
*    Si No existe en la tienda, devuelve la palabra "NotFound" (en la posicion de Status)   														
*  Si hubo algun error, devuelve la tabla que indica el error
/*****************************************************************************************************/
function checa_simcard_para_traspaso($Iccid) {
  global $conn;
  if (!isset($conn)) $conn = ew_Connect();  // Si no esta establecida la establecemos con el proyecto que esta en el direcotorio actual

  $Tienda=Id_Tienda_actual(); 
  $AuxSQL="SELECT Articulo, Num_ICCID, Status, Num_CEL, Id_Tel_SIM,Almacen_Destino FROM aux_sel_trasp_sim 
			WHERE Num_ICCID ='" .$Iccid ."' AND Id_Almacen=".$Tienda;
  $RsAux = $conn->Execute($AuxSQL); 
  $RsAux->MoveFirst();
  $rs=$RsAux->fields;  // Nomas para indexar directo sin tener que poner fields en cada campo
   
  If (! $RsAux->EOF) {              // Si encontro el registro
    echo $rs['Status'].",".$rs['Articulo'].",".$rs['Num_CEL'].",".$rs['Id_Tel_SIM'].",".$rs['Almacen_Destino'];
  } else {    // Si NO lo encontro, regresamos "NotFound"
    echo "NotFound";
  }  // fin del else
  $conn->Close(); // Cerramos la coneccion, para que no se acumulen conecciones abiertas
}  // checa_simcard_para_traspaso



 
function Id_Tienda_actual() {
  if (isset($_COOKIE['artencel_tienda'])) {
    return $_COOKIE['artencel_tienda'];
  } else {
    //Redireccionar('op_elige_tiendalist.php');
    return 0;
  }                      
}                  

  
?>  

