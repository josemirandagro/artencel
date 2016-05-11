<?php include_once "sys_userinfo.php" ?>
<?php

// Create page object
if (!isset($cap_asigna_acabados_equipo_detail_grid)) $cap_asigna_acabados_equipo_detail_grid = new ccap_asigna_acabados_equipo_detail_grid();

// Page init
$cap_asigna_acabados_equipo_detail_grid->Page_Init();

// Page main
$cap_asigna_acabados_equipo_detail_grid->Page_Main();
?>
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_asigna_acabados_equipo_detail_grid = new ew_Page("cap_asigna_acabados_equipo_detail_grid");
cap_asigna_acabados_equipo_detail_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cap_asigna_acabados_equipo_detail_grid.PageID; // For backward compatibility

// Form object
var fcap_asigna_acabados_equipo_detailgrid = new ew_Form("fcap_asigna_acabados_equipo_detailgrid");

// Validate form
fcap_asigna_acabados_equipo_detailgrid.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Acabado_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FldCaption()) ?>");

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
fcap_asigna_acabados_equipo_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Id_Articulo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Acabado_eq", false)) return false;
	return true;
}

// Form_CustomValidate event
fcap_asigna_acabados_equipo_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_asigna_acabados_equipo_detailgrid.ValidateRequired = true;
<?php } else { ?>
fcap_asigna_acabados_equipo_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_asigna_acabados_equipo_detailgrid.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":null,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_asigna_acabados_equipo_detailgrid.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") {
	if ($cap_asigna_acabados_equipo_detail->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cap_asigna_acabados_equipo_detail_grid->TotalRecs = $cap_asigna_acabados_equipo_detail->SelectRecordCount();
			$cap_asigna_acabados_equipo_detail_grid->Recordset = $cap_asigna_acabados_equipo_detail_grid->LoadRecordset($cap_asigna_acabados_equipo_detail_grid->StartRec-1, $cap_asigna_acabados_equipo_detail_grid->DisplayRecs);
		} else {
			if ($cap_asigna_acabados_equipo_detail_grid->Recordset = $cap_asigna_acabados_equipo_detail_grid->LoadRecordset())
				$cap_asigna_acabados_equipo_detail_grid->TotalRecs = $cap_asigna_acabados_equipo_detail_grid->Recordset->RecordCount();
		}
		$cap_asigna_acabados_equipo_detail_grid->StartRec = 1;
		$cap_asigna_acabados_equipo_detail_grid->DisplayRecs = $cap_asigna_acabados_equipo_detail_grid->TotalRecs;
	} else {
		$cap_asigna_acabados_equipo_detail->CurrentFilter = "0=1";
		$cap_asigna_acabados_equipo_detail_grid->StartRec = 1;
		$cap_asigna_acabados_equipo_detail_grid->DisplayRecs = $cap_asigna_acabados_equipo_detail->GridAddRowCount;
	}
	$cap_asigna_acabados_equipo_detail_grid->TotalRecs = $cap_asigna_acabados_equipo_detail_grid->DisplayRecs;
	$cap_asigna_acabados_equipo_detail_grid->StopRec = $cap_asigna_acabados_equipo_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_asigna_acabados_equipo_detail_grid->TotalRecs = $cap_asigna_acabados_equipo_detail->SelectRecordCount();
	} else {
		if ($cap_asigna_acabados_equipo_detail_grid->Recordset = $cap_asigna_acabados_equipo_detail_grid->LoadRecordset())
			$cap_asigna_acabados_equipo_detail_grid->TotalRecs = $cap_asigna_acabados_equipo_detail_grid->Recordset->RecordCount();
	}
	$cap_asigna_acabados_equipo_detail_grid->StartRec = 1;
	$cap_asigna_acabados_equipo_detail_grid->DisplayRecs = $cap_asigna_acabados_equipo_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cap_asigna_acabados_equipo_detail_grid->Recordset = $cap_asigna_acabados_equipo_detail_grid->LoadRecordset($cap_asigna_acabados_equipo_detail_grid->StartRec-1, $cap_asigna_acabados_equipo_detail_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php if ($cap_asigna_acabados_equipo_detail->CurrentMode == "add" || $cap_asigna_acabados_equipo_detail->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cap_asigna_acabados_equipo_detail->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_asigna_acabados_equipo_detail->TableCaption() ?></span></p>
</p>
<?php $cap_asigna_acabados_equipo_detail_grid->ShowPageHeader(); ?>
<?php
$cap_asigna_acabados_equipo_detail_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fcap_asigna_acabados_equipo_detailgrid" class="ewForm">
<?php if (($cap_asigna_acabados_equipo_detail->CurrentMode == "add" || $cap_asigna_acabados_equipo_detail->CurrentMode == "copy" || $cap_asigna_acabados_equipo_detail->CurrentMode == "edit") && $cap_asigna_acabados_equipo_detail->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
</div>
<?php } ?>
<div id="gmp_cap_asigna_acabados_equipo_detail" class="ewGridMiddlePanel">
<table id="tbl_cap_asigna_acabados_equipo_detailgrid" class="ewTable ewTableSeparate">
<?php echo $cap_asigna_acabados_equipo_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_asigna_acabados_equipo_detail_grid->RenderListOptions();

// Render list options (header, left)
$cap_asigna_acabados_equipo_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_asigna_acabados_equipo_detail->SortUrl($cap_asigna_acabados_equipo_detail->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
	<?php if ($cap_asigna_acabados_equipo_detail->SortUrl($cap_asigna_acabados_equipo_detail->Id_Acabado_eq) == "") { ?>
		<td><span id="elh_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_asigna_acabados_equipo_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cap_asigna_acabados_equipo_detail_grid->StartRec = 1;
$cap_asigna_acabados_equipo_detail_grid->StopRec = $cap_asigna_acabados_equipo_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd" || $cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit" || $cap_asigna_acabados_equipo_detail->CurrentAction == "F")) {
		$cap_asigna_acabados_equipo_detail_grid->KeyCount = $objForm->GetValue("key_count");
		$cap_asigna_acabados_equipo_detail_grid->StopRec = $cap_asigna_acabados_equipo_detail_grid->KeyCount;
	}
}
$cap_asigna_acabados_equipo_detail_grid->RecCnt = $cap_asigna_acabados_equipo_detail_grid->StartRec - 1;
if ($cap_asigna_acabados_equipo_detail_grid->Recordset && !$cap_asigna_acabados_equipo_detail_grid->Recordset->EOF) {
	$cap_asigna_acabados_equipo_detail_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_asigna_acabados_equipo_detail_grid->StartRec > 1)
		$cap_asigna_acabados_equipo_detail_grid->Recordset->Move($cap_asigna_acabados_equipo_detail_grid->StartRec - 1);
} elseif (!$cap_asigna_acabados_equipo_detail->AllowAddDeleteRow && $cap_asigna_acabados_equipo_detail_grid->StopRec == 0) {
	$cap_asigna_acabados_equipo_detail_grid->StopRec = $cap_asigna_acabados_equipo_detail->GridAddRowCount;
}

