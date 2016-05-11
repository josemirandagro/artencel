<?php

// COD_Marca_eq
// Articulo
// Codigo

?>
<?php if ($cap_asigna_acabados_equipo->Visible) { ?>
<table cellspacing="0" id="t_cap_asigna_acabados_equipo" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_asigna_acabados_equipomaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($cap_asigna_acabados_equipo->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
		<tr id="r_COD_Marca_eq">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->CellAttributes() ?>><span id="el_cap_asigna_acabados_equipo_COD_Marca_eq">
<span<?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo->COD_Marca_eq->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo->Articulo->Visible) { // Articulo ?>
		<tr id="r_Articulo">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_asigna_acabados_equipo->Articulo->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_asigna_acabados_equipo->Articulo->CellAttributes() ?>><span id="el_cap_asigna_acabados_equipo_Articulo">
<span<?php echo $cap_asigna_acabados_equipo->Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo->Articulo->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo->Codigo->Visible) { // Codigo ?>
		<tr id="r_Codigo">
			<td class="ewTableHeader"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_asigna_acabados_equipo->Codigo->FldCaption() ?></td></tr></table></td>
			<td<?php echo $cap_asigna_acabados_equipo->Codigo->CellAttributes() ?>><span id="el_cap_asigna_acabados_equipo_Codigo">
<span<?php echo $cap_asigna_acabados_equipo->Codigo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo->Codigo->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
