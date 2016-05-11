<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_recep_accesorio_detailinfo.php" ?>
<?php include_once "cap_recep_accesorioinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_recep_accesorio_detail_delete = NULL; // Initialize page object first

class ccap_recep_accesorio_detail_delete extends ccap_recep_accesorio_detail {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_recep_accesorio_detail';

	// Page object name
	var $PageObjName = 'cap_recep_accesorio_detail_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			$html .= "<p class=\"ewMessage\">" . $sMessage . "</p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewWarningIcon\"></td><td class=\"ewWarningMessage\">" . $sWarningMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewSuccessIcon\"></td><td class=\"ewSuccessMessage\">" . $sSuccessMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewErrorIcon\"></td><td class=\"ewErrorMessage\">" . $sErrorMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p class=\"phpmaker\">" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p class=\"phpmaker\">" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (cap_recep_accesorio_detail)
		if (!isset($GLOBALS["cap_recep_accesorio_detail"])) {
			$GLOBALS["cap_recep_accesorio_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_recep_accesorio_detail"];
		}

		// Table object (cap_recep_accesorio)
		if (!isset($GLOBALS['cap_recep_accesorio'])) $GLOBALS['cap_recep_accesorio'] = new ccap_recep_accesorio();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_recep_accesorio_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("cap_recep_accesorio_detaillist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("cap_recep_accesorio_detaillist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cap_recep_accesorio_detail class, cap_recep_accesorio_detailinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->Id_Compra_Det->setDbValue($rs->fields('Id_Compra_Det'));
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->COD_Fam_Accesorio->setDbValue($rs->fields('COD_Fam_Accesorio'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		if (array_key_exists('EV__Id_Articulo', $rs->fields)) {
			$this->Id_Articulo->VirtualValue = $rs->fields('EV__Id_Articulo'); // Set up virtual field value
		} else {
			$this->Id_Articulo->VirtualValue = ""; // Clear value
		}
		$this->CantRecibida->setDbValue($rs->fields('CantRecibida'));
		$this->Precio_Unitario->setDbValue($rs->fields('Precio_Unitario'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->MontoTotal->setDbValue($rs->fields('MontoTotal'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Precio_Unitario->FormValue == $this->Precio_Unitario->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_Unitario->CurrentValue)))
			$this->Precio_Unitario->CurrentValue = ew_StrToFloat($this->Precio_Unitario->CurrentValue);

		// Convert decimal values if posted back
		if ($this->MontoTotal->FormValue == $this->MontoTotal->CurrentValue && is_numeric(ew_StrToFloat($this->MontoTotal->CurrentValue)))
			$this->MontoTotal->CurrentValue = ew_StrToFloat($this->MontoTotal->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Compra_Det

		$this->Id_Compra_Det->CellCssStyle = "white-space: nowrap;";

		// Id_Compra
		$this->Id_Compra->CellCssStyle = "white-space: nowrap;";

		// COD_Fam_Accesorio
		// Id_Articulo
		// CantRecibida
		// Precio_Unitario
		// TipoArticulo

		$this->TipoArticulo->CellCssStyle = "white-space: nowrap;";

		// MontoTotal
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// COD_Fam_Accesorio
			if (strval($this->COD_Fam_Accesorio->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Fam_Accesorio`" . ew_SearchString("=", $this->COD_Fam_Accesorio->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Fam_Accesorio`, `Familia_Accesorio` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_familia_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Familia_Accesorio` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Fam_Accesorio->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Fam_Accesorio->ViewValue = $this->COD_Fam_Accesorio->CurrentValue;
				}
			} else {
				$this->COD_Fam_Accesorio->ViewValue = NULL;
			}
			$this->COD_Fam_Accesorio->ViewCustomAttributes = "";

			// Id_Articulo
			if ($this->Id_Articulo->VirtualValue <> "") {
				$this->Id_Articulo->ViewValue = $this->Id_Articulo->VirtualValue;
			} else {
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Articulo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
				}
			} else {
				$this->Id_Articulo->ViewValue = NULL;
			}
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// CantRecibida
			$this->CantRecibida->ViewValue = $this->CantRecibida->CurrentValue;
			$this->CantRecibida->ViewCustomAttributes = "";

			// Precio_Unitario
			$this->Precio_Unitario->ViewValue = $this->Precio_Unitario->CurrentValue;
			$this->Precio_Unitario->ViewValue = ew_FormatCurrency($this->Precio_Unitario->ViewValue, 2, -2, -2, -2);
			$this->Precio_Unitario->ViewCustomAttributes = "";

			// MontoTotal
			$this->MontoTotal->ViewValue = $this->MontoTotal->CurrentValue;
			$this->MontoTotal->ViewValue = ew_FormatCurrency($this->MontoTotal->ViewValue, 2, -2, -2, -2);
			$this->MontoTotal->ViewCustomAttributes = "";

			// COD_Fam_Accesorio
			$this->COD_Fam_Accesorio->LinkCustomAttributes = "";
			$this->COD_Fam_Accesorio->HrefValue = "";
			$this->COD_Fam_Accesorio->TooltipValue = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// CantRecibida
			$this->CantRecibida->LinkCustomAttributes = "";
			$this->CantRecibida->HrefValue = "";
			$this->CantRecibida->TooltipValue = "";

			// Precio_Unitario
			$this->Precio_Unitario->LinkCustomAttributes = "";
			$this->Precio_Unitario->HrefValue = "";
			$this->Precio_Unitario->TooltipValue = "";

			// MontoTotal
			$this->MontoTotal->LinkCustomAttributes = "";
			$this->MontoTotal->HrefValue = "";
			$this->MontoTotal->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		} else {
			$this->LoadRowValues($rs); // Load row values
		}
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id_Compra_Det'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cap_recep_accesorio_detail_delete)) $cap_recep_accesorio_detail_delete = new ccap_recep_accesorio_detail_delete();

// Page init
$cap_recep_accesorio_detail_delete->Page_Init();

// Page main
$cap_recep_accesorio_detail_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_recep_accesorio_detail_delete = new ew_Page("cap_recep_accesorio_detail_delete");
cap_recep_accesorio_detail_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = cap_recep_accesorio_detail_delete.PageID; // For backward compatibility

// Form object
var fcap_recep_accesorio_detaildelete = new ew_Form("fcap_recep_accesorio_detaildelete");

// Form_CustomValidate event
fcap_recep_accesorio_detaildelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_recep_accesorio_detaildelete.ValidateRequired = true;
<?php } else { ?>
fcap_recep_accesorio_detaildelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_recep_accesorio_detaildelete.Lists["x_COD_Fam_Accesorio"] = {"LinkField":"x_COD_Fam_Accesorio","Ajax":true,"AutoFill":false,"DisplayFields":["x_Familia_Accesorio","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_recep_accesorio_detaildelete.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($cap_recep_accesorio_detail_delete->Recordset = $cap_recep_accesorio_detail_delete->LoadRecordset())
	$cap_recep_accesorio_detail_deleteTotalRecs = $cap_recep_accesorio_detail_delete->Recordset->RecordCount(); // Get record count
if ($cap_recep_accesorio_detail_deleteTotalRecs <= 0) { // No record found, exit
	if ($cap_recep_accesorio_detail_delete->Recordset)
		$cap_recep_accesorio_detail_delete->Recordset->Close();
	$cap_recep_accesorio_detail_delete->Page_Terminate("cap_recep_accesorio_detaillist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_recep_accesorio_detail->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_recep_accesorio_detail->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_recep_accesorio_detail_delete->ShowPageHeader(); ?>
<?php
$cap_recep_accesorio_detail_delete->ShowMessage();
?>
<form name="fcap_recep_accesorio_detaildelete" id="fcap_recep_accesorio_detaildelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="cap_recep_accesorio_detail">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cap_recep_accesorio_detail_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_recep_accesorio_detaildelete" class="ewTable ewTableSeparate">
<?php echo $cap_recep_accesorio_detail->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_cap_recep_accesorio_detail_COD_Fam_Accesorio" class="cap_recep_accesorio_detail_COD_Fam_Accesorio"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_recep_accesorio_detail_Id_Articulo" class="cap_recep_accesorio_detail_Id_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio_detail->Id_Articulo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_recep_accesorio_detail_CantRecibida" class="cap_recep_accesorio_detail_CantRecibida"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio_detail->CantRecibida->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_recep_accesorio_detail_Precio_Unitario" class="cap_recep_accesorio_detail_Precio_Unitario"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio_detail->Precio_Unitario->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_recep_accesorio_detail_MontoTotal" class="cap_recep_accesorio_detail_MontoTotal"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio_detail->MontoTotal->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$cap_recep_accesorio_detail_delete->RecCnt = 0;
$i = 0;
while (!$cap_recep_accesorio_detail_delete->Recordset->EOF) {
	$cap_recep_accesorio_detail_delete->RecCnt++;
	$cap_recep_accesorio_detail_delete->RowCnt++;

	// Set row properties
	$cap_recep_accesorio_detail->ResetAttrs();
	$cap_recep_accesorio_detail->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cap_recep_accesorio_detail_delete->LoadRowValues($cap_recep_accesorio_detail_delete->Recordset);

	// Render row
	$cap_recep_accesorio_detail_delete->RenderRow();
?>
	<tr<?php echo $cap_recep_accesorio_detail->RowAttributes() ?>>
		<td<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_delete->RowCnt ?>_cap_recep_accesorio_detail_COD_Fam_Accesorio" class="cap_recep_accesorio_detail_COD_Fam_Accesorio">
<span<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->COD_Fam_Accesorio->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_recep_accesorio_detail->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_delete->RowCnt ?>_cap_recep_accesorio_detail_Id_Articulo" class="cap_recep_accesorio_detail_Id_Articulo">
<span<?php echo $cap_recep_accesorio_detail->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->Id_Articulo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_recep_accesorio_detail->CantRecibida->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_delete->RowCnt ?>_cap_recep_accesorio_detail_CantRecibida" class="cap_recep_accesorio_detail_CantRecibida">
<span<?php echo $cap_recep_accesorio_detail->CantRecibida->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->CantRecibida->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_recep_accesorio_detail->Precio_Unitario->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_delete->RowCnt ?>_cap_recep_accesorio_detail_Precio_Unitario" class="cap_recep_accesorio_detail_Precio_Unitario">
<span<?php echo $cap_recep_accesorio_detail->Precio_Unitario->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->Precio_Unitario->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_recep_accesorio_detail->MontoTotal->CellAttributes() ?>><span id="el<?php echo $cap_recep_accesorio_detail_delete->RowCnt ?>_cap_recep_accesorio_detail_MontoTotal" class="cap_recep_accesorio_detail_MontoTotal">
<span<?php echo $cap_recep_accesorio_detail->MontoTotal->ViewAttributes() ?>>
<?php echo $cap_recep_accesorio_detail->MontoTotal->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$cap_recep_accesorio_detail_delete->Recordset->MoveNext();
}
$cap_recep_accesorio_detail_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fcap_recep_accesorio_detaildelete.Init();
</script>
<?php
$cap_recep_accesorio_detail_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_recep_accesorio_detail_delete->Page_Terminate();
?>
