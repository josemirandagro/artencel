<?php include_once "sys_userinfo.php" ?>
<?php

// Create page object
if (!isset($cap_gen_barcode_accesorios_detail_grid)) $cap_gen_barcode_accesorios_detail_grid = new ccap_gen_barcode_accesorios_detail_grid();

// Page init
$cap_gen_barcode_accesorios_detail_grid->Page_Init();

// Page main
$cap_gen_barcode_accesorios_detail_grid->Page_Main();
?>
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_gen_barcode_accesorios_detail_grid = new ew_Page("cap_gen_barcode_accesorios_detail_grid");
cap_gen_barcode_accesorios_detail_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cap_gen_barcode_accesorios_detail_grid.PageID; // For backward compatibility

// Form object
var fcap_gen_barcode_accesorios_detailgrid = new ew_Form("fcap_gen_barcode_accesorios_detailgrid");

// Validate form
fcap_gen_barcode_accesorios_detailgrid.Validate = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_gen_barcode_accesorios_detail->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_gen_barcode_accesorios_detail->Codigo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_CantRecibida"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_gen_barcode_accesorios_detail->CantRecibida->FldErrMsg()) ?>");

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
fcap_gen_barcode_accesorios_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Articulo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Codigo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "CantRecibida", false)) return false;
	return true;
}

