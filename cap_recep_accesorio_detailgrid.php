<?php include_once "sys_userinfo.php" ?>
<?php

// Create page object
if (!isset($cap_recep_accesorio_detail_grid)) $cap_recep_accesorio_detail_grid = new ccap_recep_accesorio_detail_grid();

// Page init
$cap_recep_accesorio_detail_grid->Page_Init();

// Page main
$cap_recep_accesorio_detail_grid->Page_Main();
?>
<?php if ($cap_recep_accesorio_detail->Export == "") { ?>
<script type="text/javascript">

// Page object
var cap_recep_accesorio_detail_grid = new ew_Page("cap_recep_accesorio_detail_grid");
cap_recep_accesorio_detail_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cap_recep_accesorio_detail_grid.PageID; // For backward compatibility

// Form object
var fcap_recep_accesorio_detailgrid = new ew_Form("fcap_recep_accesorio_detailgrid");

// Validate form
fcap_recep_accesorio_detailgrid.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_recep_accesorio_detail->Id_Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_CantRecibida"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_recep_accesorio_detail->CantRecibida->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_Unitario"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_recep_accesorio_detail->Precio_Unitario->FldErrMsg()) ?>");

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
fcap_recep_accesorio_detailgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "COD_Fam_Accesorio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Articulo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "CantRecibida", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Precio_Unitario", false)) return false;
	if (ew_ValueChanged(fobj, infix, "MontoTotal", false)) return false;
	return true;
}

