<?php
/* =======================  RUTINAS GENERALES DE ARTENCEL  ==============================================
* Es muy importante respaldarlo a menudo en el directorio de los fuentes y base de datos del proyecto en el cual se esta trabajando 
==========================================================================================  */

$pdf;   //  La declaramos como global 
$AltoBanner=20;   // La Altura de la imagen del banner del reporte
$AnchoBanner=210; // El Ancho de la imagen del banner del reporte


// Pone los parametros iniciales del documento, usando la variable global "pdf", 
function inicializa_documento_pdf() {
   global $pdf;     //  la referenciamos para poderla usar en esta rutina, pero es global

/*  Hay que ver si la version 6 jala igual en los documentos ya hechos de Papeleta y Nota de Venta 
    require_once('tcpdf_6/config/lang/eng.php');    
    require_once('tcpdf_6/tcpdf.php');
*/
    require_once('tcpdf_php4/config/lang/eng.php');    
    require_once('tcpdf_php4/tcpdf.php');
   
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);                                
    $pdf->SetAuthor('Artencel');           
    $pdf->SetTitle('Inventario Fisico');          
    $pdf->SetSubject('Impresion de Inventario Fisico');
    $pdf->SetKeywords('TCPDF, PDF, Artencel, Inventario ');

    // remove default header/footer       
    $pdf->setPrintHeader(false);             
    $pdf->setPrintFooter(false);                                                             

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins                 
      //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    $pdf->SetMargins(2, 2, 2);  // Left,Top  

    //set auto page breaks  //  Creo que va en TRUE, genera un salto de pagina adicional                                           
    $pdf->SetAutoPageBreak(TRUE, 0.5 /*PDF_MARGIN_BOTTOM*/); //  OJO, hay que var para que es esto

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //set some language-dependent strings
    $pdf->setLanguageArray($l);    

    // set font                       
    $pdf->SetFont('courier', 'B', 9);

	
	// set cell padding
	$pdf->setCellPaddings(1, 1, 1, 1);

	// set cell margins
	$pdf->setCellMargins(0, 0, 0, 0);


    // add a page                              
    $pdf->AddPage();     
	
}

