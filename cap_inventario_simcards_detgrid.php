<?php include_once "sys_userinfo.php" ?>
<?php

// Create page object
if (!isset($cap_inventario_simcards_det_grid)) $cap_inventario_simcards_det_grid = new ccap_inventario_simcards_det_grid();

// Page init
$cap_inventario_simcards_det_grid->Page_Init();

// Page main
$cap_inventario_simcards_det_grid->Page_Main();
?>
<?php if ($cap_inventario_simcards_det->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_inventario_simcards_det_grid = new ew_Page("cap_inventario_simcards_det_grid");
cap_inventario_simcards_det_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cap_inventario_simcards_det_grid.PageID; // For backward compatibility

// Form object
var fcap_inventario_simcards_detgrid = new ew_Form("fcap_inventario_simcards_detgrid");

// Validate form
fcap_inventario_simcards_detgrid.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_inventario_simcards_det->Articulo->FldCaption()) ?>");

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
fcap_inventario_simcards_detgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Articulo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Num_ICCID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Num_CEL", false)) return false;
	return true;
}

// Form_CustomValidate event
fcap_inventario_simcards_detgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_inventario_simcards_detgrid.ValidateRequired = true;
<?php } else { ?>
fcap_inventario_simcards_detgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($cap_inventario_simcards_det->CurrentAction == "gridadd") {
	if ($cap_inventario_simcards_det->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cap_inventario_simcards_det_grid->TotalRecs = $cap_inventario_simcards_det->SelectRecordCount();
			$cap_inventario_simcards_det_grid->Recordset = $cap_inventario_simcards_det_grid->LoadRecordset($cap_inventario_simcards_det_grid->StartRec-1, $cap_inventario_simcards_det_grid->DisplayRecs);
		} else {
			if ($cap_inventario_simcards_det_grid->Recordset = $cap_inventario_simcards_det_grid->LoadRecordset())
				$cap_inventario_simcards_det_grid->TotalRecs = $cap_inventario_simcards_det_grid->Recordset->RecordCount();
		}
		$cap_inventario_simcards_det_grid->StartRec = 1;
		$cap_inventario_simcards_det_grid->DisplayRecs = $cap_inventario_simcards_det_grid->TotalRecs;
	} else {
		$cap_inventario_simcards_det->CurrentFilter = "0=1";
		$cap_inventario_simcards_det_grid->StartRec = 1;
		$cap_inventario_simcards_det_grid->DisplayRecs = $cap_inventario_simcards_det->GridAddRowCount;
	}
	$cap_inventario_simcards_det_grid->TotalRecs = $cap_inventario_simcards_det_grid->DisplayRecs;
	$cap_inventario_simcards_det_grid->StopRec = $cap_inventario_simcards_det_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_inventario_simcards_det_grid->TotalRecs = $cap_inventario_simcards_det->SelectRecordCount();
	} else {
		if ($cap_inventario_simcards_det_grid->Recordset = $cap_inventario_simcards_det_grid->LoadRecordset())
			$cap_inventario_simcards_det_grid->TotalRecs = $cap_inventario_simcards_det_grid->Recordset->RecordCount();
	}
	$cap_inventario_simcards_det_grid->StartRec = 1;
	$cap_inventario_simcards_det_grid->DisplayRecs = $cap_inventario_simcards_det_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cap_inventario_simcards_det_grid->Recordset = $cap_inventario_simcards_det_grid->LoadRecordset($cap_inventario_simcards_det_grid->StartRec-1, $cap_inventario_simcards_det_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php if ($cap_inventario_simcards_det->CurrentMode == "add" || $cap_inventario_simcards_det->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cap_inventario_simcards_det->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_inventario_simcards_det->TableCaption() ?></span></p>
</p>
<?php $cap_inventario_simcards_det_grid->ShowPageHeader(); ?>
<?php
$cap_inventario_simcards_det_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fcap_inventario_simcards_detgrid" class="ewForm">
<?php if (($cap_inventario_simcards_det->CurrentMode == "add" || $cap_inventario_simcards_det->CurrentMode == "copy" || $cap_inventario_simcards_det->CurrentMode == "edit") && $cap_inventario_simcards_det->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
</div>
<?php } ?>
<div id="gmp_cap_inventario_simcards_det" class="ewGridMiddlePanel">
<table id="tbl_cap_inventario_simcards_detgrid" class="ewTable ewTableSeparate">
<?php echo $cap_inventario_simcards_det->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_inventario_simcards_det_grid->RenderListOptions();

// Render list options (header, left)
$cap_inventario_simcards_det_grid->ListOptions->Render("header", "left");
?>
<?php if ($cap_inventario_simcards_det->Articulo->Visible) { // Articulo ?>
	<?php if ($cap_inventario_simcards_det->SortUrl($cap_inventario_simcards_det->Articulo) == "") { ?>
		<td><span id="elh_cap_inventario_simcards_det_Articulo" class="cap_inventario_simcards_det_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_simcards_det->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_inventario_simcards_det_Articulo" class="cap_inventario_simcards_det_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_simcards_det->Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_simcards_det->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_simcards_det->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_simcards_det->Num_ICCID->Visible) { // Num_ICCID ?>
	<?php if ($cap_inventario_simcards_det->SortUrl($cap_inventario_simcards_det->Num_ICCID) == "") { ?>
		<td><span id="elh_cap_inventario_simcards_det_Num_ICCID" class="cap_inventario_simcards_det_Num_ICCID"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_simcards_det->Num_ICCID->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_inventario_simcards_det_Num_ICCID" class="cap_inventario_simcards_det_Num_ICCID">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_simcards_det->Num_ICCID->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_simcards_det->Num_ICCID->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_simcards_det->Num_ICCID->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_inventario_simcards_det->Num_CEL->Visible) { // Num_CEL ?>
	<?php if ($cap_inventario_simcards_det->SortUrl($cap_inventario_simcards_det->Num_CEL) == "") { ?>
		<td><span id="elh_cap_inventario_simcards_det_Num_CEL" class="cap_inventario_simcards_det_Num_CEL"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_inventario_simcards_det->Num_CEL->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_inventario_simcards_det_Num_CEL" class="cap_inventario_simcards_det_Num_CEL">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_inventario_simcards_det->Num_CEL->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_inventario_simcards_det->Num_CEL->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_inventario_simcards_det->Num_CEL->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_inventario_simcards_det_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cap_inventario_simcards_det_grid->StartRec = 1;
$cap_inventario_simcards_det_grid->StopRec = $cap_inventario_simcards_det_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_inventario_simcards_det->CurrentAction == "gridadd" || $cap_inventario_simcards_det->CurrentAction == "gridedit" || $cap_inventario_simcards_det->CurrentAction == "F")) {
		$cap_inventario_simcards_det_grid->KeyCount = $objForm->GetValue("key_count");
		$cap_inventario_simcards_det_grid->StopRec = $cap_inventario_simcards_det_grid->KeyCount;
	}
}
$cap_inventario_simcards_det_grid->RecCnt = $cap_inventario_simcards_det_grid->StartRec - 1;
if ($cap_inventario_simcards_det_grid->Recordset && !$cap_inventario_simcards_det_grid->Recordset->EOF) {
	$cap_inventario_simcards_det_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_inventario_simcards_det_grid->StartRec > 1)
		$cap_inventario_simcards_det_grid->Recordset->Move($cap_inventario_simcards_det_grid->StartRec - 1);
} elseif (!$cap_inventario_simcards_det->AllowAddDeleteRow && $cap_inventario_simcards_det_grid->StopRec == 0) {
	$cap_inventario_simcards_det_grid->StopRec = $cap_inventario_simcards_det->GridAddRowCount;
}

// Initialize aggregate
$cap_inventario_simcards_det->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_inventario_simcards_det->ResetAttrs();
$cap_inventario_simcards_det_grid->RenderRow();
if ($cap_inventario_simcards_det->CurrentAction == "gridadd")
	$cap_inventario_simcards_det_grid->RowIndex = 0;
if ($cap_inventario_simcards_det->CurrentAction == "gridedit")
	$cap_inventario_simcards_det_grid->RowIndex = 0;
while ($cap_inventario_simcards_det_grid->RecCnt < $cap_inventario_simcards_det_grid->StopRec) {
	$cap_inventario_simcards_det_grid->RecCnt++;
	if (intval($cap_inventario_simcards_det_grid->RecCnt) >= intval($cap_inventario_simcards_det_grid->StartRec)) {
		$cap_inventario_simcards_det_grid->RowCnt++;
		if ($cap_inventario_simcards_det->CurrentAction == "gridadd" || $cap_inventario_simcards_det->CurrentAction == "gridedit" || $cap_inventario_simcards_det->CurrentAction == "F") {
			$cap_inventario_simcards_det_grid->RowIndex++;
			$objForm->Index = $cap_inventario_simcards_det_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_inventario_simcards_det_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_inventario_simcards_det->CurrentAction == "gridadd")
				$cap_inventario_simcards_det_grid->RowAction = "insert";
			else
				$cap_inventario_simcards_det_grid->RowAction = "";
		}

		// Set up key count
		$cap_inventario_simcards_det_grid->KeyCount = $cap_inventario_simcards_det_grid->RowIndex;

		// Init row class and style
		$cap_inventario_simcards_det->ResetAttrs();
		$cap_inventario_simcards_det->CssClass = "";
		if ($cap_inventario_simcards_det->CurrentAction == "gridadd") {
			if ($cap_inventario_simcards_det->CurrentMode == "copy") {
				$cap_inventario_simcards_det_grid->LoadRowValues($cap_inventario_simcards_det_grid->Recordset); // Load row values
				$cap_inventario_simcards_det_grid->SetRecordKey($cap_inventario_simcards_det_grid->RowOldKey, $cap_inventario_simcards_det_grid->Recordset); // Set old record key
			} else {
				$cap_inventario_simcards_det_grid->LoadDefaultValues(); // Load default values
				$cap_inventario_simcards_det_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($cap_inventario_simcards_det->CurrentAction == "gridedit") {
			$cap_inventario_simcards_det_grid->LoadRowValues($cap_inventario_simcards_det_grid->Recordset); // Load row values
		}
		$cap_inventario_simcards_det->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_inventario_simcards_det->CurrentAction == "gridadd") // Grid add
			$cap_inventario_simcards_det->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cap_inventario_simcards_det->CurrentAction == "gridadd" && $cap_inventario_simcards_det->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cap_inventario_simcards_det_grid->RestoreCurrentRowFormValues($cap_inventario_simcards_det_grid->RowIndex); // Restore form values
		if ($cap_inventario_simcards_det->CurrentAction == "gridedit") { // Grid edit
			if ($cap_inventario_simcards_det->EventCancelled) {
				$cap_inventario_simcards_det_grid->RestoreCurrentRowFormValues($cap_inventario_simcards_det_grid->RowIndex); // Restore form values
			}
			if ($cap_inventario_simcards_det_grid->RowAction == "insert")
				$cap_inventario_simcards_det->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_inventario_simcards_det->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_inventario_simcards_det->CurrentAction == "gridedit" && ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT || $cap_inventario_simcards_det->RowType == EW_ROWTYPE_ADD) && $cap_inventario_simcards_det->EventCancelled) // Update failed
			$cap_inventario_simcards_det_grid->RestoreCurrentRowFormValues($cap_inventario_simcards_det_grid->RowIndex); // Restore form values
		if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_inventario_simcards_det_grid->EditRowCnt++;
		if ($cap_inventario_simcards_det->CurrentAction == "F") // Confirm row
			$cap_inventario_simcards_det_grid->RestoreCurrentRowFormValues($cap_inventario_simcards_det_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cap_inventario_simcards_det->RowAttrs = array_merge($cap_inventario_simcards_det->RowAttrs, array('data-rowindex'=>$cap_inventario_simcards_det_grid->RowCnt, 'id'=>'r' . $cap_inventario_simcards_det_grid->RowCnt . '_cap_inventario_simcards_det', 'data-rowtype'=>$cap_inventario_simcards_det->RowType));

		// Render row
		$cap_inventario_simcards_det_grid->RenderRow();

		// Render list options
		$cap_inventario_simcards_det_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_inventario_simcards_det_grid->RowAction <> "delete" && $cap_inventario_simcards_det_grid->RowAction <> "insertdelete" && !($cap_inventario_simcards_det_grid->RowAction == "insert" && $cap_inventario_simcards_det->CurrentAction == "F" && $cap_inventario_simcards_det_grid->EmptyRow())) {
?>
	<tr<?php echo $cap_inventario_simcards_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_inventario_simcards_det_grid->ListOptions->Render("body", "left", $cap_inventario_simcards_det_grid->RowCnt);
?>
	<?php if ($cap_inventario_simcards_det->Articulo->Visible) { // Articulo ?>
		<td<?php echo $cap_inventario_simcards_det->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_inventario_simcards_det_grid->RowCnt ?>_cap_inventario_simcards_det_Articulo" class="cap_inventario_simcards_det_Articulo">
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" size="30" maxlength="100" value="<?php echo $cap_inventario_simcards_det->Articulo->EditValue ?>"<?php echo $cap_inventario_simcards_det->Articulo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" size="30" maxlength="100" value="<?php echo $cap_inventario_simcards_det->Articulo->EditValue ?>"<?php echo $cap_inventario_simcards_det->Articulo->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_simcards_det->Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards_det->Articulo->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Articulo->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Articulo->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_inventario_simcards_det_grid->PageObjName . "_row_" . $cap_inventario_simcards_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Almacen" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Almacen" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Id_Almacen->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Almacen" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Almacen" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Id_Almacen->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT || $cap_inventario_simcards_det->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Almacen" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Almacen" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Id_Almacen->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Id_Articulo->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT || $cap_inventario_simcards_det->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Id_Articulo->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_inventario_simcards_det->Num_ICCID->Visible) { // Num_ICCID ?>
		<td<?php echo $cap_inventario_simcards_det->Num_ICCID->CellAttributes() ?>><span id="el<?php echo $cap_inventario_simcards_det_grid->RowCnt ?>_cap_inventario_simcards_det_Num_ICCID" class="cap_inventario_simcards_det_Num_ICCID">
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" size="30" maxlength="19" value="<?php echo $cap_inventario_simcards_det->Num_ICCID->EditValue ?>"<?php echo $cap_inventario_simcards_det->Num_ICCID->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_ICCID->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" size="30" maxlength="19" value="<?php echo $cap_inventario_simcards_det->Num_ICCID->EditValue ?>"<?php echo $cap_inventario_simcards_det->Num_ICCID->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_simcards_det->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards_det->Num_ICCID->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_ICCID->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_ICCID->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_inventario_simcards_det_grid->PageObjName . "_row_" . $cap_inventario_simcards_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_inventario_simcards_det->Num_CEL->Visible) { // Num_CEL ?>
		<td<?php echo $cap_inventario_simcards_det->Num_CEL->CellAttributes() ?>><span id="el<?php echo $cap_inventario_simcards_det_grid->RowCnt ?>_cap_inventario_simcards_det_Num_CEL" class="cap_inventario_simcards_det_Num_CEL">
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" size="30" maxlength="10" value="<?php echo $cap_inventario_simcards_det->Num_CEL->EditValue ?>"<?php echo $cap_inventario_simcards_det->Num_CEL->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_CEL->OldValue) ?>">
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" size="30" maxlength="10" value="<?php echo $cap_inventario_simcards_det->Num_CEL->EditValue ?>"<?php echo $cap_inventario_simcards_det->Num_CEL->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_inventario_simcards_det->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards_det->Num_CEL->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_CEL->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_CEL->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_inventario_simcards_det_grid->PageObjName . "_row_" . $cap_inventario_simcards_det_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_inventario_simcards_det_grid->ListOptions->Render("body", "right", $cap_inventario_simcards_det_grid->RowCnt);
?>
	</tr>
<?php if ($cap_inventario_simcards_det->RowType == EW_ROWTYPE_ADD || $cap_inventario_simcards_det->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_inventario_simcards_detgrid.UpdateOpts(<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_inventario_simcards_det->CurrentAction <> "gridadd" || $cap_inventario_simcards_det->CurrentMode == "copy")
		if (!$cap_inventario_simcards_det_grid->Recordset->EOF) $cap_inventario_simcards_det_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cap_inventario_simcards_det->CurrentMode == "add" || $cap_inventario_simcards_det->CurrentMode == "copy" || $cap_inventario_simcards_det->CurrentMode == "edit") {
		$cap_inventario_simcards_det_grid->RowIndex = '$rowindex$';
		$cap_inventario_simcards_det_grid->LoadDefaultValues();

		// Set row properties
		$cap_inventario_simcards_det->ResetAttrs();
		$cap_inventario_simcards_det->RowAttrs = array_merge($cap_inventario_simcards_det->RowAttrs, array('data-rowindex'=>$cap_inventario_simcards_det_grid->RowIndex, 'id'=>'r0_cap_inventario_simcards_det', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_inventario_simcards_det->RowAttrs["class"], "ewTemplate");
		$cap_inventario_simcards_det->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_inventario_simcards_det_grid->RenderRow();

		// Render list options
		$cap_inventario_simcards_det_grid->RenderListOptions();
		$cap_inventario_simcards_det_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cap_inventario_simcards_det->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_inventario_simcards_det_grid->ListOptions->Render("body", "left", $cap_inventario_simcards_det_grid->RowIndex);
?>
	<?php if ($cap_inventario_simcards_det->Articulo->Visible) { // Articulo ?>
		<td><span id="el$rowindex$_cap_inventario_simcards_det_Articulo" class="cap_inventario_simcards_det_Articulo">
<?php if ($cap_inventario_simcards_det->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" size="30" maxlength="100" value="<?php echo $cap_inventario_simcards_det->Articulo->EditValue ?>"<?php echo $cap_inventario_simcards_det->Articulo->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_inventario_simcards_det->Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards_det->Articulo->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Articulo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_simcards_det->Num_ICCID->Visible) { // Num_ICCID ?>
		<td><span id="el$rowindex$_cap_inventario_simcards_det_Num_ICCID" class="cap_inventario_simcards_det_Num_ICCID">
<?php if ($cap_inventario_simcards_det->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" size="30" maxlength="19" value="<?php echo $cap_inventario_simcards_det->Num_ICCID->EditValue ?>"<?php echo $cap_inventario_simcards_det->Num_ICCID->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_inventario_simcards_det->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards_det->Num_ICCID->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_ICCID->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_ICCID" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_ICCID->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_inventario_simcards_det->Num_CEL->Visible) { // Num_CEL ?>
		<td><span id="el$rowindex$_cap_inventario_simcards_det_Num_CEL" class="cap_inventario_simcards_det_Num_CEL">
<?php if ($cap_inventario_simcards_det->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" size="30" maxlength="10" value="<?php echo $cap_inventario_simcards_det->Num_CEL->EditValue ?>"<?php echo $cap_inventario_simcards_det->Num_CEL->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_inventario_simcards_det->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_inventario_simcards_det->Num_CEL->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="x<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_CEL->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" id="o<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>_Num_CEL" value="<?php echo ew_HtmlEncode($cap_inventario_simcards_det->Num_CEL->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_inventario_simcards_det_grid->ListOptions->Render("body", "right", $cap_inventario_simcards_det_grid->RowCnt);
?>
<script type="text/javascript">
fcap_inventario_simcards_detgrid.UpdateOpts(<?php echo $cap_inventario_simcards_det_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cap_inventario_simcards_det->CurrentMode == "add" || $cap_inventario_simcards_det->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_inventario_simcards_det_grid->KeyCount ?>">
<?php echo $cap_inventario_simcards_det_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_inventario_simcards_det->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_inventario_simcards_det_grid->KeyCount ?>">
<?php echo $cap_inventario_simcards_det_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_inventario_simcards_det->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fcap_inventario_simcards_detgrid">
</div>
<?php

// Close recordset
if ($cap_inventario_simcards_det_grid->Recordset)
	$cap_inventario_simcards_det_grid->Recordset->Close();
?>
<?php if (($cap_inventario_simcards_det->CurrentMode == "add" || $cap_inventario_simcards_det->CurrentMode == "copy" || $cap_inventario_simcards_det->CurrentMode == "edit") && $cap_inventario_simcards_det->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($cap_inventario_simcards_det->Export == "") { ?>
<script type="text/javascript">
fcap_inventario_simcards_detgrid.Init();
</script>
<?php } ?>
<?php
$cap_inventario_simcards_det_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cap_inventario_simcards_det_grid->Page_Terminate();
$Page = &$MasterPage;
?>
