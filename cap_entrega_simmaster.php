<?php

// Id_Traspaso
// Id_Almacen_Entrega
// Id_Almacen_Recibe
// Fecha
// Hora
// Status
// Id_Empleado_Entrega

?>
<?php if ($cap_entrega_sim->Visible) { ?>
<table cellspacing="0" id="t_cap_entrega_sim" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_simmaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($cap_entrega_sim->Id_Traspaso->Visible) { // Id_Traspaso ?>
		<tr id="r_Id_Traspaso">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_sim->Id_Traspaso->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_sim->Id_Traspaso->CellAttributes() ?>><span id="el_cap_entrega_sim_Id_Traspaso">
<span<?php echo $cap_entrega_sim->Id_Traspaso->ViewAttributes() ?>>
<?php echo $cap_entrega_sim->Id_Traspaso->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_sim->Id_Almacen_Entrega->Visible) { // Id_Almacen_Entrega ?>
		<tr id="r_Id_Almacen_Entrega">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_sim->Id_Almacen_Entrega->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_sim->Id_Almacen_Entrega->CellAttributes() ?>><span id="el_cap_entrega_sim_Id_Almacen_Entrega">
<span<?php echo $cap_entrega_sim->Id_Almacen_Entrega->ViewAttributes() ?>>
<?php echo $cap_entrega_sim->Id_Almacen_Entrega->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_sim->Id_Almacen_Recibe->Visible) { // Id_Almacen_Recibe ?>
		<tr id="r_Id_Almacen_Recibe">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_sim->Id_Almacen_Recibe->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_sim->Id_Almacen_Recibe->CellAttributes() ?>><span id="el_cap_entrega_sim_Id_Almacen_Recibe">
<span<?php echo $cap_entrega_sim->Id_Almacen_Recibe->ViewAttributes() ?>>
<?php echo $cap_entrega_sim->Id_Almacen_Recibe->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_sim->Fecha->Visible) { // Fecha ?>
		<tr id="r_Fecha">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_sim->Fecha->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_sim->Fecha->CellAttributes() ?>><span id="el_cap_entrega_sim_Fecha">
<span<?php echo $cap_entrega_sim->Fecha->ViewAttributes() ?>>
<?php echo $cap_entrega_sim->Fecha->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_sim->Hora->Visible) { // Hora ?>
		<tr id="r_Hora">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_sim->Hora->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_sim->Hora->CellAttributes() ?>><span id="el_cap_entrega_sim_Hora">
<span<?php echo $cap_entrega_sim->Hora->ViewAttributes() ?>>
<?php echo $cap_entrega_sim->Hora->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_sim->Status->Visible) { // Status ?>
		<tr id="r_Status">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_sim->Status->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_sim->Status->CellAttributes() ?>><span id="el_cap_entrega_sim_Status">
<span<?php echo $cap_entrega_sim->Status->ViewAttributes() ?>>
<?php echo $cap_entrega_sim->Status->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_entrega_sim->Id_Empleado_Entrega->Visible) { // Id_Empleado_Entrega ?>
		<tr id="r_Id_Empleado_Entrega">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_sim->Id_Empleado_Entrega->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_entrega_sim->Id_Empleado_Entrega->CellAttributes() ?>><span id="el_cap_entrega_sim_Id_Empleado_Entrega">
<span<?php echo $cap_entrega_sim->Id_Empleado_Entrega->ViewAttributes() ?>>
<?php echo $cap_entrega_sim->Id_Empleado_Entrega->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