function GeneraPDF_Inventario_Tienda($Id_Tienda) {
   global $conn;  
   global $pdf;     

 
//   echo "entrando con Id tienda igual a : " .$Id_Tienda;
//   exit;
  
// Usmos la vista tda_existencia_equipos  para subir el inventario de equipos en cada tienda
  $AuxSQL= "SELECT * FROM tda_existencia_equipos WHERE Id_Almacen=" . $Id_Tienda . " ORDER BY Articulo ASC";
  $RsAux = $conn->Execute($AuxSQL);                                                                    

 // Pasamos los campos a la variable $rs, para referenciarlos rapidamente
  $rs = $RsAux->fields;              
  
   inicializa_documento_pdf(); // Inicializamos el documento de PDF

   conf_encabezado();  
   $let_hdr= "INVENTARIO FISICO, TIENDA : " . $RsAux->fields['Almacen'] . "    FECHA : " . date('d/m/Y');  
   $pdf->Cell(0,0,$let_hdr,1,1,'C',1);		// Titulo

   conf_dato();
   $pdf->Cell(50,0,'Equipo '	,1,0,'L',0);		  
   $pdf->Cell(20,0,'Acabado '	,1,0,'L',0);		 
   $pdf->Cell(23,0,'IMEI '		,1,0,'L',0);		 
   $pdf->Cell(10,0,'OK '		,1,0,'L',0);		 

   $pdf->Cell(50,0,'Equipo '	,1,0,'L',0);		  
   $pdf->Cell(20,0,'Acabado '	,1,0,'L',0);		 
   $pdf->Cell(23,0,'IMEI '		,1,0,'L',0);		 
   $pdf->Cell(10,0,'OK '		,1,1,'L',0);		 

   $pdf->SetFont('times', 'B', 7.5);
   $pdf->SetFillColor(255 /*, 50, 50*/); // Ponemos Fill Color Blanco
   $pdf->setColor('text',0 /*, 0, 0*/); // Ponemos el color del texto en NEGRO
   
   $reng=1;
   while (! $RsAux->EOF) {
	   /*  MultiCelll permite hacer Stretch (ajustar el texto, ultimo parametro, hay que ver el manual */
	   
	 $let_equipo = str_replace("(LIBRE)","",$RsAux->fields['Articulo']);
 	 $pdf->MultiCell(50, 0, $let_equipo, 				    'B',    'L', 1, 0, '', '', true,2);
	 $pdf->MultiCell(20, 0, $RsAux->fields['Acabado_eq'], 	'B',    'L', 1, 0, '', '', true,2);
	 $pdf->MultiCell(23, 0, $RsAux->fields['Num_IMEI'], 	'B',    'L', 1, 0, '', '', true,0); 
	 $pdf->MultiCell(10, 0, "           ",					'LTRB', 'L', 1, 0, '' ,'', true,0);
	 $RsAux->MoveNext();  // Nos movemos al siguiente renglon                               

	 $let_equipo = str_replace("(LIBRE)","",$RsAux->fields['Articulo']);
 	 $pdf->MultiCell(50, 0, $let_equipo, 				    'B',    'L', 1, 0, '', '', true,2);
	 $pdf->MultiCell(20, 0, $RsAux->fields['Acabado_eq'], 	'B',    'L', 1, 0, '', '', true,2);
	 $pdf->MultiCell(23, 0, $RsAux->fields['Num_IMEI'], 	'B',    'L', 1, 0, '', '', true,0); 
	 $pdf->MultiCell(10, 0, " ",							'LTRB', 'L', 1, 1, '' ,'', true,0);

	 $RsAux->MoveNext();  // Nos movemos al siguiente renglon                               
     
	 
/*
    $pdf->Cell(70,0,$RsAux->fields['Estudio']				,0,0,'L',1);	 
	$pdf->Cell(70,0,$RsAux->fields['Escuela']				,0,0,'L',1);	 
	$pdf->Cell(14,0,formatea_fecha($RsAux->fields['Fecha'])	,0,0,'L',1);	 
	$pdf->Cell( 0,0,$RsAux->fields['Documento']				,0,1,'L',1);	 
*/
   } // While                                                                       
    //Close and output PDF document

  ob_start();     
  $pdf->Output('papeleta.pdf', 'I');
  ob_end_flush(); 
 
}


/*****************************************************************************************************
* Regresa el Id de la tienda Actual guardada como Cookie en el cliente.
* Decclaro esta funcion para poder usarla como default values para los campos que asi lo requieran 
****************************************************************************************************/ 
function Id_Tienda_actual() {
  if (isset($_COOKIE['artencel_tienda'])) {
    return $_COOKIE['artencel_tienda'];
  } else {
    //header('Location: op_elige_tiendalist.php');
    return 0;
  }                      
}                  

/*******************************************************************************************************************
*  Checa los equipos, recien ingresados en reg_unico_TEL_SIM. 
*  Los que tienen ICCID Y Num_CEL, les pone KIT, a los otros les pone LIBRE  
*  La vamos a llamar en todo los lugares en que se ingresan telefonos
********************************************************************************************************************/
function Actualiza_Con_SIM_In($Id_Tel_SIM) {
  //  Si al ingresar o editar un equipo, tiene ICCID y Numero Telefonico asignado, entonces es KIT, si no , es "SIN CHIP"
  DB_Ejecuta("UPDATE reg_unico_tel_sim set Con_SIM_In=IF((not ISNULL(Num_ICCID)) and (NOT ISNULL(Num_CEL)),'KIT','SIN CHIP') WHERE Id_Tel_SIM = ". $Id_Tel_SIM);
  //  Si al ingresar o editar un equipo, tiene ICCID y Numero Telefonico asignado, entonces es KIT, si no , es "SIN CHIP"
  DB_Ejecuta("UPDATE reg_unico_tel_sim set Con_SIM=IF((not ISNULL(Num_ICCID)) and (NOT ISNULL(Num_CEL)),'KIT','SIN CHIP') WHERE Id_Tel_SIM = ". $Id_Tel_SIM);
}