// Form_CustomValidate event
fcap_gen_barcode_accesorios_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_gen_barcode_accesorios_detailgrid.ValidateRequired = true;
<?php } else { ?>
fcap_gen_barcode_accesorios_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd") {
	if ($cap_gen_barcode_accesorios_detail->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cap_gen_barcode_accesorios_detail_grid->TotalRecs = $cap_gen_barcode_accesorios_detail->SelectRecordCount();
			$cap_gen_barcode_accesorios_detail_grid->Recordset = $cap_gen_barcode_accesorios_detail_grid->LoadRecordset($cap_gen_barcode_accesorios_detail_grid->StartRec-1, $cap_gen_barcode_accesorios_detail_grid->DisplayRecs);
		} else {
			if ($cap_gen_barcode_accesorios_detail_grid->Recordset = $cap_gen_barcode_accesorios_detail_grid->LoadRecordset())
				$cap_gen_barcode_accesorios_detail_grid->TotalRecs = $cap_gen_barcode_accesorios_detail_grid->Recordset->RecordCount();
		}
		$cap_gen_barcode_accesorios_detail_grid->StartRec = 1;
		$cap_gen_barcode_accesorios_detail_grid->DisplayRecs = $cap_gen_barcode_accesorios_detail_grid->TotalRecs;
	} else {
		$cap_gen_barcode_accesorios_detail->CurrentFilter = "0=1";
		$cap_gen_barcode_accesorios_detail_grid->StartRec = 1;
		$cap_gen_barcode_accesorios_detail_grid->DisplayRecs = $cap_gen_barcode_accesorios_detail->GridAddRowCount;
	}
	$cap_gen_barcode_accesorios_detail_grid->TotalRecs = $cap_gen_barcode_accesorios_detail_grid->DisplayRecs;
	$cap_gen_barcode_accesorios_detail_grid->StopRec = $cap_gen_barcode_accesorios_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_gen_barcode_accesorios_detail_grid->TotalRecs = $cap_gen_barcode_accesorios_detail->SelectRecordCount();
	} else {
		if ($cap_gen_barcode_accesorios_detail_grid->Recordset = $cap_gen_barcode_accesorios_detail_grid->LoadRecordset())
			$cap_gen_barcode_accesorios_detail_grid->TotalRecs = $cap_gen_barcode_accesorios_detail_grid->Recordset->RecordCount();
	}
	$cap_gen_barcode_accesorios_detail_grid->StartRec = 1;
	$cap_gen_barcode_accesorios_detail_grid->DisplayRecs = $cap_gen_barcode_accesorios_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cap_gen_barcode_accesorios_detail_grid->Recordset = $cap_gen_barcode_accesorios_detail_grid->LoadRecordset($cap_gen_barcode_accesorios_detail_grid->StartRec-1, $cap_gen_barcode_accesorios_detail_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php if ($cap_gen_barcode_accesorios_detail->CurrentMode == "add" || $cap_gen_barcode_accesorios_detail->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cap_gen_barcode_accesorios_detail->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_gen_barcode_accesorios_detail->TableCaption() ?></span></p>
</p>
<?php $cap_gen_barcode_accesorios_detail_grid->ShowPageHeader(); ?>
<?php
$cap_gen_barcode_accesorios_detail_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fcap_gen_barcode_accesorios_detailgrid" class="ewForm">
<?php if (($cap_gen_barcode_accesorios_detail->CurrentMode == "add" || $cap_gen_barcode_accesorios_detail->CurrentMode == "copy" || $cap_gen_barcode_accesorios_detail->CurrentMode == "edit") && $cap_gen_barcode_accesorios_detail->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
</div>
<?php } ?>
<div id="gmp_cap_gen_barcode_accesorios_detail" class="ewGridMiddlePanel">
<table id="tbl_cap_gen_barcode_accesorios_detailgrid" class="ewTable ewTableSeparate">
<?php echo $cap_gen_barcode_accesorios_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_gen_barcode_accesorios_detail_grid->RenderListOptions();

// Render list options (header, left)
$cap_gen_barcode_accesorios_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($cap_gen_barcode_accesorios_detail->Articulo->Visible) { // Articulo ?>
	<?php if ($cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->Articulo) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_detail_Articulo" class="cap_gen_barcode_accesorios_detail_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios_detail->Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_gen_barcode_accesorios_detail_Articulo" class="cap_gen_barcode_accesorios_detail_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios_detail->Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios_detail->Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios_detail->Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_gen_barcode_accesorios_detail->Codigo->Visible) { // Codigo ?>
	<?php if ($cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->Codigo) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_detail_Codigo" class="cap_gen_barcode_accesorios_detail_Codigo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios_detail->Codigo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_gen_barcode_accesorios_detail_Codigo" class="cap_gen_barcode_accesorios_detail_Codigo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios_detail->Codigo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios_detail->Codigo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios_detail->Codigo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_gen_barcode_accesorios_detail->CantRecibida->Visible) { // CantRecibida ?>
	<?php if ($cap_gen_barcode_accesorios_detail->SortUrl($cap_gen_barcode_accesorios_detail->CantRecibida) == "") { ?>
		<td><span id="elh_cap_gen_barcode_accesorios_detail_CantRecibida" class="cap_gen_barcode_accesorios_detail_CantRecibida"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_gen_barcode_accesorios_detail_CantRecibida" class="cap_gen_barcode_accesorios_detail_CantRecibida">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_gen_barcode_accesorios_detail->CantRecibida->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_gen_barcode_accesorios_detail->CantRecibida->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_gen_barcode_accesorios_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cap_gen_barcode_accesorios_detail_grid->StartRec = 1;
$cap_gen_barcode_accesorios_detail_grid->StopRec = $cap_gen_barcode_accesorios_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd" || $cap_gen_barcode_accesorios_detail->CurrentAction == "gridedit" || $cap_gen_barcode_accesorios_detail->CurrentAction == "F")) {
		$cap_gen_barcode_accesorios_detail_grid->KeyCount = $objForm->GetValue("key_count");
		$cap_gen_barcode_accesorios_detail_grid->StopRec = $cap_gen_barcode_accesorios_detail_grid->KeyCount;
	}
}
$cap_gen_barcode_accesorios_detail_grid->RecCnt = $cap_gen_barcode_accesorios_detail_grid->StartRec - 1;
if ($cap_gen_barcode_accesorios_detail_grid->Recordset && !$cap_gen_barcode_accesorios_detail_grid->Recordset->EOF) {
	$cap_gen_barcode_accesorios_detail_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_gen_barcode_accesorios_detail_grid->StartRec > 1)
		$cap_gen_barcode_accesorios_detail_grid->Recordset->Move($cap_gen_barcode_accesorios_detail_grid->StartRec - 1);
} elseif (!$cap_gen_barcode_accesorios_detail->AllowAddDeleteRow && $cap_gen_barcode_accesorios_detail_grid->StopRec == 0) {
	$cap_gen_barcode_accesorios_detail_grid->StopRec = $cap_gen_barcode_accesorios_detail->GridAddRowCount;
}

// Initialize aggregate
$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_gen_barcode_accesorios_detail->ResetAttrs();
$cap_gen_barcode_accesorios_detail_grid->RenderRow();
if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd")
	$cap_gen_barcode_accesorios_detail_grid->RowIndex = 0;
if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridedit")
	$cap_gen_barcode_accesorios_detail_grid->RowIndex = 0;
while ($cap_gen_barcode_accesorios_detail_grid->RecCnt < $cap_gen_barcode_accesorios_detail_grid->StopRec) {
	$cap_gen_barcode_accesorios_detail_grid->RecCnt++;
	if (intval($cap_gen_barcode_accesorios_detail_grid->RecCnt) >= intval($cap_gen_barcode_accesorios_detail_grid->StartRec)) {
		$cap_gen_barcode_accesorios_detail_grid->RowCnt++;
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd" || $cap_gen_barcode_accesorios_detail->CurrentAction == "gridedit" || $cap_gen_barcode_accesorios_detail->CurrentAction == "F") {
			$cap_gen_barcode_accesorios_detail_grid->RowIndex++;
			$objForm->Index = $cap_gen_barcode_accesorios_detail_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_gen_barcode_accesorios_detail_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd")
				$cap_gen_barcode_accesorios_detail_grid->RowAction = "insert";
			else
				$cap_gen_barcode_accesorios_detail_grid->RowAction = "";
		}

		// Set up key count
		$cap_gen_barcode_accesorios_detail_grid->KeyCount = $cap_gen_barcode_accesorios_detail_grid->RowIndex;

		// Init row class and style
		$cap_gen_barcode_accesorios_detail->ResetAttrs();
		$cap_gen_barcode_accesorios_detail->CssClass = "";
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd") {
			if ($cap_gen_barcode_accesorios_detail->CurrentMode == "copy") {
				$cap_gen_barcode_accesorios_detail_grid->LoadRowValues($cap_gen_barcode_accesorios_detail_grid->Recordset); // Load row values
				$cap_gen_barcode_accesorios_detail_grid->SetRecordKey($cap_gen_barcode_accesorios_detail_grid->RowOldKey, $cap_gen_barcode_accesorios_detail_grid->Recordset); // Set old record key
			} else {
				$cap_gen_barcode_accesorios_detail_grid->LoadDefaultValues(); // Load default values
				$cap_gen_barcode_accesorios_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridedit") {
			$cap_gen_barcode_accesorios_detail_grid->LoadRowValues($cap_gen_barcode_accesorios_detail_grid->Recordset); // Load row values
		}
		$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd") // Grid add
			$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridadd" && $cap_gen_barcode_accesorios_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cap_gen_barcode_accesorios_detail_grid->RestoreCurrentRowFormValues($cap_gen_barcode_accesorios_detail_grid->RowIndex); // Restore form values
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridedit") { // Grid edit
			if ($cap_gen_barcode_accesorios_detail->EventCancelled) {
				$cap_gen_barcode_accesorios_detail_grid->RestoreCurrentRowFormValues($cap_gen_barcode_accesorios_detail_grid->RowIndex); // Restore form values
			}
			if ($cap_gen_barcode_accesorios_detail_grid->RowAction == "insert")
				$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "gridedit" && ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_EDIT || $cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_ADD) && $cap_gen_barcode_accesorios_detail->EventCancelled) // Update failed
			$cap_gen_barcode_accesorios_detail_grid->RestoreCurrentRowFormValues($cap_gen_barcode_accesorios_detail_grid->RowIndex); // Restore form values
		if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_gen_barcode_accesorios_detail_grid->EditRowCnt++;
		if ($cap_gen_barcode_accesorios_detail->CurrentAction == "F") // Confirm row
			$cap_gen_barcode_accesorios_detail_grid->RestoreCurrentRowFormValues($cap_gen_barcode_accesorios_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cap_gen_barcode_accesorios_detail->RowAttrs = array_merge($cap_gen_barcode_accesorios_detail->RowAttrs, array('data-rowindex'=>$cap_gen_barcode_accesorios_detail_grid->RowCnt, 'id'=>'r' . $cap_gen_barcode_accesorios_detail_grid->RowCnt . '_cap_gen_barcode_accesorios_detail', 'data-rowtype'=>$cap_gen_barcode_accesorios_detail->RowType));

		// Render row
		$cap_gen_barcode_accesorios_detail_grid->RenderRow();

		// Render list options
		$cap_gen_barcode_accesorios_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_gen_barcode_accesorios_detail_grid->RowAction <> "delete" && $cap_gen_barcode_accesorios_detail_grid->RowAction <> "insertdelete" && !($cap_gen_barcode_accesorios_detail_grid->RowAction == "insert" && $cap_gen_barcode_accesorios_detail->CurrentAction == "F" && $cap_gen_barcode_accesorios_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $cap_gen_barcode_accesorios_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_gen_barcode_accesorios_detail_grid->ListOptions->Render("body", "left", $cap_gen_barcode_accesorios_detail_grid->RowCnt);
?>
	<?php if ($cap_gen_barcode_accesorios_detail->Articulo->Visible) { // Articulo ?>
		<td<?php echo $cap_gen_barcode_accesorios_detail->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_detail_grid->RowCnt ?>_cap_gen_barcode_accesorios_detail_Articulo" class="cap_gen_barcode_accesorios_detail_Articulo">
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" size="30" maxlength="100" value="<?php echo $cap_gen_barcode_accesorios_detail->Articulo->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->Articulo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" size="30" maxlength="100" value="<?php echo $cap_gen_barcode_accesorios_detail->Articulo->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->Articulo->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_gen_barcode_accesorios_detail->Articulo->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->Articulo->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Articulo->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Articulo->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_gen_barcode_accesorios_detail_grid->PageObjName . "_row_" . $cap_gen_barcode_accesorios_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Id_Compra_Det" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Id_Compra_Det" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Id_Compra_Det->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Id_Compra_Det" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Id_Compra_Det" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Id_Compra_Det->OldValue) ?>">
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_EDIT || $cap_gen_barcode_accesorios_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Id_Compra_Det" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Id_Compra_Det" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Id_Compra_Det->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail->Codigo->Visible) { // Codigo ?>
		<td<?php echo $cap_gen_barcode_accesorios_detail->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_detail_grid->RowCnt ?>_cap_gen_barcode_accesorios_detail_Codigo" class="cap_gen_barcode_accesorios_detail_Codigo">
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" size="30" maxlength="22" value="<?php echo $cap_gen_barcode_accesorios_detail->Codigo->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->Codigo->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Codigo->OldValue) ?>">
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" size="30" maxlength="22" value="<?php echo $cap_gen_barcode_accesorios_detail->Codigo->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->Codigo->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_gen_barcode_accesorios_detail->Codigo->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->Codigo->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Codigo->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Codigo->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_gen_barcode_accesorios_detail_grid->PageObjName . "_row_" . $cap_gen_barcode_accesorios_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->CellAttributes() ?>><span id="el<?php echo $cap_gen_barcode_accesorios_detail_grid->RowCnt ?>_cap_gen_barcode_accesorios_detail_CantRecibida" class="cap_gen_barcode_accesorios_detail_CantRecibida">
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" size="30" value="<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->CantRecibida->OldValue) ?>">
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" size="30" value="<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->CantRecibida->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->CantRecibida->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_gen_barcode_accesorios_detail_grid->PageObjName . "_row_" . $cap_gen_barcode_accesorios_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_gen_barcode_accesorios_detail_grid->ListOptions->Render("body", "right", $cap_gen_barcode_accesorios_detail_grid->RowCnt);
?>
	</tr>
