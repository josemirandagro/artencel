<?php include_once "sys_userinfo.php" ?>
<?php

// Create page object
if (!isset($cap_entrega_accesorio_det_grid)) $cap_entrega_accesorio_det_grid = new ccap_entrega_accesorio_det_grid();

// Page init
$cap_entrega_accesorio_det_grid->Page_Init();

// Page main
$cap_entrega_accesorio_det_grid->Page_Main();
?>
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_entrega_accesorio_det_grid = new ew_Page("cap_entrega_accesorio_det_grid");
cap_entrega_accesorio_det_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cap_entrega_accesorio_det_grid.PageID; // For backward compatibility

// Form object
var fcap_entrega_accesorio_detgrid = new ew_Form("fcap_entrega_accesorio_detgrid");

// Validate form
fcap_entrega_accesorio_detgrid.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var elm, aelm;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	var addcnt = 0;
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = (fobj.key_count) ? String(i) : "";
		var checkrow = (fobj.a_list && fobj.a_list.value == "gridinsert") ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Codigo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Id_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Id_Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_accesorio_det->Cantidad->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Cantidad"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_entrega_accesorio_det->Cantidad->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcap_entrega_accesorio_detgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Codigo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Articulo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad", false)) return false;
	return true;
}

// Form_CustomValidate event
fcap_entrega_accesorio_detgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_accesorio_detgrid.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_accesorio_detgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_accesorio_detgrid.Lists["x_Codigo"] = {"LinkField":"x_Codigo","Ajax":null,"AutoFill":true,"DisplayFields":["x_Codigo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_entrega_accesorio_detgrid.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":true,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cap_entrega_accesorio_det->CurrentAction == "gridadd") {
	if ($cap_entrega_accesorio_det->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cap_entrega_accesorio_det_grid->TotalRecs = $cap_entrega_accesorio_det->SelectRecordCount();
			$cap_entrega_accesorio_det_grid->Recordset = $cap_entrega_accesorio_det_grid->LoadRecordset($cap_entrega_accesorio_det_grid->StartRec-1, $cap_entrega_accesorio_det_grid->DisplayRecs);
		} else {
			if ($cap_entrega_accesorio_det_grid->Recordset = $cap_entrega_accesorio_det_grid->LoadRecordset())
				$cap_entrega_accesorio_det_grid->TotalRecs = $cap_entrega_accesorio_det_grid->Recordset->RecordCount();
		}
		$cap_entrega_accesorio_det_grid->StartRec = 1;
		$cap_entrega_accesorio_det_grid->DisplayRecs = $cap_entrega_accesorio_det_grid->TotalRecs;
	} else {
		$cap_entrega_accesorio_det->CurrentFilter = "0=1";
		$cap_entrega_accesorio_det_grid->StartRec = 1;
		$cap_entrega_accesorio_det_grid->DisplayRecs = $cap_entrega_accesorio_det->GridAddRowCount;
	}
	$cap_entrega_accesorio_det_grid->TotalRecs = $cap_entrega_accesorio_det_grid->DisplayRecs;
	$cap_entrega_accesorio_det_grid->StopRec = $cap_entrega_accesorio_det_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_entrega_accesorio_det_grid->TotalRecs = $cap_entrega_accesorio_det->SelectRecordCount();
	} else {
		if ($cap_entrega_accesorio_det_grid->Recordset = $cap_entrega_accesorio_det_grid->LoadRecordset())
			$cap_entrega_accesorio_det_grid->TotalRecs = $cap_entrega_accesorio_det_grid->Recordset->RecordCount();
	}
	$cap_entrega_accesorio_det_grid->StartRec = 1;
	$cap_entrega_accesorio_det_grid->DisplayRecs = $cap_entrega_accesorio_det_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cap_entrega_accesorio_det_grid->Recordset = $cap_entrega_accesorio_det_grid->LoadRecordset($cap_entrega_accesorio_det_grid->StartRec-1, $cap_entrega_accesorio_det_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php if ($cap_entrega_accesorio_det->CurrentMode == "add" || $cap_entrega_accesorio_det->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cap_entrega_accesorio_det->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_accesorio_det->TableCaption() ?></span></p>
</p>
<?php $cap_entrega_accesorio_det_grid->ShowPageHeader(); ?>
<?php
$cap_entrega_accesorio_det_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fcap_entrega_accesorio_detgrid" class="ewForm">
<?php if (($cap_entrega_accesorio_det->CurrentMode == "add" || $cap_entrega_accesorio_det->CurrentMode == "copy" || $cap_entrega_accesorio_det->CurrentMode == "edit") && $cap_entrega_accesorio_det->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
</div>
<?php } ?>
<div id="gmp_cap_entrega_accesorio_det" class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_accesorio_detgrid" class="ewTable ewTableSeparate">
<?php echo $cap_entrega_accesorio_det->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_entrega_accesorio_det_grid->RenderListOptions();

// Render list options (header, left)
$cap_entrega_accesorio_det_grid->ListOptions->Render("header", "left");
?>
<?php if ($cap_entrega_accesorio_det->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Codigo) == "") { ?>
		<td><span id="elh_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_accesorio_det->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_accesorio_det->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_accesorio_det->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_accesorio_det->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_accesorio_det->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_accesorio_det->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_accesorio_det->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_accesorio_det->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_accesorio_det->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_accesorio_det->Cantidad->Visible) { // Cantidad ?>
	<?php if ($cap_entrega_accesorio_det->SortUrl($cap_entrega_accesorio_det->Cantidad) == "") { ?>
		<td><span id="elh_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_accesorio_det->Cantidad->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_accesorio_det->Cantidad->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_accesorio_det->Cantidad->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_accesorio_det->Cantidad->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_entrega_accesorio_det_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cap_entrega_accesorio_det_grid->StartRec = 1;
$cap_entrega_accesorio_det_grid->StopRec = $cap_entrega_accesorio_det_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_entrega_accesorio_det->CurrentAction == "gridadd" || $cap_entrega_accesorio_det->CurrentAction == "gridedit" || $cap_entrega_accesorio_det->CurrentAction == "F")) {
		$cap_entrega_accesorio_det_grid->KeyCount = $objForm->GetValue("key_count");
		$cap_entrega_accesorio_det_grid->StopRec = $cap_entrega_accesorio_det_grid->KeyCount;
	}
}
$cap_entrega_accesorio_det_grid->RecCnt = $cap_entrega_accesorio_det_grid->StartRec - 1;
if ($cap_entrega_accesorio_det_grid->Recordset && !$cap_entrega_accesorio_det_grid->Recordset->EOF) {
	$cap_entrega_accesorio_det_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_entrega_accesorio_det_grid->StartRec > 1)
		$cap_entrega_accesorio_det_grid->Recordset->Move($cap_entrega_accesorio_det_grid->StartRec - 1);
} elseif (!$cap_entrega_accesorio_det->AllowAddDeleteRow && $cap_entrega_accesorio_det_grid->StopRec == 0) {
	$cap_entrega_accesorio_det_grid->StopRec = $cap_entrega_accesorio_det->GridAddRowCount;
}