/*************************************************************************
* Imprime la Papeleta en un archivo PDF, utilizando la liberia TCPDF
* Recibe el registro                                                                  
***************************************************************************/
function GeneraPDF_Papeleta($Id_Unico) {             
   global $conn;                        

// Subimos el registro completo, ya que rsold trae unos datos(los que ya estaban) y rsnew otros (los nuevos)
 $AuxSQL= "SELECT * FROM prn_papeleta WHERE Id_Venta_Eq =" . $Id_Unico;
 $RsAux = $conn->Execute($AuxSQL);                                                                    

 // Pasamos los campos a la variable $rs, para referenciarlos rapidamente
 $rs = $RsAux->fields;              
  echo "Id Unico :" . $Id_Unico;                         
  echo "Telefono : ".$rs['Tel_Particular'];      
  echo "<br>Folio : ".$rs['FolioImpreso'];       

// exit;                         
  // ===================================  Rutina de IMPRESION EN PDF  =========================
  // OJO... hay que completar todos los datos al numero de caracteres maximo o bien ver en la libreria como hacerle
  // par imprimir en ciertas posiciones en cm o en pixles.

    require_once('tcpdf_php4/config/lang/eng.php');    
    require_once('tcpdf_php4/tcpdf.php');
                                                                                                          
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);                                
    $pdf->SetAuthor('Artencel');           
    $pdf->SetTitle('Papeleta TELCEL');          
    $pdf->SetSubject('Impresion de Papeleta');
    $pdf->SetKeywords('TCPDF, PDF, Artencel, Papeleta, AmigoKit');

    // remove default header/footer       
    $pdf->setPrintHeader(false);             
    $pdf->setPrintFooter(false);                                                             

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins                 
      //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    $pdf->SetMargins(0, 0, 0);  // Left,Top  

    //set auto page breaks                                             
    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM); // OJO... este estaba generando un salto de pagina

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //set some language-dependent strings
    $pdf->setLanguageArray($l);    

    // set font                       
    $pdf->SetFont('courier', 'B', 9);

    // add a page                              
    $pdf->AddPage();     

    //----------------   FORMATO DE LA PAPELETA (Para ubicar los Datos. Al final No se va a imprimir)-----------------------------
    // Imprimo el formato de la Papeleta, (para ver donde van los letreros)                                
//   $pdf->Image('papeleta.jpg', 5, 0, 205 , 130 , 'JPG', '', '', true, 150, '', false, false, 1, false, false, false);
    $y=0;
    // =============================  DATOS DE LA PAPELETA   =======================================
    //  ---------------------  LINEA DE LOS DATOS DEL TELEFONO
    $pdf->SetFont('courier', 'B', 10);
	$pdf->Text(150,5,$rs['Almacen']);		// IMEI

	$pdf->Text(8,35,$rs['Num_IMEI']);		// IMEI
	$pdf->Text(83,35,$rs['Num_ICCID']);		// ICCID
	$pdf->Text(170,31,$rs['Num_CEL']); 	    // NUM CEL

	$pdf->Text(183,36,substr($rs['FechaVenta'], 8, 2)."/". substr($rs['FechaVenta'], 5, 2)."/".substr($rs['FechaVenta'],0,4));  // FECHA DE ENTREGA

	$pdf->Text(38,43,$rs['Nombre_Completo']);       //  NOMBRE DEL CLIENTE 

	$pdf->Text( 34,52,$rs['Domicilio']);  
	$pdf->Text(126,52,$rs['Num_Exterior']);  
	$pdf->Text(143,52,$rs['Num_Interior']);  
	$pdf->Text(161,52,$rs['Colonia']);  

	$pdf->Text( 13,60,$rs['CP']);  
	$pdf->Text( 41,60,$rs['Estado']);  
	$pdf->Text( 84,60,$rs['Tel_Particular']);  
	$pdf->Text(152,60,$rs['Tel_Oficina']);  

    // ===========    CASE   TIPO DE IDENTIFICACION Y FOLIO
    switch ($rs['Tipo_Identificacion']) {
    case "IFE":
		  $pdf->Text(89,68,"X");  
         break;
    case "PASAPORTE":  
	      $pdf->Text(50,68,"X");  
         break;
    case "LICENCIA":
		  $pdf->Text(50,72,"X");  
         break;
    case "OTRA":
	      $pdf->Text(66,71,$rs['Otra_Identificacion']);  
         break;
    }  // ===============  FIN CASE TIPO DE IDENTIFICACION

	$pdf->Text(122,71,$rs['Numero_Identificacion']);  //  FOLIO O NUMERO DE IDENTIFICACION

	$pdf->Text(70,78,$rs['Marca_eq']);      // MARCA DEL EQUIPO
	$pdf->Text(90,78,$rs['COD_Modelo_eq']); // MODELO DEL EQUIPO 
	$pdf->Text(70,82,$rs['Acabado_eq']);    // MODELO DEL EQUIPO 
	$pdf->Text(90,82,$rs['Apodo_eq']); // MODELO DEL EQUIPO 

    $pdf->Text(110,110,$rs['Proveedor']);    // MODELO DEL EQUIPO 