<?php if ($cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_ADD || $cap_gen_barcode_accesorios_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_gen_barcode_accesorios_detailgrid.UpdateOpts(<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_gen_barcode_accesorios_detail->CurrentAction <> "gridadd" || $cap_gen_barcode_accesorios_detail->CurrentMode == "copy")
		if (!$cap_gen_barcode_accesorios_detail_grid->Recordset->EOF) $cap_gen_barcode_accesorios_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cap_gen_barcode_accesorios_detail->CurrentMode == "add" || $cap_gen_barcode_accesorios_detail->CurrentMode == "copy" || $cap_gen_barcode_accesorios_detail->CurrentMode == "edit") {
		$cap_gen_barcode_accesorios_detail_grid->RowIndex = '$rowindex$';
		$cap_gen_barcode_accesorios_detail_grid->LoadDefaultValues();

		// Set row properties
		$cap_gen_barcode_accesorios_detail->ResetAttrs();
		$cap_gen_barcode_accesorios_detail->RowAttrs = array_merge($cap_gen_barcode_accesorios_detail->RowAttrs, array('data-rowindex'=>$cap_gen_barcode_accesorios_detail_grid->RowIndex, 'id'=>'r0_cap_gen_barcode_accesorios_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_gen_barcode_accesorios_detail->RowAttrs["class"], "ewTemplate");
		$cap_gen_barcode_accesorios_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_gen_barcode_accesorios_detail_grid->RenderRow();

		// Render list options
		$cap_gen_barcode_accesorios_detail_grid->RenderListOptions();
		$cap_gen_barcode_accesorios_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cap_gen_barcode_accesorios_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_gen_barcode_accesorios_detail_grid->ListOptions->Render("body", "left", $cap_gen_barcode_accesorios_detail_grid->RowIndex);
?>
	<?php if ($cap_gen_barcode_accesorios_detail->Articulo->Visible) { // Articulo ?>
		<td><span id="el$rowindex$_cap_gen_barcode_accesorios_detail_Articulo" class="cap_gen_barcode_accesorios_detail_Articulo">
<?php if ($cap_gen_barcode_accesorios_detail->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" size="30" maxlength="100" value="<?php echo $cap_gen_barcode_accesorios_detail->Articulo->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->Articulo->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_gen_barcode_accesorios_detail->Articulo->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->Articulo->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Articulo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Articulo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail->Codigo->Visible) { // Codigo ?>
		<td><span id="el$rowindex$_cap_gen_barcode_accesorios_detail_Codigo" class="cap_gen_barcode_accesorios_detail_Codigo">
<?php if ($cap_gen_barcode_accesorios_detail->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" size="30" maxlength="22" value="<?php echo $cap_gen_barcode_accesorios_detail->Codigo->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->Codigo->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_gen_barcode_accesorios_detail->Codigo->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->Codigo->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Codigo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_Codigo" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->Codigo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_gen_barcode_accesorios_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td><span id="el$rowindex$_cap_gen_barcode_accesorios_detail_CantRecibida" class="cap_gen_barcode_accesorios_detail_CantRecibida">
<?php if ($cap_gen_barcode_accesorios_detail->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" size="30" value="<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->EditValue ?>"<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios_detail->CantRecibida->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->CantRecibida->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" id="o<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios_detail->CantRecibida->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_gen_barcode_accesorios_detail_grid->ListOptions->Render("body", "right", $cap_gen_barcode_accesorios_detail_grid->RowCnt);
?>
<script type="text/javascript">
fcap_gen_barcode_accesorios_detailgrid.UpdateOpts(<?php echo $cap_gen_barcode_accesorios_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cap_gen_barcode_accesorios_detail->CurrentMode == "add" || $cap_gen_barcode_accesorios_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_gen_barcode_accesorios_detail_grid->KeyCount ?>">
<?php echo $cap_gen_barcode_accesorios_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_gen_barcode_accesorios_detail_grid->KeyCount ?>">
<?php echo $cap_gen_barcode_accesorios_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fcap_gen_barcode_accesorios_detailgrid">
</div>
<?php

// Close recordset
if ($cap_gen_barcode_accesorios_detail_grid->Recordset)
	$cap_gen_barcode_accesorios_detail_grid->Recordset->Close();
?>
<?php if (($cap_gen_barcode_accesorios_detail->CurrentMode == "add" || $cap_gen_barcode_accesorios_detail->CurrentMode == "copy" || $cap_gen_barcode_accesorios_detail->CurrentMode == "edit") && $cap_gen_barcode_accesorios_detail->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($cap_gen_barcode_accesorios_detail->Export == "") { ?>
<script type="text/javascript">
fcap_gen_barcode_accesorios_detailgrid.Init();
</script>
<?php } ?>
<?php
$cap_gen_barcode_accesorios_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cap_gen_barcode_accesorios_detail_grid->Page_Terminate();
$Page = &$MasterPage;
?>
