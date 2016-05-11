<?php

// Id_Compra
// Id_Proveedor
// FechaEntrega
// Status_Recepcion

?>
<?php if ($cap_gen_barcode_accesorios->Visible) { ?>
<table cellspacing="0" id="t_cap_gen_barcode_accesorios" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_gen_barcode_accesoriosmaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($cap_gen_barcode_accesorios->Id_Compra->Visible) { // Id_Compra ?>
		<tr id="r_Id_Compra">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->Id_Compra->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_gen_barcode_accesorios->Id_Compra->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_Id_Compra">
<span<?php echo $cap_gen_barcode_accesorios->Id_Compra->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Id_Compra->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios->Id_Proveedor->Visible) { // Id_Proveedor ?>
		<tr id="r_Id_Proveedor">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->Id_Proveedor->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_Id_Proveedor">
<span<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios->FechaEntrega->Visible) { // FechaEntrega ?>
		<tr id="r_FechaEntrega">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->FechaEntrega->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_gen_barcode_accesorios->FechaEntrega->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_FechaEntrega">
<span<?php echo $cap_gen_barcode_accesorios->FechaEntrega->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->FechaEntrega->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios->Status_Recepcion->Visible) { // Status_Recepcion ?>
		<tr id="r_Status_Recepcion">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->Status_Recepcion->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_Status_Recepcion">
<span<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