//	$pdf->Text(,,);  

    // ---------------------------------------------------------
    //Close and output PDF document

    ob_start();     
    $pdf->Output('papeleta.pdf', 'I');
    ob_end_flush(); 
}    //  =========================== TERMINA LA IMPRESION DE PAPELETA EN PDF ================================================  


                  
/*****************  Imprime la NOTA DE VENTA DE UN EQUIPO (CON O SIN SIM) en un archivo PDF, utilizando la liberia TCPDF  ************************************
* 
* Recibe el registro el Id_Unico, y busca el registro y todos los datos
***************************************************************************/
function GeneraPDF_Nota_Equipo($Id_Unico) {           
   global $conn;                        

// Subimos el registro completo, ya que rsold trae unos datos(los que ya estaban) y rsnew otros (los nuevos)
 $AuxSQL= "SELECT * FROM prn_nota_venta_equipo WHERE Id_Venta_Eq =" . $Id_Unico;
 $RsAux = $conn->Execute($AuxSQL);                                                                    

 // Pasamos los campos a la variable $rs, para referenciarlos rapidamente
 $rs = $RsAux->fields;                              
  echo "Id Unico :" . $Id_Unico;                         
// exit;                         
  // ===================================  Rutina de IMPRESION EN PDF  =========================

                   
    require_once('tcpdf_php4/config/lang/eng.php');    
    require_once('tcpdf_php4/tcpdf.php');

    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                               
    // set document information            
    $pdf->SetCreator(PDF_CREATOR);                  
    $pdf->SetAuthor('Artencel');                 
    $pdf->SetTitle('Nota Venta TELCEL');          
    $pdf->SetSubject('Impresion de Nota de Venta');
    $pdf->SetKeywords('TCPDF, PDF, Artencel, Nota de Venta, Equipo Libre');
                        
    // remove default header/footer       
    $pdf->setPrintHeader(false);             
    $pdf->setPrintFooter(false);                                                             

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins                          
      //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    $pdf->SetMargins(0, 1, 0);  // OJO   ver como funciona

    //set auto page breaks                                             
    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM); //  Se supone que ya no debe generar un salto de pagina

    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //set some language-dependent strings
    $pdf->setLanguageArray($l);    

    // set font
    $pdf->SetFont('courier', 'B', 10);	
	
    // add a page                              
    $pdf->AddPage();     

    //----------------FORMATO DE LA NOTA DE VENTA (Para ubicar los Datos. Al final No se va a imprimir)-----------------------------
    // Imprimo el formato de la Nota de Venta, (para ver donde van los letreros)                                

