<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_def_equiposinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_def_equipos_delete = NULL; // Initialize page object first

class ccap_def_equipos_delete extends ccap_def_equipos {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_def_equipos';

	// Page object name
	var $PageObjName = 'cap_def_equipos_delete';

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

		// Table object (cap_def_equipos)
		if (!isset($GLOBALS["cap_def_equipos"])) {
			$GLOBALS["cap_def_equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_def_equipos"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_def_equipos', TRUE);

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
			$this->Page_Terminate("cap_def_equiposlist.php");
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
			$this->Page_Terminate("cap_def_equiposlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cap_def_equipos class, cap_def_equiposinfo.php

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
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
		$this->Apodo_eq->setDbValue($rs->fields('Apodo_eq'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Id_Almacen_Entrada->setDbValue($rs->fields('Id_Almacen_Entrada'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Articulo

		$this->Id_Articulo->CellCssStyle = "white-space: nowrap;";

		// COD_Marca_eq
		// COD_Modelo_eq
		// COD_Compania_eq
		// Apodo_eq
		// Status
		// Codigo
		// Articulo
		// Id_Almacen_Entrada

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// COD_Marca_eq
			if (strval($this->COD_Marca_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Marca_eq`" . ew_SearchString("=", $this->COD_Marca_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Marca_eq`, `Marca_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_marca_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`Status`='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Marca_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Marca_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->CurrentValue;
				}
			} else {
				$this->COD_Marca_eq->ViewValue = NULL;
			}
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// COD_Compania_eq
			if (strval($this->COD_Compania_eq->CurrentValue) <> "") {
				$sFilterWrk = "`COD_Compania_eq`" . ew_SearchString("=", $this->COD_Compania_eq->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `COD_Compania_eq`, `Compania_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_compania_equipo`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Compania_eq` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->COD_Compania_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->COD_Compania_eq->ViewValue = $this->COD_Compania_eq->CurrentValue;
				}
			} else {
				$this->COD_Compania_eq->ViewValue = NULL;
			}
			$this->COD_Compania_eq->ViewCustomAttributes = "";

			// Apodo_eq
			$this->Apodo_eq->ViewValue = $this->Apodo_eq->CurrentValue;
			$this->Apodo_eq->ViewCustomAttributes = "";

			// Status
			if (strval($this->Status->CurrentValue) <> "") {
				switch ($this->Status->CurrentValue) {
					case $this->Status->FldTagValue(1):
						$this->Status->ViewValue = $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->CurrentValue;
						break;
					case $this->Status->FldTagValue(2):
						$this->Status->ViewValue = $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->CurrentValue;
						break;
					default:
						$this->Status->ViewValue = $this->Status->CurrentValue;
				}
			} else {
				$this->Status->ViewValue = NULL;
			}
			$this->Status->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Id_Almacen_Entrada
			if (strval($this->Id_Almacen_Entrada->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Almacen`" . ew_SearchString("=", $this->Id_Almacen_Entrada->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Almacen`, `Almacen` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_almacenes`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Almacen` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Almacen_Entrada->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Almacen_Entrada->ViewValue = $this->Id_Almacen_Entrada->CurrentValue;
				}
			} else {
				$this->Id_Almacen_Entrada->ViewValue = NULL;
			}
			$this->Id_Almacen_Entrada->ViewCustomAttributes = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->LinkCustomAttributes = "";
			$this->COD_Marca_eq->HrefValue = "";
			$this->COD_Marca_eq->TooltipValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->LinkCustomAttributes = "";
			$this->COD_Modelo_eq->HrefValue = "";
			$this->COD_Modelo_eq->TooltipValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->LinkCustomAttributes = "";
			$this->COD_Compania_eq->HrefValue = "";
			$this->COD_Compania_eq->TooltipValue = "";

			// Apodo_eq
			$this->Apodo_eq->LinkCustomAttributes = "";
			$this->Apodo_eq->HrefValue = "";
			$this->Apodo_eq->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Id_Almacen_Entrada
			$this->Id_Almacen_Entrada->LinkCustomAttributes = "";
			$this->Id_Almacen_Entrada->HrefValue = "";
			$this->Id_Almacen_Entrada->TooltipValue = "";
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
				$sThisKey .= $row['Id_Articulo'];
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
if (!isset($cap_def_equipos_delete)) $cap_def_equipos_delete = new ccap_def_equipos_delete();

// Page init
$cap_def_equipos_delete->Page_Init();

// Page main
$cap_def_equipos_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_def_equipos_delete = new ew_Page("cap_def_equipos_delete");
cap_def_equipos_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = cap_def_equipos_delete.PageID; // For backward compatibility

// Form object
var fcap_def_equiposdelete = new ew_Form("fcap_def_equiposdelete");

// Form_CustomValidate event
fcap_def_equiposdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_def_equiposdelete.ValidateRequired = true;
<?php } else { ?>
fcap_def_equiposdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_def_equiposdelete.Lists["x_COD_Marca_eq"] = {"LinkField":"x_COD_Marca_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Marca_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_equiposdelete.Lists["x_COD_Compania_eq"] = {"LinkField":"x_COD_Compania_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Compania_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_def_equiposdelete.Lists["x_Id_Almacen_Entrada"] = {"LinkField":"x_Id_Almacen","Ajax":null,"AutoFill":false,"DisplayFields":["x_Almacen","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($cap_def_equipos_delete->Recordset = $cap_def_equipos_delete->LoadRecordset())
	$cap_def_equipos_deleteTotalRecs = $cap_def_equipos_delete->Recordset->RecordCount(); // Get record count
if ($cap_def_equipos_deleteTotalRecs <= 0) { // No record found, exit
	if ($cap_def_equipos_delete->Recordset)
		$cap_def_equipos_delete->Recordset->Close();
	$cap_def_equipos_delete->Page_Terminate("cap_def_equiposlist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_def_equipos->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_def_equipos->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_def_equipos_delete->ShowPageHeader(); ?>
<?php
$cap_def_equipos_delete->ShowMessage();
?>
<form name="fcap_def_equiposdelete" id="fcap_def_equiposdelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="cap_def_equipos">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cap_def_equipos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_def_equiposdelete" class="ewTable ewTableSeparate">
<?php echo $cap_def_equipos->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_cap_def_equipos_COD_Marca_eq" class="cap_def_equipos_COD_Marca_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->COD_Marca_eq->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_equipos_COD_Modelo_eq" class="cap_def_equipos_COD_Modelo_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->COD_Modelo_eq->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_equipos_COD_Compania_eq" class="cap_def_equipos_COD_Compania_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->COD_Compania_eq->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_equipos_Apodo_eq" class="cap_def_equipos_Apodo_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Apodo_eq->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_equipos_Codigo" class="cap_def_equipos_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Codigo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_equipos_Articulo" class="cap_def_equipos_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Articulo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_def_equipos_Id_Almacen_Entrada" class="cap_def_equipos_Id_Almacen_Entrada"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_def_equipos->Id_Almacen_Entrada->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$cap_def_equipos_delete->RecCnt = 0;
$i = 0;
while (!$cap_def_equipos_delete->Recordset->EOF) {
	$cap_def_equipos_delete->RecCnt++;
	$cap_def_equipos_delete->RowCnt++;

	// Set row properties
	$cap_def_equipos->ResetAttrs();
	$cap_def_equipos->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cap_def_equipos_delete->LoadRowValues($cap_def_equipos_delete->Recordset);

	// Render row
	$cap_def_equipos_delete->RenderRow();
?>
	<tr<?php echo $cap_def_equipos->RowAttributes() ?>>
		<td<?php echo $cap_def_equipos->COD_Marca_eq->CellAttributes() ?>><span id="el<?php echo $cap_def_equipos_delete->RowCnt ?>_cap_def_equipos_COD_Marca_eq" class="cap_def_equipos_COD_Marca_eq">
<span<?php echo $cap_def_equipos->COD_Marca_eq->ViewAttributes() ?>>
<?php echo $cap_def_equipos->COD_Marca_eq->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_equipos->COD_Modelo_eq->CellAttributes() ?>><span id="el<?php echo $cap_def_equipos_delete->RowCnt ?>_cap_def_equipos_COD_Modelo_eq" class="cap_def_equipos_COD_Modelo_eq">
<span<?php echo $cap_def_equipos->COD_Modelo_eq->ViewAttributes() ?>>
<?php echo $cap_def_equipos->COD_Modelo_eq->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_equipos->COD_Compania_eq->CellAttributes() ?>><span id="el<?php echo $cap_def_equipos_delete->RowCnt ?>_cap_def_equipos_COD_Compania_eq" class="cap_def_equipos_COD_Compania_eq">
<span<?php echo $cap_def_equipos->COD_Compania_eq->ViewAttributes() ?>>
<?php echo $cap_def_equipos->COD_Compania_eq->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_equipos->Apodo_eq->CellAttributes() ?>><span id="el<?php echo $cap_def_equipos_delete->RowCnt ?>_cap_def_equipos_Apodo_eq" class="cap_def_equipos_Apodo_eq">
<span<?php echo $cap_def_equipos->Apodo_eq->ViewAttributes() ?>>
<?php echo $cap_def_equipos->Apodo_eq->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_equipos->Codigo->CellAttributes() ?>><span id="el<?php echo $cap_def_equipos_delete->RowCnt ?>_cap_def_equipos_Codigo" class="cap_def_equipos_Codigo">
<span<?php echo $cap_def_equipos->Codigo->ViewAttributes() ?>>
<?php echo $cap_def_equipos->Codigo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_equipos->Articulo->CellAttributes() ?>><span id="el<?php echo $cap_def_equipos_delete->RowCnt ?>_cap_def_equipos_Articulo" class="cap_def_equipos_Articulo">
<span<?php echo $cap_def_equipos->Articulo->ViewAttributes() ?>>
<?php echo $cap_def_equipos->Articulo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_def_equipos->Id_Almacen_Entrada->CellAttributes() ?>><span id="el<?php echo $cap_def_equipos_delete->RowCnt ?>_cap_def_equipos_Id_Almacen_Entrada" class="cap_def_equipos_Id_Almacen_Entrada">
<span<?php echo $cap_def_equipos->Id_Almacen_Entrada->ViewAttributes() ?>>
<?php echo $cap_def_equipos->Id_Almacen_Entrada->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$cap_def_equipos_delete->Recordset->MoveNext();
}
$cap_def_equipos_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fcap_def_equiposdelete.Init();
</script>
<?php
$cap_def_equipos_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_def_equipos_delete->Page_Terminate();
?>
