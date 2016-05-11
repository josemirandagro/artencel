<?php

// Id_Compra
// Id_Proveedor
// FechaEntrega
// MontoTotal

?>
<?php if ($cap_recep_accesorio->Visible) { ?>
<table cellspacing="0" id="t_cap_recep_accesorio" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_recep_accesoriomaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($cap_recep_accesorio->Id_Compra->Visible) { // Id_Compra ?>
		<tr id="r_Id_Compra">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio->Id_Compra->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_recep_accesorio->Id_Compra->CellAttributes() ?>><span id="el_cap_recep_accesorio_Id_Compra">
<span<?php echo $cap_recep_accesorio->Id_Compra->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio->Id_Compra->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_recep_accesorio->Id_Proveedor->Visible) { // Id_Proveedor ?>
		<tr id="r_Id_Proveedor">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio->Id_Proveedor->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_recep_accesorio->Id_Proveedor->CellAttributes() ?>><span id="el_cap_recep_accesorio_Id_Proveedor">
<span<?php echo $cap_recep_accesorio->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio->Id_Proveedor->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_recep_accesorio->FechaEntrega->Visible) { // FechaEntrega ?>
		<tr id="r_FechaEntrega">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio->FechaEntrega->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_recep_accesorio->FechaEntrega->CellAttributes() ?>><span id="el_cap_recep_accesorio_FechaEntrega">
<span<?php echo $cap_recep_accesorio->FechaEntrega->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio->FechaEntrega->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_recep_accesorio->MontoTotal->Visible) { // MontoTotal ?>
		<tr id="r_MontoTotal">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio->MontoTotal->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_recep_accesorio->MontoTotal->CellAttributes() ?>><span id="el_cap_recep_accesorio_MontoTotal">
<span<?php echo $cap_recep_accesorio->MontoTotal->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio->MontoTotal->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