//  $pdf->Image('notaventa.jpg', 7, 9, 195, 118, 'JPG', '', '', true, 150, '', false, false, 1, false, false, false);

    $Y=2;  //  Vamos a agregar esta variable a todos los textos, asi, podremos subirlos o bajarlos (posicion y) cambiando solo este texto
    // ============================ DATOS DE LA NOTA DE VENTA   =====================================
   
	$pdf->Text(165,$Y + 20,substr($rs['FechaVenta'], 8, 2)."/". substr($rs['FechaVenta'], 5, 2)."/".substr($rs['FechaVenta'], 0, 4));   // Linea fecha de la Nota de Venta
	$pdf->Text( 33,$Y + 10,$rs['Serie_NotaVenta']." - ".$rs['Numero_NotaVenta']);  // Linea Serie y numero de Nota de Venta

	$pdf->Text(22,$Y + 26,$rs['Nombre_Completo']);   // NOMBRE DEL CLIENTE/ RAZON SOCIAL
	$pdf->Text(22,$Y + 32,$rs['Domicilio']."  Num.  ". $rs['Num_Exterior']. "-" .$rs['Num_Interior']. "  " .$rs['Colonia']);  // Linea del DOMICILIO
	$pdf->Text(22,$Y + 39,str_pad($rs['Poblacion'].",".substr($rs['Estado'],0,3).".CP:".$rs['CP'],35)."         ".$rs['Tel_Particular']);        // Linea del PROBLACION, Numero Telefonico 
	  //  (Falta el RFC )

    //   ===================== CUERPO DE LA NOTA DE VENTA   ============================

	$pdf->Text(15,$Y + 52,"1    ");           //  Cantidad  (en esta caso siempre es 1
	$pdf->Text(28,$Y + 52,$rs['Articulo']);   //  Linea de los datos  del Telefono
	$pdf->Text(115,$Y + 52,$rs['Acabado_eq']);   //  Linea de los datos  del Telefono
	$pdf->Text(150,$Y + 52,$rs['PrecioUnitario']);   //  Linea de los datos  del Telefono
	$pdf->Text(177,$Y + 52,$rs['PrecioUnitario']);   //  Linea de los datos  del Telefono
	$pdf->Text(28,$Y + 57,"IMEI: ".$rs['Num_IMEI']);   

	//  Linea del SIM Card si es es que Lleva. Inicializamos todos los valores en Vacio, si lleva alguno lo llenamos 
    $SIM_Cant= " ";      $SIM_Let= "                 ";   $SIM_Num= " ";  $TEL_Let= "                  ";  $TEL_Num=" "; $PrecioSIM="          ";
    if (! ($rs['Num_ICCID']=="") ) {  // Si tiene SIM Card , No importa si es Amigo KIT, o Libre con CHIP, imprimimos los datos de la SIM
		$pdf->Text(15,$Y + 65,"1");  				 //  Cantidad  (en esta caso siempre es 1
		$pdf->Text(28,$Y + 65,"Num_ SIM (ICCID):".$rs['Num_ICCID']);   		
		$pdf->Text(150,$Y + 65,$rs['Precio_SIM']);   
		$pdf->Text(177,$Y + 65,$rs['Precio_SIM']);   
		$pdf->Text(28,$Y + 70,"Numero telefonico:".$rs['Num_CEL']);   
    } 

     //  Linea de Descuento si es que hay . Inicializamos sin descuento, 
    if ($rs['MontoDescuento']>0) { // Si hay Descuento, vamos a llenar los valores
	  $pdf->Text(28,$Y + 80,"Descuento:");   
	  $pdf->Text(150,$Y + 80,$rs['MontoDescuento']);   
	  $pdf->Text(177,$Y + 80,$rs['MontoDescuento']);   
    }                                                                             

    $pdf->SetFont('courier', '', 9); 
    $CantLetra = MontoEnLetra($rs['Monto']);  
	$pdf->Text(7,$Y + 110,str_pad($CantLetra,83));    // Cantidad en Letra

    $pdf->SetFont('courier', 'BI', 10);  
	$pdf->Text(175,$Y + 108.5,$rs['Monto']);        // MONTO TOTAL
//	$pdf->Text(,,);   

    ob_start();     
    $pdf->Output('nota_venta.pdf', 'I');
    ob_end_flush(); 
}    //  =========================== TERMINA LA RUTINA DE IMPRESION EN PDF DE NOTA DE VENTA ================================================                                                                           