// Form_CustomValidate event
fcap_recep_accesorio_detailgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_recep_accesorio_detailgrid.ValidateRequired = true;
<?php } else { ?>
fcap_recep_accesorio_detailgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_recep_accesorio_detailgrid.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":true,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_recep_accesorio_detailgrid.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":true,"DisplayFields":["x_Articulo","","",""],"ParentFields":["x_COD_Fam_Accesorio"],"FilterFields":["x_COD_Fam_Accesorio"],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cap_recep_accesorio_detail->CurrentAction == "gridadd") {
	if ($cap_recep_accesorio_detail->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$cap_recep_accesorio_detail_grid->TotalRecs = $cap_recep_accesorio_detail->SelectRecordCount();
			$cap_recep_accesorio_detail_grid->Recordset = $cap_recep_accesorio_detail_grid->LoadRecordset($cap_recep_accesorio_detail_grid->StartRec-1, $cap_recep_accesorio_detail_grid->DisplayRecs);
		} else {
			if ($cap_recep_accesorio_detail_grid->Recordset = $cap_recep_accesorio_detail_grid->LoadRecordset())
				$cap_recep_accesorio_detail_grid->TotalRecs = $cap_recep_accesorio_detail_grid->Recordset->RecordCount();
		}
		$cap_recep_accesorio_detail_grid->StartRec = 1;
		$cap_recep_accesorio_detail_grid->DisplayRecs = $cap_recep_accesorio_detail_grid->TotalRecs;
	} else {
		$cap_recep_accesorio_detail->CurrentFilter = "0=1";
		$cap_recep_accesorio_detail_grid->StartRec = 1;
		$cap_recep_accesorio_detail_grid->DisplayRecs = $cap_recep_accesorio_detail->GridAddRowCount;
	}
	$cap_recep_accesorio_detail_grid->TotalRecs = $cap_recep_accesorio_detail_grid->DisplayRecs;
	$cap_recep_accesorio_detail_grid->StopRec = $cap_recep_accesorio_detail_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cap_recep_accesorio_detail_grid->TotalRecs = $cap_recep_accesorio_detail->SelectRecordCount();
	} else {
		if ($cap_recep_accesorio_detail_grid->Recordset = $cap_recep_accesorio_detail_grid->LoadRecordset())
			$cap_recep_accesorio_detail_grid->TotalRecs = $cap_recep_accesorio_detail_grid->Recordset->RecordCount();
	}
	$cap_recep_accesorio_detail_grid->StartRec = 1;
	$cap_recep_accesorio_detail_grid->DisplayRecs = $cap_recep_accesorio_detail_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cap_recep_accesorio_detail_grid->Recordset = $cap_recep_accesorio_detail_grid->LoadRecordset($cap_recep_accesorio_detail_grid->StartRec-1, $cap_recep_accesorio_detail_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php if ($cap_recep_accesorio_detail->CurrentMode == "add" || $cap_recep_accesorio_detail->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($cap_recep_accesorio_detail->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_recep_accesorio_detail->TableCaption() ?></span></p>
</p>
<?php $cap_recep_accesorio_detail_grid->ShowPageHeader(); ?>
<?php
$cap_recep_accesorio_detail_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fcap_recep_accesorio_detailgrid" class="ewForm">
<?php if (($cap_recep_accesorio_detail->CurrentMode == "add" || $cap_recep_accesorio_detail->CurrentMode == "copy" || $cap_recep_accesorio_detail->CurrentMode == "edit") && $cap_recep_accesorio_detail->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
</div>
<?php } ?>
<div id="gmp_cap_recep_accesorio_detail" class="ewGridMiddlePanel">
<table id="tbl_cap_recep_accesorio_detailgrid" class="ewTable ewTableSeparate">
<?php echo $cap_recep_accesorio_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cap_recep_accesorio_detail_grid->RenderListOptions();

// Render list options (header, left)
$cap_recep_accesorio_detail_grid->ListOptions->Render("header", "left");
?>
<?php if ($cap_recep_accesorio_detail->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
	<?php if ($cap_recep_accesorio_detail->SortUrl($cap_recep_accesorio_detail->COD_Fam_Accesorio) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_detail_COD_Fam_Accesorio" class="cap_recep_accesorio_detail_COD_Fam_Accesorio"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_recep_accesorio_detail_COD_Fam_Accesorio" class="cap_recep_accesorio_detail_COD_Fam_Accesorio">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_detail->COD_Fam_Accesorio->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_detail->COD_Fam_Accesorio->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_detail->Id_Articulo->Visible) { // Id_Articulo ?>
	<?php if ($cap_recep_accesorio_detail->SortUrl($cap_recep_accesorio_detail->Id_Articulo) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_detail_Id_Articulo" class="cap_recep_accesorio_detail_Id_Articulo"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_detail->Id_Articulo->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_recep_accesorio_detail_Id_Articulo" class="cap_recep_accesorio_detail_Id_Articulo">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_detail->Id_Articulo->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_detail->Id_Articulo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_detail->Id_Articulo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_detail->CantRecibida->Visible) { // CantRecibida ?>
	<?php if ($cap_recep_accesorio_detail->SortUrl($cap_recep_accesorio_detail->CantRecibida) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_detail_CantRecibida" class="cap_recep_accesorio_detail_CantRecibida"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_detail->CantRecibida->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_recep_accesorio_detail_CantRecibida" class="cap_recep_accesorio_detail_CantRecibida">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_detail->CantRecibida->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_detail->CantRecibida->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_detail->CantRecibida->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_detail->Precio_Unitario->Visible) { // Precio_Unitario ?>
	<?php if ($cap_recep_accesorio_detail->SortUrl($cap_recep_accesorio_detail->Precio_Unitario) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_detail_Precio_Unitario" class="cap_recep_accesorio_detail_Precio_Unitario"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_detail->Precio_Unitario->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_recep_accesorio_detail_Precio_Unitario" class="cap_recep_accesorio_detail_Precio_Unitario">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_detail->Precio_Unitario->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_detail->Precio_Unitario->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_detail->Precio_Unitario->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($cap_recep_accesorio_detail->MontoTotal->Visible) { // MontoTotal ?>
	<?php if ($cap_recep_accesorio_detail->SortUrl($cap_recep_accesorio_detail->MontoTotal) == "") { ?>
		<td><span id="elh_cap_recep_accesorio_detail_MontoTotal" class="cap_recep_accesorio_detail_MontoTotal"><table class="ewTableHeaderBtn"><thead><tr><td><?php echo $cap_recep_accesorio_detail->MontoTotal->FldCaption() ?></td></tr></thead></table></span></td>
	<?php } else { ?>
		<td><div><span id="elh_cap_recep_accesorio_detail_MontoTotal" class="cap_recep_accesorio_detail_MontoTotal">
			<table class="ewTableHeaderBtn"><thead><tr><td class="ewTableHeaderCaption"><?php echo $cap_recep_accesorio_detail->MontoTotal->FldCaption() ?></td><td class="ewTableHeaderSort"><?php if ($cap_recep_accesorio_detail->MontoTotal->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" alt="" style="border: 0;"><?php } elseif ($cap_recep_accesorio_detail->MontoTotal->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" alt="" style="border: 0;"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cap_recep_accesorio_detail_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cap_recep_accesorio_detail_grid->StartRec = 1;
$cap_recep_accesorio_detail_grid->StopRec = $cap_recep_accesorio_detail_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($cap_recep_accesorio_detail->CurrentAction == "gridadd" || $cap_recep_accesorio_detail->CurrentAction == "gridedit" || $cap_recep_accesorio_detail->CurrentAction == "F")) {
		$cap_recep_accesorio_detail_grid->KeyCount = $objForm->GetValue("key_count");
		$cap_recep_accesorio_detail_grid->StopRec = $cap_recep_accesorio_detail_grid->KeyCount;
	}
}
$cap_recep_accesorio_detail_grid->RecCnt = $cap_recep_accesorio_detail_grid->StartRec - 1;
if ($cap_recep_accesorio_detail_grid->Recordset && !$cap_recep_accesorio_detail_grid->Recordset->EOF) {
	$cap_recep_accesorio_detail_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $cap_recep_accesorio_detail_grid->StartRec > 1)
		$cap_recep_accesorio_detail_grid->Recordset->Move($cap_recep_accesorio_detail_grid->StartRec - 1);
} elseif (!$cap_recep_accesorio_detail->AllowAddDeleteRow && $cap_recep_accesorio_detail_grid->StopRec == 0) {
	$cap_recep_accesorio_detail_grid->StopRec = $cap_recep_accesorio_detail->GridAddRowCount;
}

// Initialize aggregate
$cap_recep_accesorio_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cap_recep_accesorio_detail->ResetAttrs();
$cap_recep_accesorio_detail_grid->RenderRow();
if ($cap_recep_accesorio_detail->CurrentAction == "gridadd")
	$cap_recep_accesorio_detail_grid->RowIndex = 0;
if ($cap_recep_accesorio_detail->CurrentAction == "gridedit")
	$cap_recep_accesorio_detail_grid->RowIndex = 0;
while ($cap_recep_accesorio_detail_grid->RecCnt < $cap_recep_accesorio_detail_grid->StopRec) {
	$cap_recep_accesorio_detail_grid->RecCnt++;
	if (intval($cap_recep_accesorio_detail_grid->RecCnt) >= intval($cap_recep_accesorio_detail_grid->StartRec)) {
		$cap_recep_accesorio_detail_grid->RowCnt++;
		if ($cap_recep_accesorio_detail->CurrentAction == "gridadd" || $cap_recep_accesorio_detail->CurrentAction == "gridedit" || $cap_recep_accesorio_detail->CurrentAction == "F") {
			$cap_recep_accesorio_detail_grid->RowIndex++;
			$objForm->Index = $cap_recep_accesorio_detail_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$cap_recep_accesorio_detail_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($cap_recep_accesorio_detail->CurrentAction == "gridadd")
				$cap_recep_accesorio_detail_grid->RowAction = "insert";
			else
				$cap_recep_accesorio_detail_grid->RowAction = "";
		}

		// Set up key count
		$cap_recep_accesorio_detail_grid->KeyCount = $cap_recep_accesorio_detail_grid->RowIndex;

		// Init row class and style
		$cap_recep_accesorio_detail->ResetAttrs();
		$cap_recep_accesorio_detail->CssClass = "";
		if ($cap_recep_accesorio_detail->CurrentAction == "gridadd") {
			if ($cap_recep_accesorio_detail->CurrentMode == "copy") {
				$cap_recep_accesorio_detail_grid->LoadRowValues($cap_recep_accesorio_detail_grid->Recordset); // Load row values
				$cap_recep_accesorio_detail_grid->SetRecordKey($cap_recep_accesorio_detail_grid->RowOldKey, $cap_recep_accesorio_detail_grid->Recordset); // Set old record key
			} else {
				$cap_recep_accesorio_detail_grid->LoadDefaultValues(); // Load default values
				$cap_recep_accesorio_detail_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($cap_recep_accesorio_detail->CurrentAction == "gridedit") {
			$cap_recep_accesorio_detail_grid->LoadRowValues($cap_recep_accesorio_detail_grid->Recordset); // Load row values
		}
		$cap_recep_accesorio_detail->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cap_recep_accesorio_detail->CurrentAction == "gridadd") // Grid add
			$cap_recep_accesorio_detail->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cap_recep_accesorio_detail->CurrentAction == "gridadd" && $cap_recep_accesorio_detail->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cap_recep_accesorio_detail_grid->RestoreCurrentRowFormValues($cap_recep_accesorio_detail_grid->RowIndex); // Restore form values
		if ($cap_recep_accesorio_detail->CurrentAction == "gridedit") { // Grid edit
			if ($cap_recep_accesorio_detail->EventCancelled) {
				$cap_recep_accesorio_detail_grid->RestoreCurrentRowFormValues($cap_recep_accesorio_detail_grid->RowIndex); // Restore form values
			}
			if ($cap_recep_accesorio_detail_grid->RowAction == "insert")
				$cap_recep_accesorio_detail->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cap_recep_accesorio_detail->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cap_recep_accesorio_detail->CurrentAction == "gridedit" && ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT || $cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD) && $cap_recep_accesorio_detail->EventCancelled) // Update failed
			$cap_recep_accesorio_detail_grid->RestoreCurrentRowFormValues($cap_recep_accesorio_detail_grid->RowIndex); // Restore form values
		if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cap_recep_accesorio_detail_grid->EditRowCnt++;
		if ($cap_recep_accesorio_detail->CurrentAction == "F") // Confirm row
			$cap_recep_accesorio_detail_grid->RestoreCurrentRowFormValues($cap_recep_accesorio_detail_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cap_recep_accesorio_detail->RowAttrs = array_merge($cap_recep_accesorio_detail->RowAttrs, array('data-rowindex'=>$cap_recep_accesorio_detail_grid->RowCnt, 'id'=>'r' . $cap_recep_accesorio_detail_grid->RowCnt . '_cap_recep_accesorio_detail', 'data-rowtype'=>$cap_recep_accesorio_detail->RowType));

		// Render row
		$cap_recep_accesorio_detail_grid->RenderRow();

		// Render list options
		$cap_recep_accesorio_detail_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cap_recep_accesorio_detail_grid->RowAction <> "delete" && $cap_recep_accesorio_detail_grid->RowAction <> "insertdelete" && !($cap_recep_accesorio_detail_grid->RowAction == "insert" && $cap_recep_accesorio_detail->CurrentAction == "F" && $cap_recep_accesorio_detail_grid->EmptyRow())) {
?>
	<tr<?php echo $cap_recep_accesorio_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_recep_accesorio_detail_grid->ListOptions->Render("body", "left", $cap_recep_accesorio_detail_grid->RowCnt);
?>
	<?php if ($cap_recep_accesorio_detail->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
		<td<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_grid->RowCnt ?>_cap_recep_accesorio_detail_COD_Fam_Accesorio" class="cap_recep_accesorio_detail_COD_Fam_Accesorio">
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $cap_recep_accesorio_detail->COD_Fam_Accesorio->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $cap_recep_accesorio_detail_grid->RowIndex . "_Id_Articulo']); " . @$cap_recep_accesorio_detail->COD_Fam_Accesorio->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio"<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorio_detail->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_recep_accesorio_detail->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_detail->COD_Fam_Accesorio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_recep_accesorio_detail->COD_Fam_Accesorio->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
 $sWhereWrk = "";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Familia_Accesorio` ASC";
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorio_detail->COD_Fam_Accesorio->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Fam_Accesorio` = {filter_value}"); ?>&t0=200">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->COD_Fam_Accesorio->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->COD_Fam_Accesorio->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->COD_Fam_Accesorio->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->COD_Fam_Accesorio->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_detail_grid->PageObjName . "_row_" . $cap_recep_accesorio_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Compra_Det" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Compra_Det" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Compra_Det->CurrentValue) ?>">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Compra_Det" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Compra_Det" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Compra_Det->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT || $cap_recep_accesorio_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Compra_Det" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Compra_Det" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Compra_Det->CurrentValue) ?>">
<?php } ?>
	<?php if ($cap_recep_accesorio_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td<?php echo $cap_recep_accesorio_detail->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_grid->RowCnt ?>_cap_recep_accesorio_detail_Id_Articulo" class="cap_recep_accesorio_detail_Id_Articulo">
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php $cap_recep_accesorio_detail->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_recep_accesorio_detail->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_recep_accesorio_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorio_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_recep_accesorio_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_recep_accesorio_detail->Id_Articulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
 $sWhereWrk = "{filter}";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorio_detail->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3&f1=<?php echo TEAencrypt("`COD_Fam_Accesorio` IN ({filter_value})"); ?>&t1=200">
<?php
 $sSqlWrk = "SELECT `Precio_compra` AS FIELD0 FROM `ca_articulos`";
 $sWhereWrk = "(`Id_Articulo` = {query_value})";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Articulo` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Articulo->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php $cap_recep_accesorio_detail->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_recep_accesorio_detail->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_recep_accesorio_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorio_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_recep_accesorio_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_recep_accesorio_detail->Id_Articulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
 $sWhereWrk = "{filter}";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorio_detail->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3&f1=<?php echo TEAencrypt("`COD_Fam_Accesorio` IN ({filter_value})"); ?>&t1=200">
<?php
 $sSqlWrk = "SELECT `Precio_compra` AS FIELD0 FROM `ca_articulos`";
 $sWhereWrk = "(`Id_Articulo` = {query_value})";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Articulo` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->Id_Articulo->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Articulo->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Articulo->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_detail_grid->PageObjName . "_row_" . $cap_recep_accesorio_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td<?php echo $cap_recep_accesorio_detail->CantRecibida->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_grid->RowCnt ?>_cap_recep_accesorio_detail_CantRecibida" class="cap_recep_accesorio_detail_CantRecibida">
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" size="5" value="<?php echo $cap_recep_accesorio_detail->CantRecibida->EditValue ?>"<?php echo $cap_recep_accesorio_detail->CantRecibida->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->CantRecibida->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" size="5" value="<?php echo $cap_recep_accesorio_detail->CantRecibida->EditValue ?>"<?php echo $cap_recep_accesorio_detail->CantRecibida->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_detail->CantRecibida->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->CantRecibida->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->CantRecibida->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->CantRecibida->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_detail_grid->PageObjName . "_row_" . $cap_recep_accesorio_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_detail->Precio_Unitario->Visible) { // Precio_Unitario ?>
		<td<?php echo $cap_recep_accesorio_detail->Precio_Unitario->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_grid->RowCnt ?>_cap_recep_accesorio_detail_Precio_Unitario" class="cap_recep_accesorio_detail_Precio_Unitario">
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" size="8" value="<?php echo $cap_recep_accesorio_detail->Precio_Unitario->EditValue ?>"<?php echo $cap_recep_accesorio_detail->Precio_Unitario->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Precio_Unitario->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" size="8" value="<?php echo $cap_recep_accesorio_detail->Precio_Unitario->EditValue ?>"<?php echo $cap_recep_accesorio_detail->Precio_Unitario->EditAttributes() ?>>
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_detail->Precio_Unitario->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->Precio_Unitario->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Precio_Unitario->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Precio_Unitario->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_detail_grid->PageObjName . "_row_" . $cap_recep_accesorio_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_detail->MontoTotal->Visible) { // MontoTotal ?>
		<td<?php echo $cap_recep_accesorio_detail->MontoTotal->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_grid->RowCnt ?>_cap_recep_accesorio_detail_MontoTotal" class="cap_recep_accesorio_detail_MontoTotal">
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" size="30" value="<?php echo $cap_recep_accesorio_detail->MontoTotal->EditValue ?>"<?php echo $cap_recep_accesorio_detail->MontoTotal->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->MontoTotal->OldValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $cap_recep_accesorio_detail->MontoTotal->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->MontoTotal->EditValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->MontoTotal->CurrentValue) ?>">
<?php } ?>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cap_recep_accesorio_detail->MontoTotal->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->MontoTotal->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->MontoTotal->FormValue) ?>">
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->MontoTotal->OldValue) ?>">
<?php } ?>
</span><a id="<?php echo $cap_recep_accesorio_detail_grid->PageObjName . "_row_" . $cap_recep_accesorio_detail_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_recep_accesorio_detail_grid->ListOptions->Render("body", "right", $cap_recep_accesorio_detail_grid->RowCnt);
?>
	</tr>
<?php if ($cap_recep_accesorio_detail->RowType == EW_ROWTYPE_ADD || $cap_recep_accesorio_detail->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcap_recep_accesorio_detailgrid.UpdateOpts(<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cap_recep_accesorio_detail->CurrentAction <> "gridadd" || $cap_recep_accesorio_detail->CurrentMode == "copy")
		if (!$cap_recep_accesorio_detail_grid->Recordset->EOF) $cap_recep_accesorio_detail_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cap_recep_accesorio_detail->CurrentMode == "add" || $cap_recep_accesorio_detail->CurrentMode == "copy" || $cap_recep_accesorio_detail->CurrentMode == "edit") {
		$cap_recep_accesorio_detail_grid->RowIndex = '$rowindex$';
		$cap_recep_accesorio_detail_grid->LoadDefaultValues();

		// Set row properties
		$cap_recep_accesorio_detail->ResetAttrs();
		$cap_recep_accesorio_detail->RowAttrs = array_merge($cap_recep_accesorio_detail->RowAttrs, array('data-rowindex'=>$cap_recep_accesorio_detail_grid->RowIndex, 'id'=>'r0_cap_recep_accesorio_detail', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cap_recep_accesorio_detail->RowAttrs["class"], "ewTemplate");
		$cap_recep_accesorio_detail->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cap_recep_accesorio_detail_grid->RenderRow();

		// Render list options
		$cap_recep_accesorio_detail_grid->RenderListOptions();
		$cap_recep_accesorio_detail_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cap_recep_accesorio_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cap_recep_accesorio_detail_grid->ListOptions->Render("body", "left", $cap_recep_accesorio_detail_grid->RowIndex);
?>
	<?php if ($cap_recep_accesorio_detail->COD_Fam_Accesorio->Visible) { // COD_Fam_Accesorio ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_detail_COD_Fam_Accesorio" class="cap_recep_accesorio_detail_COD_Fam_Accesorio">
<?php if ($cap_recep_accesorio_detail->CurrentAction <> "F") { ?>
<?php $cap_recep_accesorio_detail->COD_Fam_Accesorio->EditAttrs["onchange"] = "ew_UpdateOpt.call(this, ['x" . $cap_recep_accesorio_detail_grid->RowIndex . "_Id_Articulo']); " . @$cap_recep_accesorio_detail->COD_Fam_Accesorio->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio"<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorio_detail->COD_Fam_Accesorio->EditValue)) {
	$arwrk = $cap_recep_accesorio_detail->COD_Fam_Accesorio->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_detail->COD_Fam_Accesorio->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_recep_accesorio_detail->COD_Fam_Accesorio->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
 $sWhereWrk = "";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Familia_Accesorio` ASC";
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorio_detail->COD_Fam_Accesorio->LookupFn) ?>&f0=<?php echo TEAencrypt("`COD_Fam_Accesorio` = {filter_value}"); ?>&t0=200">
<?php } else { ?>
<span<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->COD_Fam_Accesorio->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_COD_Fam_Accesorio" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->COD_Fam_Accesorio->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_detail->Id_Articulo->Visible) { // Id_Articulo ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_detail_Id_Articulo" class="cap_recep_accesorio_detail_Id_Articulo">
<?php if ($cap_recep_accesorio_detail->CurrentAction <> "F") { ?>
<?php $cap_recep_accesorio_detail->Id_Articulo->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$cap_recep_accesorio_detail->Id_Articulo->EditAttrs["onchange"]; ?>
<select id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo"<?php echo $cap_recep_accesorio_detail->Id_Articulo->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorio_detail->Id_Articulo->EditValue)) {
	$arwrk = $cap_recep_accesorio_detail->Id_Articulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio_detail->Id_Articulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cap_recep_accesorio_detail->Id_Articulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
 $sWhereWrk = "{filter}";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Articulo` Asc";
?>
<input type="hidden" name="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="s_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($cap_recep_accesorio_detail->Id_Articulo->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Articulo` = {filter_value}"); ?>&t0=3&f1=<?php echo TEAencrypt("`COD_Fam_Accesorio` IN ({filter_value})"); ?>&t1=200">
<?php
 $sSqlWrk = "SELECT `Precio_compra` AS FIELD0 FROM `ca_articulos`";
 $sWhereWrk = "(`Id_Articulo` = {query_value})";
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
 $sSqlWrk .= " ORDER BY `Articulo` Asc";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="sf_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="ln_x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario">
<?php } else { ?>
<span<?php echo $cap_recep_accesorio_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->Id_Articulo->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Articulo->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Id_Articulo->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_detail->CantRecibida->Visible) { // CantRecibida ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_detail_CantRecibida" class="cap_recep_accesorio_detail_CantRecibida">
<?php if ($cap_recep_accesorio_detail->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" size="5" value="<?php echo $cap_recep_accesorio_detail->CantRecibida->EditValue ?>"<?php echo $cap_recep_accesorio_detail->CantRecibida->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_recep_accesorio_detail->CantRecibida->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->CantRecibida->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->CantRecibida->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_CantRecibida" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->CantRecibida->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_detail->Precio_Unitario->Visible) { // Precio_Unitario ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_detail_Precio_Unitario" class="cap_recep_accesorio_detail_Precio_Unitario">
<?php if ($cap_recep_accesorio_detail->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" size="8" value="<?php echo $cap_recep_accesorio_detail->Precio_Unitario->EditValue ?>"<?php echo $cap_recep_accesorio_detail->Precio_Unitario->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_recep_accesorio_detail->Precio_Unitario->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->Precio_Unitario->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Precio_Unitario->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_Precio_Unitario" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->Precio_Unitario->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($cap_recep_accesorio_detail->MontoTotal->Visible) { // MontoTotal ?>
		<td><span id="el$rowindex$_cap_recep_accesorio_detail_MontoTotal" class="cap_recep_accesorio_detail_MontoTotal">
<?php if ($cap_recep_accesorio_detail->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" size="30" value="<?php echo $cap_recep_accesorio_detail->MontoTotal->EditValue ?>"<?php echo $cap_recep_accesorio_detail->MontoTotal->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $cap_recep_accesorio_detail->MontoTotal->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->MontoTotal->ViewValue ?></span>
<input type="hidden" name="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="x<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->MontoTotal->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" id="o<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>_MontoTotal" value="<?php echo ew_HtmlEncode($cap_recep_accesorio_detail->MontoTotal->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$cap_recep_accesorio_detail_grid->ListOptions->Render("body", "right", $cap_recep_accesorio_detail_grid->RowCnt);
?>
<script type="text/javascript">
fcap_recep_accesorio_detailgrid.UpdateOpts(<?php echo $cap_recep_accesorio_detail_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cap_recep_accesorio_detail->CurrentMode == "add" || $cap_recep_accesorio_detail->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_recep_accesorio_detail_grid->KeyCount ?>">
<?php echo $cap_recep_accesorio_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_recep_accesorio_detail->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $cap_recep_accesorio_detail_grid->KeyCount ?>">
<?php echo $cap_recep_accesorio_detail_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cap_recep_accesorio_detail->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fcap_recep_accesorio_detailgrid">
</div>
<?php

// Close recordset
if ($cap_recep_accesorio_detail_grid->Recordset)
	$cap_recep_accesorio_detail_grid->Recordset->Close();
?>
<?php if (($cap_recep_accesorio_detail->CurrentMode == "add" || $cap_recep_accesorio_detail->CurrentMode == "copy" || $cap_recep_accesorio_detail->CurrentMode == "edit") && $cap_recep_accesorio_detail->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridLowerPanel">
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($cap_recep_accesorio_detail->Export == "") { ?>
<script type="text/javascript">
fcap_recep_accesorio_detailgrid.Init();
</script>
<?php } ?>
<?php
$cap_recep_accesorio_detail_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cap_recep_accesorio_detail_grid->Page_Terminate();
$Page = &$MasterPage;
?>