// Initialize aggregate
$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_asigna_acabados_equipo_detail->ResetAttrs();
$cap_asigna_acabados_equipo_detail_grid->RenderRow();
if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd")
	$cap_asigna_acabados_equipo_detail_grid->RowIndex = 0;
if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit")
	$cap_asigna_acabados_equipo_detail_grid->RowIndex = 0;
while ($cap_asigna_acabados_equipo_detail_grid->RecCnt < $cap_asigna_acabados_equipo_detail_grid->StopRec) {
	$cap_asigna_acabados_equipo_detail_grid->RecCnt++;
	if (intval($cap_asigna_acabados_equipo_detail_grid->RecCnt) >= intval($cap_asigna_acabados_equipo_detail_grid->StartRec)) {
		$cap_asigna_acabados_equipo_detail_grid->RowCnt++;
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd" || $cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit" || $cap_asigna_acabados_equipo_detail->CurrentAction == "F") {
			$cap_asigna_acabados_equipo_detail_grid->RowIndex++;
			$objForm->Index = $cap_asigna_acabados_equipo_detail_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_asigna_acabados_equipo_detail_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd")
				$cap_asigna_acabados_equipo_detail_grid->RowAction = "insert";
			else
				$cap_asigna_acabados_equipo_detail_grid->RowAction = "";
		}

		// Set up key count
		$cap_asigna_acabados_equipo_detail_grid->KeyCount = $cap_asigna_acabados_equipo_detail_grid->RowIndex;

		// Init row class and style
		$cap_asigna_acabados_equipo_detail->ResetAttrs();
		$cap_asigna_acabados_equipo_detail->CssClass = "";
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") {
			if ($cap_asigna_acabados_equipo_detail->CurrentMode == "copy") {
				$cap_asigna_acabados_equipo_detail_grid->LoadRowValues($cap_asigna_acabados_equipo_detail_grid->Recordset); // Load row values
				$cap_asigna_acabados_equipo_detail_grid->SetRecordKey($cap_asigna_acabados_equipo_detail_grid->RowOldKey, $cap_asigna_acabados_equipo_detail_grid->Recordset); // Set old record key
			} else {
				$cap_asigna_acabados_equipo_detail_grid->LoadDefaultValues(); // Load default values
				$cap_asigna_acabados_equipo_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit") {
			$cap_asigna_acabados_equipo_detail_grid->LoadRowValues($cap_asigna_acabados_equipo_detail_grid->Recordset); // Load row values
		}
		$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd") // Grid add
			$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridadd" && $cap_asigna_acabados_equipo_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cap_asigna_acabados_equipo_detail_grid->RestoreCurrentRowFormValues($cap_asigna_acabados_equipo_detail_grid->RowIndex); // Restore form values
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit") { // Grid edit
			if ($cap_asigna_acabados_equipo_detail->EventCancelled) {
				$cap_asigna_acabados_equipo_detail_grid->RestoreCurrentRowFormValues($cap_asigna_acabados_equipo_detail_grid->RowIndex); // Restore form values
			}
			if ($cap_asigna_acabados_equipo_detail_grid->RowAction == "insert")
				$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "gridedit" && ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_EDIT || $cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD) && $cap_asigna_acabados_equipo_detail->EventCancelled) // Update failed
			$cap_asigna_acabados_equipo_detail_grid->RestoreCurrentRowFormValues($cap_asigna_acabados_equipo_detail_grid->RowIndex); // Restore form values
		if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_asigna_acabados_equipo_detail_grid->EditRowCnt++;
		if ($cap_asigna_acabados_equipo_detail->CurrentAction == "F") // Confirm row
			$cap_asigna_acabados_equipo_detail_grid->RestoreCurrentRowFormValues($cap_asigna_acabados_equipo_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cap_asigna_acabados_equipo_detail->RowAttrs = array_merge($cap_asigna_acabados_equipo_detail->RowAttrs, array('data-rowindex'=>$cap_asigna_acabados_equipo_detail_grid->RowCnt, 'id'=>'r' . $cap_asigna_acabados_equipo_detail_grid->RowCnt . '_cap_asigna_acabados_equipo_detail', 'data-rowtype'=>$cap_asigna_acabados_equipo_detail->RowType));

		// Render row
		$cap_asigna_acabados_equipo_detail_grid->RenderRow();

		// Render list options
		$cap_asigna_acabados_equipo_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_asigna_acabados_equipo_detail_grid->RowAction <> "delete" && $cap_asigna_acabados_equipo_detail_grid->RowAction <> "insertdelete" && !($cap_asigna_acabados_equipo_detail_grid->RowAction == "insert" && $cap_asigna_acabados_equipo_detail->CurrentAction == "F" && $cap_asigna_acabados_equipo_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $cap_asigna_acabados_equipo_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_asigna_acabados_equipo_detail_grid->ListOptions->Render("body", "left", $cap_asigna_acabados_equipo_detail_grid->RowCnt);
?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_asigna_acabados_equipo_detail_grid->RowCnt ?>_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo">
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSessionValue() <> "") { ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.Lists["x_Id_Articulo"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_asigna_acabados_equipo_detail_grid->PageObjName . "_row_" . $cap_asigna_acabados_equipo_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id" id="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id->OldValue) ?>">
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_EDIT || $cap_asigna_acabados_equipo_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->CellAttributes() ?>><span id="el<?php echo $cap_asigna_acabados_equipo_detail_grid->RowCnt ?>_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq">
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq"<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" id="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue) ?>">
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq"<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" id="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_asigna_acabados_equipo_detail_grid->PageObjName . "_row_" . $cap_asigna_acabados_equipo_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_asigna_acabados_equipo_detail_grid->ListOptions->Render("body", "right", $cap_asigna_acabados_equipo_detail_grid->RowCnt);
?>
	</tr>
<?php if ($cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_ADD || $cap_asigna_acabados_equipo_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.UpdateOpts(<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "gridadd" || $cap_asigna_acabados_equipo_detail->CurrentMode == "copy")
		if (!$cap_asigna_acabados_equipo_detail_grid->Recordset->EOF) $cap_asigna_acabados_equipo_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cap_asigna_acabados_equipo_detail->CurrentMode == "add" || $cap_asigna_acabados_equipo_detail->CurrentMode == "copy" || $cap_asigna_acabados_equipo_detail->CurrentMode == "edit") {
		$cap_asigna_acabados_equipo_detail_grid->RowIndex = '$rowindex$';
		$cap_asigna_acabados_equipo_detail_grid->LoadDefaultValues();

		// Set row properties
		$cap_asigna_acabados_equipo_detail->ResetAttrs();
		$cap_asigna_acabados_equipo_detail->RowAttrs = array_merge($cap_asigna_acabados_equipo_detail->RowAttrs, array('data-rowindex'=>$cap_asigna_acabados_equipo_detail_grid->RowIndex, 'id'=>'r0_cap_asigna_acabados_equipo_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_asigna_acabados_equipo_detail->RowAttrs["class"], "ewTemplate");
		$cap_asigna_acabados_equipo_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_asigna_acabados_equipo_detail_grid->RenderRow();

		// Render list options
		$cap_asigna_acabados_equipo_detail_grid->RenderListOptions();
		$cap_asigna_acabados_equipo_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cap_asigna_acabados_equipo_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_asigna_acabados_equipo_detail_grid->ListOptions->Render("body", "left", $cap_asigna_acabados_equipo_detail_grid->RowIndex);
?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el$rowindex$_cap_asigna_acabados_equipo_detail_Id_Articulo" class="cap_asigna_acabados_equipo_detail_Id_Articulo">
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "F") { ?>
<?php if ($cap_asigna_acabados_equipo_detail->Id_Articulo->getSessionValue() <> "") { ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.Lists["x_Id_Articulo"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Articulo->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Articulo->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->Visible) { // Id_Acabado_eq ?>
		<td><span id="el$rowindex$_cap_asigna_acabados_equipo_detail_Id_Acabado_eq" class="cap_asigna_acabados_equipo_detail_Id_Acabado_eq">
<?php if ($cap_asigna_acabados_equipo_detail->CurrentAction <> "F") { ?>
<select id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq"<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditAttributes() ?>>
<?php
if (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) {
	$arwrk = $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue = "";
?>
</select>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.Lists["x_Id_Acabado_eq"].Options = <?php echo (is_array($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue)) ? ew_ArrayToJson($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->EditValue, 1) : "[]" ?>;
</script>
<?php } else { ?>
<span<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_asigna_acabados_equipo_detail->Id_Acabado_eq->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" id="x<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" id="o<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>_Id_Acabado_eq" value="<?php echo ew_HtmlEncode($cap_asigna_acabados_equipo_detail->Id_Acabado_eq->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_asigna_acabados_equipo_detail_grid->ListOptions->Render("body", "right", $cap_asigna_acabados_equipo_detail_grid->RowCnt);
?>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.UpdateOpts(<?php echo $cap_asigna_acabados_equipo_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cap_asigna_acabados_equipo_detail->CurrentMode == "add" || $cap_asigna_acabados_equipo_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_asigna_acabados_equipo_detail_grid->KeyCount ?>">
<?php echo $cap_asigna_acabados_equipo_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_asigna_acabados_equipo_detail_grid->KeyCount ?>">
<?php echo $cap_asigna_acabados_equipo_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_asigna_acabados_equipo_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fcap_asigna_acabados_equipo_detailgrid">
</div>
<?php

// Close recordset
if ($cap_asigna_acabados_equipo_detail_grid->Recordset)
	$cap_asigna_acabados_equipo_detail_grid->Recordset->Close();
?>
<?php if (($cap_asigna_acabados_equipo_detail->CurrentMode == "add" || $cap_asigna_acabados_equipo_detail->CurrentMode == "copy" || $cap_asigna_acabados_equipo_detail->CurrentMode == "edit") && $cap_asigna_acabados_equipo_detail->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($cap_asigna_acabados_equipo_detail->Export == "") { ?>
<script type="text/javascript">
fcap_asigna_acabados_equipo_detailgrid.Init();
</script>
<?php } ?>
<?php
$cap_asigna_acabados_equipo_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cap_asigna_acabados_equipo_detail_grid->Page_Terminate();
$Page = &$MasterPage;
?>
