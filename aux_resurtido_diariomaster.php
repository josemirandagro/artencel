<?php

// Id_Almacen
// Id_Articulo
// Id_Acabado_eq
// Id_Tel_SIM
// Fecha
// Disponibles
// Num_IMEI

?>
<?php if ($aux_resurtido_diario->Visible) { ?>
<table cellspacing="0" id="t_aux_resurtido_diario" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_aux_resurtido_diariomaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($aux_resurtido_diario->Id_Almacen->Visible) { // Id_Almacen ?>
		<tr id="r_Id_Almacen">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Id_Almacen->FldCaption() ?></td></tr></table></td>
			<td<?php echo $aux_resurtido_diario->Id_Almacen->CellAttributes() ?>><span id="el_aux_resurtido_diario_Id_Almacen">
<span<?php echo $aux_resurtido_diario->Id_Almacen->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Almacen->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Id_Articulo->Visible) { // Id_Articulo ?>
		<tr id="r_Id_Articulo">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Id_Articulo->FldCaption() ?></td></tr></table></td>
			<td<?php echo $aux_resurtido_diario->Id_Articulo->CellAttributes() ?>><span id="el_aux_resurtido_diario_Id_Articulo">
<span<?php echo $aux_resurtido_diario->Id_Articulo->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Articulo->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<tr id="r_Id_Acabado_eq">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Id_Acabado_eq->FldCaption() ?></td></tr></table></td>
			<td<?php echo $aux_resurtido_diario->Id_Acabado_eq->CellAttributes() ?>><span id="el_aux_resurtido_diario_Id_Acabado_eq">
<span<?php echo $aux_resurtido_diario->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Acabado_eq->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<tr id="r_Id_Tel_SIM">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Id_Tel_SIM->FldCaption() ?></td></tr></table></td>
			<td<?php echo $aux_resurtido_diario->Id_Tel_SIM->CellAttributes() ?>><span id="el_aux_resurtido_diario_Id_Tel_SIM">
<span<?php echo $aux_resurtido_diario->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Id_Tel_SIM->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Fecha->Visible) { // Fecha ?>
		<tr id="r_Fecha">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Fecha->FldCaption() ?></td></tr></table></td>
			<td<?php echo $aux_resurtido_diario->Fecha->CellAttributes() ?>><span id="el_aux_resurtido_diario_Fecha">
<span<?php echo $aux_resurtido_diario->Fecha->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Fecha->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Disponibles->Visible) { // Disponibles ?>
		<tr id="r_Disponibles">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Disponibles->FldCaption() ?></td></tr></table></td>
			<td<?php echo $aux_resurtido_diario->Disponibles->CellAttributes() ?>><span id="el_aux_resurtido_diario_Disponibles">
<span<?php echo $aux_resurtido_diario->Disponibles->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Disponibles->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($aux_resurtido_diario->Num_IMEI->Visible) { // Num_IMEI ?>
		<tr id="r_Num_IMEI">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $aux_resurtido_diario->Num_IMEI->FldCaption() ?></td></tr></table></td>
			<td<?php echo $aux_resurtido_diario->Num_IMEI->CellAttributes() ?>><span id="el_aux_resurtido_diario_Num_IMEI">
<span<?php echo $aux_resurtido_diario->Num_IMEI->ViewAttributes() ?>>
<?php echo $aux_resurtido_diario->Num_IMEI->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
