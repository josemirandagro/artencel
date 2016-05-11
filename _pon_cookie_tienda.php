<?php
// Ponemos la Cookie para los AutoUpdate Values de Traspasos y Movimientos. Pero no como control permanente
// las cookies deben ser enviadas antes de que el script genere ninguna salida (es una restricción del protocolo)
 setcookie ("artencel_tienda", $_GET["Id_Almacen"], time () + 126144000);  // Por 4 años (60*60*24*365*4) ...  No hay manera de ponerla permante
 print "<BR> SE ESTABLECIO LA TIENDA: ". $_GET["Id_Almacen"] ;

?>

<html>

<HEAD>
 <title>EstableceTienda</title>
 <meta http-equiv="REFRESH" content="1;url=index.php">
</HEAD>
<BODY>

</BODY>

</html>