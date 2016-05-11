<?php

// Id_Almacen
// Id_Articulo
// Num_ICCID

?>
<?php if ($cap_inventario_simcards->Visible) { ?>
<table cellspacing="0" id="t_cap_inventario_simcards" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_inventario_simcardsmaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($cap_inventario_simcards->Id_Almacen->Visible) { // Id_Almacen ?>
		<tr id="r_Id_Almacen">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_simcards->Id_Almacen->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_simcards->Id_Almacen->CellAttributes() ?>><span id="el_cap_inventario_simcards_Id_Almacen">
<span<?php echo $cap_inventario_simcards->Id_Almacen->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards->Id_Almacen->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_simcards->Id_Articulo->Visible) { // Id_Articulo ?>
		<tr id="r_Id_Articulo">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_simcards->Id_Articulo->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_simcards->Id_Articulo->CellAttributes() ?>><span id="el_cap_inventario_simcards_Id_Articulo">
<span<?php echo $cap_inventario_simcards->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards->Id_Articulo->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_inventario_simcards->Num_ICCID->Visible) { // Num_ICCID ?>
		<tr id="r_Num_ICCID">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_simcards->Num_ICCID->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_inventario_simcards->Num_ICCID->CellAttributes() ?>><span id="el_cap_inventario_simcards_Num_ICCID">
<span<?php echo $cap_inventario_simcards->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards->Num_ICCID->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
