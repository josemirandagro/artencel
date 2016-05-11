<?php

// Id_Almacen
// COD_Marca_eq
// COD_Modelo_eq
// Id_Articulo
// Codigo
// Cantidad_Actual
// Cantidad_MustBe
// Cantidad_Minima
// Cantidad_Maxima

?>
<?php if ($cap_inventario_equipos->Visible) { ?>
<table cellspacing="0" id="t_cap_inventario_equipos" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_inventario_equiposmaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($cap_inventario_equipos->Id_Almacen->Visible) { // Id_Almacen ?>
		<tr id="r_Id_Almacen">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->Id_Almacen->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->Id_Almacen->CellAttributes() ?>><span id="el_cap_inventario_equipos_Id_Almacen">
<span<?php echo $cap_inventario_equipos->Id_Almacen->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->Id_Almacen->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
		<tr id="r_COD_Marca_eq">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->COD_Marca_eq->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->COD_Marca_eq->CellAttributes() ?>><span id="el_cap_inventario_equipos_COD_Marca_eq">
<span<?php echo $cap_inventario_equipos->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->COD_Marca_eq->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
		<tr id="r_COD_Modelo_eq">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->COD_Modelo_eq->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->COD_Modelo_eq->CellAttributes() ?>><span id="el_cap_inventario_equipos_COD_Modelo_eq">
<span<?php echo $cap_inventario_equipos->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->COD_Modelo_eq->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->Id_Articulo->Visible) { // Id_Articulo ?>
		<tr id="r_Id_Articulo">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->Id_Articulo->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->Id_Articulo->CellAttributes() ?>><span id="el_cap_inventario_equipos_Id_Articulo">
<span<?php echo $cap_inventario_equipos->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->Id_Articulo->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->Codigo->Visible) { // Codigo ?>
		<tr id="r_Codigo">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->Codigo->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->Codigo->CellAttributes() ?>><span id="el_cap_inventario_equipos_Codigo">
<span<?php echo $cap_inventario_equipos->Codigo->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->Codigo->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->Cantidad_Actual->Visible) { // Cantidad_Actual ?>
		<tr id="r_Cantidad_Actual">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->Cantidad_Actual->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->Cantidad_Actual->CellAttributes() ?>><span id="el_cap_inventario_equipos_Cantidad_Actual">
<span<?php echo $cap_inventario_equipos->Cantidad_Actual->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->Cantidad_Actual->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->Cantidad_MustBe->Visible) { // Cantidad_MustBe ?>
		<tr id="r_Cantidad_MustBe">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->Cantidad_MustBe->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->Cantidad_MustBe->CellAttributes() ?>><span id="el_cap_inventario_equipos_Cantidad_MustBe">
<span<?php echo $cap_inventario_equipos->Cantidad_MustBe->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->Cantidad_MustBe->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->Cantidad_Minima->Visible) { // Cantidad_Minima ?>
		<tr id="r_Cantidad_Minima">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->Cantidad_Minima->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->Cantidad_Minima->CellAttributes() ?>><span id="el_cap_inventario_equipos_Cantidad_Minima">
<span<?php echo $cap_inventario_equipos->Cantidad_Minima->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->Cantidad_Minima->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_equipos->Cantidad_Maxima->Visible) { // Cantidad_Maxima ?>
		<tr id="r_Cantidad_Maxima">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_equipos->Cantidad_Maxima->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_equipos->Cantidad_Maxima->CellAttributes() ?>><span id="el_cap_inventario_equipos_Cantidad_Maxima">
<span<?php echo $cap_inventario_equipos->Cantidad_Maxima->ViewAttributes() ?>>
<?php echo $cap_inventario_equipos->Cantidad_Maxima->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