// ==================  3 rutinas para formatear los letreros en PDF, para reportes mas elaborados  ===========================
//  Pone los parametros de pdf, para escribir un Encabezado
function conf_encabezado() {
   global $pdf;     
  $pdf->SetFillColor(100 /*, 50, 50*/); // Ponemos Fill Color GRIS OSCURO, Encabezado
  $pdf->setColor('text',255 /*, 255, 255*/); // Ponemos El texto en BLANCO
  $pdf->SetFont('courier', 'B', 10);   // Ponemos el Font Grandecito
}

//  Pone los parametros de pdf, para escribir una sección 
function conf_seccion() {
   global $pdf;     
  $pdf->SetFillColor(200 /*, 50, 50*/); // Ponemos Fill Color GRIS Claro, Seccion
  $pdf->setColor('text',0 /*, 0, 0*/); // Ponemos El texto en NEGRO
  $pdf->SetFont('courier', 'B', 9.5);   // Ponemos el Font Medioano
}


//  Pone los parametros de pdf, para escribir un dato
function conf_dato() {
   global $pdf;     
  $pdf->SetFillColor(240 /*, 50, 50*/); // Ponemos Fill Color GRIS CLARO, Datos
  $pdf->setColor('text',0 /*, 0, 0*/); // Ponemos el color del texto en NEGRO
  $pdf->SetFont('courier', '', 9);   // Ponemos el font en 9 puntos paro los datos
}
//  ===========================


