<?php include_once "sys_userinfo.php" ?>
<?php

// Create page object
if (!isset($cap_entrega_equipo_det_grid)) $cap_entrega_equipo_det_grid = new ccap_entrega_equipo_det_grid();

// Page init
$cap_entrega_equipo_det_grid->Page_Init();

// Page main
$cap_entrega_equipo_det_grid->Page_Main();
?>
<?php if ($cap_entrega_equipo_det->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_entrega_equipo_det_grid = new ew_Page("cap_entrega_equipo_det_grid");
cap_entrega_equipo_det_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cap_entrega_equipo_det_grid.PageID; // For backward compatibility

// Form object
var fcap_entrega_equipo_detgrid = new ew_Form("fcap_entrega_equipo_detgrid");

// Validate form
fcap_entrega_equipo_detgrid.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Tel_SIM"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_entrega_equipo_det->Id_Tel_SIM->FldCaption()) ?>");

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
fcap_entrega_equipo_detgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Num_IMEI", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tel_SIM", false)) return false;
	return true;
}

// Form_CustomValidate event
fcap_entrega_equipo_detgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_equipo_detgrid.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_equipo_detgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_equipo_detgrid.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":true,"AutoFill":true,"DisplayFields":["x_EquipoAcabado","x_Num_IMEI","x_Status","x_Num_ICCID"],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cap_entrega_equipo_det->CurrentAction == "gridadd") {
	if ($cap_entrega_equipo_det->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cap_entrega_equipo_det_grid->TotalRecs = $cap_entrega_equipo_det->SelectRecordCount();
			$cap_entrega_equipo_det_grid->Recordset = $cap_entrega_equipo_det_grid->LoadRecordset($cap_entrega_equipo_det_grid->StartRec-1, $cap_entrega_equipo_det_grid->DisplayRecs);
		} else {
			if ($cap_entrega_equipo_det_grid->Recordset = $cap_entrega_equipo_det_grid->LoadRecordset())
				$cap_entrega_equipo_det_grid->TotalRecs = $cap_entrega_equipo_det_grid->Recordset->RecordCount();
		}
		$cap_entrega_equipo_det_grid->StartRec = 1;
		$cap_entrega_equipo_det_grid->DisplayRecs = $cap_entrega_equipo_det_grid->TotalRecs;
	} else {
		$cap_entrega_equipo_det->CurrentFilter = "0=1";
		$cap_entrega_equipo_det_grid->StartRec = 1;
		$cap_entrega_equipo_det_grid->DisplayRecs = $cap_entrega_equipo_det->GridAddRowCount;
	}
	$cap_entrega_equipo_det_grid->TotalRecs = $cap_entrega_equipo_det_grid->DisplayRecs;
	$cap_entrega_equipo_det_grid->StopRec = $cap_entrega_equipo_det_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_entrega_equipo_det_grid->TotalRecs = $cap_entrega_equipo_det->SelectRecordCount();
	} else {
		if ($cap_entrega_equipo_det_grid->Recordset = $cap_entrega_equipo_det_grid->LoadRecordset())
			$cap_entrega_equipo_det_grid->TotalRecs = $cap_entrega_equipo_det_grid->Recordset->RecordCount();
	}
	$cap_entrega_equipo_det_grid->StartRec = 1;
	$cap_entrega_equipo_det_grid->DisplayRecs = $cap_entrega_equipo_det_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cap_entrega_equipo_det_grid->Recordset = $cap_entrega_equipo_det_grid->LoadRecordset($cap_entrega_equipo_det_grid->StartRec-1, $cap_entrega_equipo_det_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php if ($cap_entrega_equipo_det->CurrentMode == "add" || $cap_entrega_equipo_det->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cap_entrega_equipo_det->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_equipo_det->TableCaption() ?></span></p>
</p>
<?php $cap_entrega_equipo_det_grid->ShowPageHeader(); ?>
<?php
$cap_entrega_equipo_det_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fcap_entrega_equipo_detgrid" class="ewForm">
<?php if (($cap_entrega_equipo_det->CurrentMode == "add" || $cap_entrega_equipo_det->CurrentMode == "copy" || $cap_entrega_equipo_det->CurrentMode == "edit") && $cap_entrega_equipo_det->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
</div>
<?php } ?>
<div id="gmp_cap_entrega_equipo_det" class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_equipo_detgrid" class="ewTable ewTableSeparate">
<?php echo $cap_entrega_equipo_det->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_entrega_equipo_det_grid->RenderListOptions();

// Render list options (header, left)
$cap_entrega_equipo_det_grid->ListOptions->Render("header", "left");
?>
<?php if ($cap_entrega_equipo_det->Num_IMEI->Visible) { // Num_IMEI ?>
	<?php if ($cap_entrega_equipo_det->SortUrl($cap_entrega_equipo_det->Num_IMEI) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_det_Num_IMEI" class="cap_entrega_equipo_det_Num_IMEI"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo_det->Num_IMEI->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_entrega_equipo_det_Num_IMEI" class="cap_entrega_equipo_det_Num_IMEI">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo_det->Num_IMEI->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo_det->Num_IMEI->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo_det->Num_IMEI->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo_det->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
	<?php if ($cap_entrega_equipo_det->SortUrl($cap_entrega_equipo_det->Id_Tel_SIM) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_det_Id_Tel_SIM" class="cap_entrega_equipo_det_Id_Tel_SIM"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo_det->Id_Tel_SIM->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_entrega_equipo_det_Id_Tel_SIM" class="cap_entrega_equipo_det_Id_Tel_SIM">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo_det->Id_Tel_SIM->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo_det->Id_Tel_SIM->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo_det->Id_Tel_SIM->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo_det->Fecha->Visible) { // Fecha ?>
	<?php if ($cap_entrega_equipo_det->SortUrl($cap_entrega_equipo_det->Fecha) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_det_Fecha" class="cap_entrega_equipo_det_Fecha"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo_det->Fecha->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_entrega_equipo_det_Fecha" class="cap_entrega_equipo_det_Fecha">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo_det->Fecha->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo_det->Fecha->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo_det->Fecha->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_entrega_equipo_det->Hora->Visible) { // Hora ?>
	<?php if ($cap_entrega_equipo_det->SortUrl($cap_entrega_equipo_det->Hora) == "") { ?>
		<td><span id="elh_cap_entrega_equipo_det_Hora" class="cap_entrega_equipo_det_Hora"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_entrega_equipo_det->Hora->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_entrega_equipo_det_Hora" class="cap_entrega_equipo_det_Hora">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_entrega_equipo_det->Hora->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_entrega_equipo_det->Hora->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_entrega_equipo_det->Hora->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_entrega_equipo_det_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cap_entrega_equipo_det_grid->StartRec = 1;
$cap_entrega_equipo_det_grid->StopRec = $cap_entrega_equipo_det_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_entrega_equipo_det->CurrentAction == "gridadd" || $cap_entrega_equipo_det->CurrentAction == "gridedit" || $cap_entrega_equipo_det->CurrentAction == "F")) {
		$cap_entrega_equipo_det_grid->KeyCount = $objForm->GetValue("key_count");
		$cap_entrega_equipo_det_grid->StopRec = $cap_entrega_equipo_det_grid->KeyCount;
	}
}
$cap_entrega_equipo_det_grid->RecCnt = $cap_entrega_equipo_det_grid->StartRec - 1;
if ($cap_entrega_equipo_det_grid->Recordset && !$cap_entrega_equipo_det_grid->Recordset->EOF) {
	$cap_entrega_equipo_det_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_entrega_equipo_det_grid->StartRec > 1)
		$cap_entrega_equipo_det_grid->Recordset->Move($cap_entrega_equipo_det_grid->StartRec - 1);
} elseif (!$cap_entrega_equipo_det->AllowAddDeleteRow && $cap_entrega_equipo_det_grid->StopRec == 0) {
	$cap_entrega_equipo_det_grid->StopRec = $cap_entrega_equipo_det->GridAddRowCount;
}

// Initialize aggregate
$cap_entrega_equipo_det->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_entrega_equipo_det->ResetAttrs();
$cap_entrega_equipo_det_grid->RenderRow();
if ($cap_entrega_equipo_det->CurrentAction == "gridadd")
	$cap_entrega_equipo_det_grid->RowIndex = 0;
if ($cap_entrega_equipo_det->CurrentAction == "gridedit")
	$cap_entrega_equipo_det_grid->RowIndex = 0;
while ($cap_entrega_equipo_det_grid->RecCnt < $cap_entrega_equipo_det_grid->StopRec) {
	$cap_entrega_equipo_det_grid->RecCnt++;
	if (intval($cap_entrega_equipo_det_grid->RecCnt) >= intval($cap_entrega_equipo_det_grid->StartRec)) {
		$cap_entrega_equipo_det_grid->RowCnt++;
		if ($cap_entrega_equipo_det->CurrentAction == "gridadd" || $cap_entrega_equipo_det->CurrentAction == "gridedit" || $cap_entrega_equipo_det->CurrentAction == "F") {
			$cap_entrega_equipo_det_grid->RowIndex++;
			$objForm->Index = $cap_entrega_equipo_det_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_entrega_equipo_det_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_entrega_equipo_det->CurrentAction == "gridadd")
				$cap_entrega_equipo_det_grid->RowAction = "insert";
			else
				$cap_entrega_equipo_det_grid->RowAction = "";
		}

		// Set up key count
		$cap_entrega_equipo_det_grid->KeyCount = $cap_entrega_equipo_det_grid->RowIndex;

		// Init row class and style
		$cap_entrega_equipo_det->ResetAttrs();
		$cap_entrega_equipo_det->CssClass = "";
		if ($cap_entrega_equipo_det->CurrentAction == "gridadd") {
			if ($cap_entrega_equipo_det->CurrentMode == "copy") {
				$cap_entrega_equipo_det_grid->LoadRowValues($cap_entrega_equipo_det_grid->Recordset); // Load row values
				$cap_entrega_equipo_det_grid->SetRecordKey($cap_entrega_equipo_det_grid->RowOldKey, $cap_entrega_equipo_det_grid->Recordset); // Set old record key
			} else {
				$cap_entrega_equipo_det_grid->LoadDefaultValues(); // Load default values
				$cap_entrega_equipo_det_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($cap_entrega_equipo_det->CurrentAction == "gridedit") {
			$cap_entrega_equipo_det_grid->LoadRowValues($cap_entrega_equipo_det_grid->Recordset); // Load row values
		}
		$cap_entrega_equipo_det->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_entrega_equipo_det->CurrentAction == "gridadd") // Grid add
			$cap_entrega_equipo_det->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cap_entrega_equipo_det->CurrentAction == "gridadd" && $cap_entrega_equipo_det->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cap_entrega_equipo_det_grid->RestoreCurrentRowFormValues($cap_entrega_equipo_det_grid->RowIndex); // Restore form values
		if ($cap_entrega_equipo_det->CurrentAction == "gridedit") { // Grid edit
			if ($cap_entrega_equipo_det->EventCancelled) {
				$cap_entrega_equipo_det_grid->RestoreCurrentRowFormValues($cap_entrega_equipo_det_grid->RowIndex); // Restore form values
			}
			if ($cap_entrega_equipo_det_grid->RowAction == "insert")
				$cap_entrega_equipo_det->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_entrega_equipo_det->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_entrega_equipo_det->CurrentAction == "gridedit" && ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT || $cap_entrega_equipo_det->RowType == EW_ROWTYPE_ADD) && $cap_entrega_equipo_det->EventCancelled) // Update failed
			$cap_entrega_equipo_det_grid->RestoreCurrentRowFormValues($cap_entrega_equipo_det_grid->RowIndex); // Restore form values
		if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_entrega_equipo_det_grid->EditRowCnt++;
		if ($cap_entrega_equipo_det->CurrentAction == "F") // Confirm row
			$cap_entrega_equipo_det_grid->RestoreCurrentRowFormValues($cap_entrega_equipo_det_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cap_entrega_equipo_det->RowAttrs = array_merge($cap_entrega_equipo_det->RowAttrs, array('data-rowindex'=>$cap_entrega_equipo_det_grid->RowCnt, 'id'=>'r' . $cap_entrega_equipo_det_grid->RowCnt . '_cap_entrega_equipo_det', 'data-rowtype'=>$cap_entrega_equipo_det->RowType));

		// Render row
		$cap_entrega_equipo_det_grid->RenderRow();

		// Render list options
		$cap_entrega_equipo_det_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_entrega_equipo_det_grid->RowAction <> "delete" && $cap_entrega_equipo_det_grid->RowAction <> "insertdelete" && !($cap_entrega_equipo_det_grid->RowAction == "insert" && $cap_entrega_equipo_det->CurrentAction == "F" && $cap_entrega_equipo_det_grid->EmptyRow())) {
?>
	<tr<?php echo $cap_entrega_equipo_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_entrega_equipo_det_grid->ListOptions->Render("body", "left", $cap_entrega_equipo_det_grid->RowCnt);
?>
	<?php if ($cap_entrega_equipo_det->Num_IMEI->Visible) { // Num_IMEI ?>
		<td<?php echo $cap_entrega_equipo_det->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_grid->RowCnt ?>_cap_entrega_equipo_det_Num_IMEI" class="cap_entrega_equipo_det_Num_IMEI">
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" size="15" maxlength="15" value="<?php echo $cap_entrega_equipo_det->Num_IMEI->EditValue ?>"<?php echo $cap_entrega_equipo_det->Num_IMEI->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Num_IMEI->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" size="15" maxlength="15" value="<?php echo $cap_entrega_equipo_det->Num_IMEI->EditValue ?>"<?php echo $cap_entrega_equipo_det->Num_IMEI->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo_det->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Num_IMEI->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Num_IMEI->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Num_IMEI->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_det_grid->PageObjName . "_row_" . $cap_entrega_equipo_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Traspaso_Det" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Traspaso_Det->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Traspaso_Det" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Traspaso_Det->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT || $cap_entrega_equipo_det->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Traspaso_Det" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Traspaso_Det" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Traspaso_Det->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_entrega_equipo_det->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_grid->RowCnt ?>_cap_entrega_equipo_det_Id_Tel_SIM" class="cap_entrega_equipo_det_Id_Tel_SIM">
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM"<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_equipo_det->Id_Tel_SIM->EditValue)) {
	$arwrk = $cap_entrega_equipo_det->Id_Tel_SIM->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_equipo_det->Id_Tel_SIM->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator(2,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][4] <> "") { ?>
<?php echo ew_ValueSeparator(3,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][4] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_equipo_det->Id_Tel_SIM->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Tel_SIM`, `EquipoAcabado` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Status` AS `Disp3Fld`, `Num_ICCID` AS `Disp4Fld` FROM `aux_sel_equipo_venta`";
 $sWhereWrk = "";
 $lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="s_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_equipo_det->Id_Tel_SIM->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Tel_SIM` = {filter_value}"); ?>&t0=19">
<?php
 $sSqlWrk = "SELECT `Num_IMEI` AS FIELD0 FROM `aux_sel_equipo_venta`";
 $sWhereWrk = "(`Id_Tel_SIM` = {query_value})";
 $lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="sf_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="ln_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI">
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Tel_SIM->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM"<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_equipo_det->Id_Tel_SIM->EditValue)) {
	$arwrk = $cap_entrega_equipo_det->Id_Tel_SIM->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_equipo_det->Id_Tel_SIM->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator(2,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][4] <> "") { ?>
<?php echo ew_ValueSeparator(3,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][4] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_equipo_det->Id_Tel_SIM->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Tel_SIM`, `EquipoAcabado` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Status` AS `Disp3Fld`, `Num_ICCID` AS `Disp4Fld` FROM `aux_sel_equipo_venta`";
 $sWhereWrk = "";
 $lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="s_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_equipo_det->Id_Tel_SIM->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Tel_SIM` = {filter_value}"); ?>&t0=19">
<?php
 $sSqlWrk = "SELECT `Num_IMEI` AS FIELD0 FROM `aux_sel_equipo_venta`";
 $sWhereWrk = "(`Id_Tel_SIM` = {query_value})";
 $lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="sf_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="ln_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI">
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Tel_SIM->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Tel_SIM->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_det_grid->PageObjName . "_row_" . $cap_entrega_equipo_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo_det->Fecha->Visible) { // Fecha ?>
		<td<?php echo $cap_entrega_equipo_det->Fecha->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_grid->RowCnt ?>_cap_entrega_equipo_det_Fecha" class="cap_entrega_equipo_det_Fecha">
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Fecha->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo_det->Fecha->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Fecha->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Fecha->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Fecha->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_det_grid->PageObjName . "_row_" . $cap_entrega_equipo_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo_det->Hora->Visible) { // Hora ?>
		<td<?php echo $cap_entrega_equipo_det->Hora->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_grid->RowCnt ?>_cap_entrega_equipo_det_Hora" class="cap_entrega_equipo_det_Hora">
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Hora->OldValue) ?>">
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_entrega_equipo_det->Hora->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Hora->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Hora->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Hora->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_entrega_equipo_det_grid->PageObjName . "_row_" . $cap_entrega_equipo_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_entrega_equipo_det_grid->ListOptions->Render("body", "right", $cap_entrega_equipo_det_grid->RowCnt);
?>
	</tr>
<?php if ($cap_entrega_equipo_det->RowType == EW_ROWTYPE_ADD || $cap_entrega_equipo_det->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_entrega_equipo_detgrid.UpdateOpts(<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_entrega_equipo_det->CurrentAction <> "gridadd" || $cap_entrega_equipo_det->CurrentMode == "copy")
		if (!$cap_entrega_equipo_det_grid->Recordset->EOF) $cap_entrega_equipo_det_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cap_entrega_equipo_det->CurrentMode == "add" || $cap_entrega_equipo_det->CurrentMode == "copy" || $cap_entrega_equipo_det->CurrentMode == "edit") {
		$cap_entrega_equipo_det_grid->RowIndex = '$rowindex$';
		$cap_entrega_equipo_det_grid->LoadDefaultValues();

		// Set row properties
		$cap_entrega_equipo_det->ResetAttrs();
		$cap_entrega_equipo_det->RowAttrs = array_merge($cap_entrega_equipo_det->RowAttrs, array('data-rowindex'=>$cap_entrega_equipo_det_grid->RowIndex, 'id'=>'r0_cap_entrega_equipo_det', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_entrega_equipo_det->RowAttrs["class"], "ewTemplate");
		$cap_entrega_equipo_det->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_entrega_equipo_det_grid->RenderRow();

		// Render list options
		$cap_entrega_equipo_det_grid->RenderListOptions();
		$cap_entrega_equipo_det_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cap_entrega_equipo_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_entrega_equipo_det_grid->ListOptions->Render("body", "left", $cap_entrega_equipo_det_grid->RowIndex);
?>
	<?php if ($cap_entrega_equipo_det->Num_IMEI->Visible) { // Num_IMEI ?>
		<td><span id="el$rowindex$_cap_entrega_equipo_det_Num_IMEI" class="cap_entrega_equipo_det_Num_IMEI">
<?php if ($cap_entrega_equipo_det->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" size="15" maxlength="15" value="<?php echo $cap_entrega_equipo_det->Num_IMEI->EditValue ?>"<?php echo $cap_entrega_equipo_det->Num_IMEI->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_entrega_equipo_det->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Num_IMEI->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Num_IMEI->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Num_IMEI->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo_det->Id_Tel_SIM->Visible) { // Id_Tel_SIM ?>
		<td><span id="el$rowindex$_cap_entrega_equipo_det_Id_Tel_SIM" class="cap_entrega_equipo_det_Id_Tel_SIM">
<?php if ($cap_entrega_equipo_det->CurrentAction <> "F") { ?>
<?php $cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_entrega_equipo_det->Id_Tel_SIM->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM"<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->EditAttributes() ?>>
<?php
if (is_array($cap_entrega_equipo_det->Id_Tel_SIM->EditValue)) {
	$arwrk = $cap_entrega_equipo_det->Id_Tel_SIM->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_entrega_equipo_det->Id_Tel_SIM->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator(1,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][3] <> "") { ?>
<?php echo ew_ValueSeparator(2,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][3] ?>
<?php } ?>
<?php if ($arwrk[$rowcntwrk][4] <> "") { ?>
<?php echo ew_ValueSeparator(3,$cap_entrega_equipo_det->Id_Tel_SIM) ?><?php echo $arwrk[$rowcntwrk][4] ?>
<?php } ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_entrega_equipo_det->Id_Tel_SIM->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Tel_SIM`, `EquipoAcabado` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Status` AS `Disp3Fld`, `Num_ICCID` AS `Disp4Fld` FROM `aux_sel_equipo_venta`";
 $sWhereWrk = "";
 $lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
?>
<input type="hidden" name="s_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="s_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_entrega_equipo_det->Id_Tel_SIM->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Tel_SIM` = {filter_value}"); ?>&t0=19">
<?php
 $sSqlWrk = "SELECT `Num_IMEI` AS FIELD0 FROM `aux_sel_equipo_venta`";
 $sWhereWrk = "(`Id_Tel_SIM` = {query_value})";
 $lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="sf_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="ln_x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Num_IMEI">
<?php } else { ?>
<span<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Tel_SIM->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Id_Tel_SIM" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Id_Tel_SIM->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo_det->Fecha->Visible) { // Fecha ?>
		<td><span id="el$rowindex$_cap_entrega_equipo_det_Fecha" class="cap_entrega_equipo_det_Fecha">
<?php if ($cap_entrega_equipo_det->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $cap_entrega_equipo_det->Fecha->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Fecha->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Fecha" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Fecha->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_entrega_equipo_det->Hora->Visible) { // Hora ?>
		<td><span id="el$rowindex$_cap_entrega_equipo_det_Hora" class="cap_entrega_equipo_det_Hora">
<?php if ($cap_entrega_equipo_det->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $cap_entrega_equipo_det->Hora->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Hora->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" id="x<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Hora->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" id="o<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>_Hora" value="<?php echo ew_HtmlEncode($cap_entrega_equipo_det->Hora->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_entrega_equipo_det_grid->ListOptions->Render("body", "right", $cap_entrega_equipo_det_grid->RowCnt);
?>
<script type="text/javascript">
fcap_entrega_equipo_detgrid.UpdateOpts(<?php echo $cap_entrega_equipo_det_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cap_entrega_equipo_det->CurrentMode == "add" || $cap_entrega_equipo_det->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_entrega_equipo_det_grid->KeyCount ?>">
<?php echo $cap_entrega_equipo_det_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_entrega_equipo_det->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_entrega_equipo_det_grid->KeyCount ?>">
<?php echo $cap_entrega_equipo_det_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_entrega_equipo_det->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fcap_entrega_equipo_detgrid">
</div>
<?php

// Close recordset
if ($cap_entrega_equipo_det_grid->Recordset)
	$cap_entrega_equipo_det_grid->Recordset->Close();
?>
<?php if (($cap_entrega_equipo_det->CurrentMode == "add" || $cap_entrega_equipo_det->CurrentMode == "copy" || $cap_entrega_equipo_det->CurrentMode == "edit") && $cap_entrega_equipo_det->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($cap_entrega_equipo_det->Export == "") { ?>
<script type="text/javascript">
fcap_entrega_equipo_detgrid.Init();
</script>
<?php } ?>
<?php
$cap_entrega_equipo_det_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cap_entrega_equipo_det_grid->Page_Terminate();
$Page = &$MasterPage;
?>
