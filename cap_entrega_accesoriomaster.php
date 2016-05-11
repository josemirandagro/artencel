<?php

// Id_Traspaso
// Id_Almacen_Entrega
// Id_Almacen_Recibe
// Fecha
// Hora
// Status

?>
<?php if ($cap_entrega_accesorio->Visible) { ?>
<table cellspacing="0" id="t_cap_entrega_accesorio" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_accesoriomaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($cap_entrega_accesorio->Id_Traspaso->Visible) { // Id_Traspaso ?>
		<tr id="r_Id_Traspaso">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio->Id_Traspaso->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_accesorio->Id_Traspaso->CellAttributes() ?>><span id="el_cap_entrega_accesorio_Id_Traspaso">
<span<?php echo $cap_entrega_accesorio->Id_Traspaso->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio->Id_Traspaso->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio->Id_Almacen_Entrega->Visible) { // Id_Almacen_Entrega ?>
		<tr id="r_Id_Almacen_Entrega">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio->Id_Almacen_Entrega->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_accesorio->Id_Almacen_Entrega->CellAttributes() ?>><span id="el_cap_entrega_accesorio_Id_Almacen_Entrega">
<span<?php echo $cap_entrega_accesorio->Id_Almacen_Entrega->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio->Id_Almacen_Entrega->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio->Id_Almacen_Recibe->Visible) { // Id_Almacen_Recibe ?>
		<tr id="r_Id_Almacen_Recibe">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio->Id_Almacen_Recibe->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_accesorio->Id_Almacen_Recibe->CellAttributes() ?>><span id="el_cap_entrega_accesorio_Id_Almacen_Recibe">
<span<?php echo $cap_entrega_accesorio->Id_Almacen_Recibe->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio->Id_Almacen_Recibe->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio->Fecha->Visible) { // Fecha ?>
		<tr id="r_Fecha">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio->Fecha->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_accesorio->Fecha->CellAttributes() ?>><span id="el_cap_entrega_accesorio_Fecha">
<span<?php echo $cap_entrega_accesorio->Fecha->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio->Fecha->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio->Hora->Visible) { // Hora ?>
		<tr id="r_Hora">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio->Hora->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_accesorio->Hora->CellAttributes() ?>><span id="el_cap_entrega_accesorio_Hora">
<span<?php echo $cap_entrega_accesorio->Hora->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio->Hora->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_accesorio->Status->Visible) { // Status ?>
		<tr id="r_Status">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_accesorio->Status->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_accesorio->Status->CellAttributes() ?>><span id="el_cap_entrega_accesorio_Status">
<span<?php echo $cap_entrega_accesorio->Status->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio->Status->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