/* ============================ Genera el Archivo barcode_accesorios con las etiquetas que se van a imprimir ====================================== */                                                     
function GeneraArchivoEtiquetas($Id_Compra){
    // CampoArticulo puede ser Id_Articulo_Eq  segun sea el caso.(Ver la tabla)
    global $conn;                        
     // Primero Vaciamos la Tabla
    DB_Ejecuta("TRUNCATE TABLE barcode_accesorio");                                                              
    // Seleccionamos los renglones de la compra o recepcion
    $AuxSQL= "SELECT * FROM z_crear_barcode_accesorio WHERE Id_Compra =" . $Id_Compra ."" ;
    $RsAux = $conn->Execute($AuxSQL);                                                                    
             
    while (!$RsAux->EOF) {   // Barremos los registros de detalle de la compra actual
      $Id_Compra_Det= $RsAux->fields['Id_Compra_Det'];            
      $CantRecibida = $RsAux->fields['CantRecibida'];                               
      $Articulo= $RsAux->fields['Articulo'];
      $Articulo_L1 = $Articulo;
      $Articulo_L2 = '';       
      $Articulo_L3 = '';
      $Codigo=$RsAux->fields['Codigo'];                 
                         
     // Vamos a poner el Articulo a 30 caracteras, maximo 3 renglones
      if (strlen ($Articulo_L1)>30) {  // Si el articulo mide mas de 30 caracteres             
        $Articulo_L1 = substr ($Articulo,0,30); // copiamos los primeros 30 caracteres a L1
        $ultimospc   = min(30,strrpos($Articulo_L1,' '));  // Buscamos el ultimo espacio          
        $Articulo_L1 = substr ($Articulo_L1,0,$ultimospc); // Ponemos desde el inicio hasta el ultimo espacio en L1
                                            
        $Articulo_L2 = substr ($Articulo,$ultimospc,90);   // Ponemos el RESTO en L2   
                                 
        if (strlen ($Articulo_L2)>30) {  // Si el segundo renglon mide mas de 30 caracteceres
//echo "<br> L2 =".$Articulo_L2;       
          $ultimospc   =min(30,strrpos($Articulo_L2,' '));  // Buscamos el ultimo espacio en L2
//echo " --  Ultimo espacio en L2 =".$ultimospc;          
          $Articulo_L3 =substr ($Articulo_L2,$ultimospc,90);   // Ponemos el RESTO en L3                                  
          $Articulo_L2 =substr ($Articulo_L2,0,$ultimospc); // Ponemos desde el inicio hasta el ultimo espacio en L2
        } // if               
      } // if                                  
                                                
      for ($i = 1; $i <= $CantRecibida; $i++) {                                   
          DB_Ejecuta("INSERT IGNORE INTO barcode_accesorio (Id_Compra,Id_Compra_Det,Articulo,Articulo_L1,Articulo_L2,Articulo_L3,Codigo) 
                      VALUES (" . $Id_Compra . "," . $Id_Compra_Det . ",'" . $Articulo . "','" . $Articulo_L1 . "','" . $Articulo_L2 . "','" . $Articulo_L3 . "','" . $Codigo ."')");
      } //for i                                      
      $RsAux->MoveNext(); // Nos vamos al siguiente registro de detalle de la compra actual
    } // While
//exit; //Para ver los echoes
}                                                   

                  
// Cuando insertan un ARTICULO o un ALMACEN, hay que llenar los renglones correspondientes en reg_existencias
function InsertaRenglones_RegExistencias() {
  global $conn;       
// Si insertan un Almacen o un ACCESORIO hay que crear su renglon de registro para existencias  
  $sInsertSql = "INSERT IGNORE INTO reg_existencias (Id_Almacen,Id_Articulo,Codigo,Cantidad_Actual) 
                SELECT Id_Almacen,Id_Articulo,Codigo,Cantidad from z_inserta_renglones_existencias";
  $GLOBALS["conn"]->Execute($sInsertSql);                                                                                                                
}         

                    
// Cuando se Inserta,Actualiza o Borra un renglon en CUALQUIER caso de uso referente a doc_compra_det                            
// Hay que sumar los montos de cada renglon y ponerlo como MontoTotal en el registro maestro, doc_compra.       
// Actualmente se está usando en cap_recep_equipos,cap_recep_SIM_Cards y cap_recep_accesorios   
function ActualizaMontoTotalCompra($Id_Compra) {                 
    global $conn;                 

// Actualizamos TODOS los renglones de la Nota de Compra (no solo el actual)  
  DB_Ejecuta("UPDATE doc_compra_det SET MontoTotal= Precio_Unitario*CantRecibida WHERE Id_Compra=" . $Id_Compra);
                                                                                                              
// Actualiamos el monto total de la compra o recepcion                                                   
  $MontoTotal= ew_ExecuteScalar("SELECT MontoTotal FROM z_actualiza_monto_neto_compra WHERE Id_Compra=".$Id_Compra);
  DB_Ejecuta("UPDATE doc_compra SET MontoTotal=".$MontoTotal." WHERE Id_Compra=".$Id_Compra);                                
                           
}                     

// Cuando le ponen "Recibido" a un registro de Compra (O Rececpion), hay que generar los registros
// de ENTRADAS por COMPRA y los inventarios en el ALMACEN CENTRAL.
function  RegistraEntradasXRecepcion($Id_Compra) {               
  // Agregamos a reg_existencias las cantidades de ESTA COMPRA o RECEPCION                                 
  DB_Ejecuta("UPDATE z_actualiza_existencias_por_compras SET Cantidad_MustBe=Cantidad_MustBe+Cantidad WHERE Id_Compra =" . $Id_Compra );
}                                             

                       
/* Cuando se registra como recibida una compra de Equipo o SIM, Hay que insertar un registro en "reg_unico_tel_sim"
   Por cada uno, si se reciben 10 telefonos hay que hacer un registro para cada uno, igual para los SIMs, pues  
   ahi es donde se captura el IMEI, ICCID y NUM TELEFONICO  */                                                       
function  RegistraExistEquipoSIMXRecepcion($Id_Compra,$TipoArticulo) {
    // CampoArticulo puede ser Id_Articulo_Eq  segun sea el caso.(Ver la tabla)
   global $conn;                        
                                                                  
    // Seleccionamos los renglones de la compra o recepcion
    $AuxSQL= "SELECT * FROM z_inserta_entradas_compra WHERE Id_Compra =" . $Id_Compra ."" ;
    $RsAux = $conn->Execute($AuxSQL);                                                                    
             
    while (!$RsAux->EOF) {   // Barremos los registros de detalle de la compra actual
      $CantRecibida = $RsAux->fields['CantRecibida'];                               
      $Almacen = $RsAux->fields['Id_Almacen'];
      $IdArticulo= $RsAux->fields['Id_Articulo'];            
      $IdAcabado=$RsAux->fields['Id_Acabado_eq'];     
                                                          
      for ($i = 1; $i <= $CantRecibida; $i++) {
        if ($TipoArticulo=="Equipo") 
          $InSQL = "INSERT IGNORE INTO reg_unico_tel_sim (Id_Compra,Id_Almacen,Id_Articulo,Id_Acabado_eq,TipoArticulo) 
                    VALUES (" . $Id_Compra . "," . $Almacen . "," . $IdArticulo . "," . $IdAcabado . ", '". $TipoArticulo ."')";
        else    //  SI es un SIM, no lleva ACABADO                                                                         
          $InSQL = "INSERT IGNORE INTO reg_unico_tel_sim (Id_Compra,Id_Almacen,Id_Articulo,TipoArticulo) 
                    VALUES (" . $Id_Compra . "," . $Almacen . "," . $IdArticulo . ", '" . $TipoArticulo ."')";
                                                                                     
        $GLOBALS["conn"]->Execute($InSQL);                                                                                   
// echo "<br>InSQL = $InSQL ";             
      } //for i                              
      $RsAux->MoveNext(); // Nos vamos al siguiente registro de detalle de la compra actual
    } // While    
}                                    

  
/* =================================================================================================================
 Cuando se Inserta,Actualiza o Borra un renglon en caso de uso referente a doc_venta_acc, si es Nota de Venta o Factura
 Hay que sumar los montos de cada renglon y ponerlo como MontoNeto en el registro maestro, doc_venta. */             

function ActualizaMontoTotalVenta($Id_Venta) {                 
    global $conn;                 

    // Vamos a obtener la Suma de MontoToal de todos los renglones de la Nota de Venta    
  $AuxSQL= "SELECT `MontoTotal` FROM `z_actualiza_monto_neto_venta` WHERE `Id_Venta` =" . $Id_Venta ."" ;
  $RsAux = $conn->Execute($AuxSQL);                                                                    
  $MontoTotal = $RsAux->fields['MontoTotal'];  
                                                   
    // Actualizamos El Monto Total de la Nota de Compra, con la suma de todos los renglones
  $AuxSQL = "UPDATE doc_venta SET MontoTotal= " . $MontoTotal . " WHERE Id_Venta=" . $Id_Venta ."";
  $GLOBALS["conn"]->Execute($AuxSQL);                                                       
}                    


/************************************************************************************************
*  Recibe $Id_Unico, que es el valor de Id_Tel_SIM en reg_unico_tel_sim
*  Pregunta si deses imprimir la PAPELETA en este momento.            
*  Si le das Aceptar, manda llamar aux_gen_pdf_papeletaedit.php en una nueva pestaña
*    pasandole Id_Unico comp parametro
*  aux_gen_pdfs en la rutina page_load de edit_page, manda a llamar  GeneraPDF_Papeleta                                       
*  OJO ... ESTA LA USABA PARA PRUEBAS, YA NO SE ESTA USANDO, PERO LA DEJO COMO EJEMPLO DE PREGUNTAS EN JAVA DESDE PHP     
**************************************************************************************************/
function PreguntaImprimirPapeleta($Id_Unico) {     

echo "<script type=\"text/javascript\">
       var Resp=confirm(\" SE VA A IMPRIMIR LA PAPELETA EN ESTE MOMENTO. COLOCA LAS 3 HOJAS DEL FORMATO DE LA PAPELETA EN LA IMPRESORA  \"); 
       if (Resp) {                  
         window.open(\"aux_gen_pdf_papeletaedit.php?Id_Tel_SIM=".$Id_Unico." \");
         void(0);        
       } else {       
         alert(\" PUEDES IMPRIMIR LA PAPELETA MAS TARDE, ELIGIENDO LA OPCION 'RE IMPRIMIR PAPELETA' \");
       }      
       </script>";
} 


?>