// Initialize aggregate
$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_entrega_accesorio_det->ResetAttrs();
$cap_entrega_accesorio_det_grid->RenderRow();
if ($cap_entrega_accesorio_det->CurrentAction == "gridadd")
	$cap_entrega_accesorio_det_grid->RowIndex = 0;
if ($cap_entrega_accesorio_det->CurrentAction == "gridedit")
	$cap_entrega_accesorio_det_grid->RowIndex = 0;
while ($cap_entrega_accesorio_det_grid->RecCnt < $cap_entrega_accesorio_det_grid->StopRec) {
	$cap_entrega_accesorio_det_grid->RecCnt++;
	if (intval($cap_entrega_accesorio_det_grid->RecCnt) >= intval($cap_entrega_accesorio_det_grid->StartRec)) {
		$cap_entrega_accesorio_det_grid->RowCnt++;
		if ($cap_entrega_accesorio_det->CurrentAction == "gridadd" || $cap_entrega_accesorio_det->CurrentAction == "gridedit" || $cap_entrega_accesorio_det->CurrentAction == "F") {
			$cap_entrega_accesorio_det_grid->RowIndex++;
			$objForm->Index = $cap_entrega_accesorio_det_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_entrega_accesorio_det_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_entrega_accesorio_det->CurrentAction == "gridadd")
				$cap_entrega_accesorio_det_grid->RowAction = "insert";
			else
				$cap_entrega_accesorio_det_grid->RowAction = "";
		}

		// Set up key count
		$cap_entrega_accesorio_det_grid->KeyCount = $cap_entrega_accesorio_det_grid->RowIndex;

		// Init row class and style
		$cap_entrega_accesorio_det->ResetAttrs();
		$cap_entrega_accesorio_det->CssClass = "";
		if ($cap_entrega_accesorio_det->CurrentAction == "gridadd") {
			if ($cap_entrega_accesorio_det->CurrentMode == "copy") {
				$cap_entrega_accesorio_det_grid->LoadRowValues($cap_entrega_accesorio_det_grid->Recordset); // Load row values
				$cap_entrega_accesorio_det_grid->SetRecordKey($cap_entrega_accesorio_det_grid->RowOldKey, $cap_entrega_accesorio_det_grid->Recordset); // Set old record key
			} else {
				$cap_entrega_accesorio_det_grid->LoadDefaultValues(); // Load default values
				$cap_entrega_accesorio_det_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($cap_entrega_accesorio_det->CurrentAction == "gridedit") {
			$cap_entrega_accesorio_det_grid->LoadRowValues($cap_entrega_accesorio_det_grid->Recordset); // Load row values
		}
		$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_entrega_accesorio_det->CurrentAction == "gridadd") // Grid add
			$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cap_entrega_accesorio_det->CurrentAction == "gridadd" && $cap_entrega_accesorio_det->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cap_entrega_accesorio_det_grid->RestoreCurrentRowFormValues($cap_entrega_accesorio_det_grid->RowIndex); // Restore form values
		if ($cap_entrega_accesorio_det->CurrentAction == "gridedit") { // Grid edit
			if ($cap_entrega_accesorio_det->EventCancelled) {
				$cap_entrega_accesorio_det_grid->RestoreCurrentRowFormValues($cap_entrega_accesorio_det_grid->RowIndex); // Restore form values
			}
			if ($cap_entrega_accesorio_det_grid->RowAction == "insert")
				$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_entrega_accesorio_det->CurrentAction == "gridedit" && ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT || $cap_entrega_accesorio_det->RowType == EW_ROWTYPE_ADD) && $cap_entrega_accesorio_det->EventCancelled) // Update failed
			$cap_entrega_accesorio_det_grid->RestoreCurrentRowFormValues($cap_entrega_accesorio_det_grid->RowIndex); // Restore form values
		if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_entrega_accesorio_det_grid->EditRowCnt++;
		if ($cap_entrega_accesorio_det->CurrentAction == "F") // Confirm row
			$cap_entrega_accesorio_det_grid->RestoreCurrentRowFormValues($cap_entrega_accesorio_det_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cap_entrega_accesorio_det->RowAttrs = array_merge($cap_entrega_accesorio_det->RowAttrs, array('data-rowindex'=>$cap_entrega_accesorio_det_grid->RowCnt, 'id'=>'r' . $cap_entrega_accesorio_det_grid->RowCnt . '_cap_entrega_accesorio_det', 'data-rowtype'=>$cap_entrega_accesorio_det->RowType));

		// Render row
		$cap_entrega_accesorio_det_grid->RenderRow();

		// Render list options
		$cap_entrega_accesorio_det_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_entrega_accesorio_det_grid->RowAction <> "delete" && $cap_entrega_accesorio_det_grid->RowAction <> "insertdelete" && !($cap_entrega_accesorio_det_grid->RowAction == "insert" && $cap_entrega_accesorio_det->CurrentAction == "F" && $cap_entrega_accesorio_det_grid->EmptyRow())) {
?>
	<tr<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_entrega_accesorio_det_grid->ListOptions->Render("body", "left", $cap_entrega_accesorio_det_grid->RowCnt);
?>
	<?php if ($cap_entrega_accesorio_det->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_entrega_accesorio_det->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_entrega_accesorio_det_grid->RowCnt ?>_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo">
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo"<?php echo $cap_entrega_accesorio_det->Codigo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Codigo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Codigo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_accesorio_det->Codigo->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_entrega_accesorio_detgrid.Lists["x_Codigo"].Options = <?php echo (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) ? ew_ArrayToJson($cap_entrega_accesorio_det->Codigo->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Id_Articulo` AS FIELD0 FROM `aux_sel_accesorios`";
 $sWhereWrk = "(`Codigo` = '{query_value}')";
 $lookuptblfilter = "TipoArticulo='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Codigo->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo"<?php echo $cap_entrega_accesorio_det->Codigo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Codigo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Codigo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_accesorio_det->Codigo->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_entrega_accesorio_detgrid.Lists["x_Codigo"].Options = <?php echo (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) ? ew_ArrayToJson($cap_entrega_accesorio_det->Codigo->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Id_Articulo` AS FIELD0 FROM `aux_sel_accesorios`";
 $sWhereWrk = "(`Codigo` = '{query_value}')";
 $lookuptblfilter = "TipoArticulo='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_accesorio_det->Codigo->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Codigo->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Codigo->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Codigo->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_entrega_accesorio_det_grid->PageObjName . "_row_" . $cap_entrega_accesorio_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Traspaso_Det" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Traspaso_Det->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Traspaso_Det" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Traspaso_Det->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT || $cap_entrega_accesorio_det->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Traspaso_Det" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Traspaso_Det->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_entrega_accesorio_det->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_entrega_accesorio_det_grid->RowCnt ?>_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo">
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_entrega_accesorio_det->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Id_Articulo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_accesorio_det->Id_Articulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
 $sWhereWrk = "";
 $lookuptblfilter = "`TipoArticulo`='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_accesorio_det->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php
 $sSqlWrk = "SELECT `Codigo` AS FIELD0 FROM `ca_articulos`";
 $sWhereWrk = "(`Id_Articulo` = {query_value})";
 $lookuptblfilter = "`TipoArticulo`='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_entrega_accesorio_det->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Id_Articulo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_accesorio_det->Id_Articulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
 $sWhereWrk = "";
 $lookuptblfilter = "`TipoArticulo`='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_accesorio_det->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php
 $sSqlWrk = "SELECT `Codigo` AS FIELD0 FROM `ca_articulos`";
 $sWhereWrk = "(`Id_Articulo` = {query_value})";
 $lookuptblfilter = "`TipoArticulo`='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_accesorio_det->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Id_Articulo->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Articulo->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Articulo->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_entrega_accesorio_det_grid->PageObjName . "_row_" . $cap_entrega_accesorio_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Cantidad->Visible) { // Cantidad ?>
		<td<?php echo $cap_entrega_accesorio_det->Cantidad->CellAttributes() ?>><span id="el<?php echo $cap_entrega_accesorio_det_grid->RowCnt ?>_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad">
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" size="12" value="<?php echo $cap_entrega_accesorio_det->Cantidad->EditValue ?>"<?php echo $cap_entrega_accesorio_det->Cantidad->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Cantidad->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" size="12" value="<?php echo $cap_entrega_accesorio_det->Cantidad->EditValue ?>"<?php echo $cap_entrega_accesorio_det->Cantidad->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_accesorio_det->Cantidad->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Cantidad->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Cantidad->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Cantidad->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_entrega_accesorio_det_grid->PageObjName . "_row_" . $cap_entrega_accesorio_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_entrega_accesorio_det_grid->ListOptions->Render("body", "right", $cap_entrega_accesorio_det_grid->RowCnt);
?>
	</tr>
<?php if ($cap_entrega_accesorio_det->RowType == EW_ROWTYPE_ADD || $cap_entrega_accesorio_det->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_entrega_accesorio_detgrid.UpdateOpts(<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_entrega_accesorio_det->CurrentAction <> "gridadd" || $cap_entrega_accesorio_det->CurrentMode == "copy")
		if (!$cap_entrega_accesorio_det_grid->Recordset->EOF) $cap_entrega_accesorio_det_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cap_entrega_accesorio_det->CurrentMode == "add" || $cap_entrega_accesorio_det->CurrentMode == "copy" || $cap_entrega_accesorio_det->CurrentMode == "edit") {
		$cap_entrega_accesorio_det_grid->RowIndex = '$rowindex$';
		$cap_entrega_accesorio_det_grid->LoadDefaultValues();

		// Set row properties
		$cap_entrega_accesorio_det->ResetAttrs();
		$cap_entrega_accesorio_det->RowAttrs = array_merge($cap_entrega_accesorio_det->RowAttrs, array('data-rowindex'=>$cap_entrega_accesorio_det_grid->RowIndex, 'id'=>'r0_cap_entrega_accesorio_det', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_entrega_accesorio_det->RowAttrs["class"], "ewTemplate");
		$cap_entrega_accesorio_det->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_entrega_accesorio_det_grid->RenderRow();

		// Render list options
		$cap_entrega_accesorio_det_grid->RenderListOptions();
		$cap_entrega_accesorio_det_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cap_entrega_accesorio_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_entrega_accesorio_det_grid->ListOptions->Render("body", "left", $cap_entrega_accesorio_det_grid->RowIndex);
?>
	<?php if ($cap_entrega_accesorio_det->Codigo->Visible) { // Codigo ?>
		<td><span id="el$rowindex$_cap_entrega_accesorio_det_Codigo" class="cap_entrega_accesorio_det_Codigo">
<?php if ($cap_entrega_accesorio_det->CurrentAction <> "F") { ?>
<?php $cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Codigo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo"<?php echo $cap_entrega_accesorio_det->Codigo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Codigo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Codigo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_accesorio_det->Codigo->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_entrega_accesorio_detgrid.Lists["x_Codigo"].Options = <?php echo (is_array($cap_entrega_accesorio_det->Codigo->EditValue)) ? ew_ArrayToJson($cap_entrega_accesorio_det->Codigo->EditValue, 1) : "[]" ?>;
</script>
<?php
 $sSqlWrk = "SELECT `Id_Articulo` AS FIELD0 FROM `aux_sel_accesorios`";
 $sWhereWrk = "(`Codigo` = '{query_value}')";
 $lookuptblfilter = "TipoArticulo='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo">
<?php } else { ?>
<span<?php echo $cap_entrega_accesorio_det->Codigo->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Codigo->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Codigo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el$rowindex$_cap_entrega_accesorio_det_Id_Articulo" class="cap_entrega_accesorio_det_Id_Articulo">
<?php if ($cap_entrega_accesorio_det->CurrentAction <> "F") { ?>
<?php $cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_accesorio_det->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_entrega_accesorio_det->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_accesorio_det->Id_Articulo->EditValue)) {
	$arwrk = $cap_entrega_accesorio_det->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_accesorio_det->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_accesorio_det->Id_Articulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
 $sWhereWrk = "";
 $lookuptblfilter = "`TipoArticulo`='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_accesorio_det->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3">
<?php
 $sSqlWrk = "SELECT `Codigo` AS FIELD0 FROM `ca_articulos`";
 $sWhereWrk = "(`Id_Articulo` = {query_value})";
 $lookuptblfilter = "`TipoArticulo`='Accesorio'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Codigo">
<?php } else { ?>
<span<?php echo $cap_entrega_accesorio_det->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Id_Articulo->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Articulo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_entrega_accesorio_det->Cantidad->Visible) { // Cantidad ?>
		<td><span id="el$rowindex$_cap_entrega_accesorio_det_Cantidad" class="cap_entrega_accesorio_det_Cantidad">
<?php if ($cap_entrega_accesorio_det->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" size="12" value="<?php echo $cap_entrega_accesorio_det->Cantidad->EditValue ?>"<?php echo $cap_entrega_accesorio_det->Cantidad->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_entrega_accesorio_det->Cantidad->ViewAttributes() ?>>
<?php echo $cap_entrega_accesorio_det->Cantidad->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="x<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Cantidad->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" id="o<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>_Cantidad" value="<?php echo ew_HtmlEncode($cap_entrega_accesorio_det->Cantidad->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_entrega_accesorio_det_grid->ListOptions->Render("body", "right", $cap_entrega_accesorio_det_grid->RowCnt);
?>
<script type="text/javascript">
fcap_entrega_accesorio_detgrid.UpdateOpts(<?php echo $cap_entrega_accesorio_det_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cap_entrega_accesorio_det->CurrentMode == "add" || $cap_entrega_accesorio_det->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_entrega_accesorio_det_grid->KeyCount ?>">
<?php echo $cap_entrega_accesorio_det_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_entrega_accesorio_det_grid->KeyCount ?>">
<?php echo $cap_entrega_accesorio_det_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_entrega_accesorio_det->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fcap_entrega_accesorio_detgrid">
</div>
<?php

// Close recordset
if ($cap_entrega_accesorio_det_grid->Recordset)
	$cap_entrega_accesorio_det_grid->Recordset->Close();
?>
<?php if (($cap_entrega_accesorio_det->CurrentMode == "add" || $cap_entrega_accesorio_det->CurrentMode == "copy" || $cap_entrega_accesorio_det->CurrentMode == "edit") && $cap_entrega_accesorio_det->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($cap_entrega_accesorio_det->Export == "") { ?>
<script type="text/javascript">
fcap_entrega_accesorio_detgrid.Init();
</script>
<?php } ?>
<?php
$cap_entrega_accesorio_det_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cap_entrega_accesorio_det_grid->Page_Terminate();
$Page = &$MasterPage;
?>
