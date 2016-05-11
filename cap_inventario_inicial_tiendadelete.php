<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_inventario_inicial_tiendainfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_inventario_inicial_tienda_delete = NULL; // Initialize page object first

class ccap_inventario_inicial_tienda_delete extends ccap_inventario_inicial_tienda {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_inventario_inicial_tienda';

	// Page object name
	var $PageObjName = 'cap_inventario_inicial_tienda_delete';

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

		// Table object (cap_inventario_inicial_tienda)
		if (!isset($GLOBALS["cap_inventario_inicial_tienda"])) {
			$GLOBALS["cap_inventario_inicial_tienda"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_inventario_inicial_tienda"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_inventario_inicial_tienda', TRUE);

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
			$this->Page_Terminate("cap_inventario_inicial_tiendalist.php");
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
			$this->Page_Terminate("cap_inventario_inicial_tiendalist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cap_inventario_inicial_tienda class, cap_inventario_inicial_tiendainfo.php

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
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Id_Articulo->setDbValue($rs->fields('Id_Articulo'));
		$this->Id_Acabado_eq->setDbValue($rs->fields('Id_Acabado_eq'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_ICCID->setDbValue($rs->fields('Num_ICCID'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->Id_Almacen->setDbValue($rs->fields('Id_Almacen'));
		$this->Id_Usuario->setDbValue($rs->fields('Id_Usuario'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Tel_SIM
		// Id_Articulo
		// Id_Acabado_eq
		// Num_IMEI
		// Num_ICCID
		// Num_CEL
		// Id_Almacen
		// Id_Usuario
		// TipoArticulo
		// Id_Proveedor

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Tel_SIM
			$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Id_Articulo
			if (strval($this->Id_Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Articulo`" . ew_SearchString("=", $this->Id_Articulo->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Articulo`, `Codigo` AS `DispFld`, `Articulo` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `aux_sel_equipos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Articulo->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Articulo->ViewValue .= ew_ValueSeparator(1,$this->Id_Articulo) . $rswrk->fields('Disp2Fld');
					$rswrk->Close();
				} else {
					$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
				}
			} else {
				$this->Id_Articulo->ViewValue = NULL;
			}
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Id_Acabado_eq
			if (strval($this->Id_Acabado_eq->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Acabado_eq`" . ew_SearchString("=", $this->Id_Acabado_eq->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Acabado_eq`, `Acabado_eq` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `me_acabado_equipo`";
			$sWhereWrk = "";
			$lookuptblfilter = "Status='Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Acabado_eq`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Acabado_eq->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Acabado_eq->ViewValue = $this->Id_Acabado_eq->CurrentValue;
				}
			} else {
				$this->Id_Acabado_eq->ViewValue = NULL;
			}
			$this->Id_Acabado_eq->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_ICCID
			$this->Num_ICCID->ViewValue = $this->Num_ICCID->CurrentValue;
			$this->Num_ICCID->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// Id_Almacen
			$this->Id_Almacen->ViewValue = $this->Id_Almacen->CurrentValue;
			$this->Id_Almacen->ViewCustomAttributes = "";

			// Id_Usuario
			$this->Id_Usuario->ViewValue = $this->Id_Usuario->CurrentValue;
			$this->Id_Usuario->ViewCustomAttributes = "";

			// TipoArticulo
			$this->TipoArticulo->ViewValue = $this->TipoArticulo->CurrentValue;
			$this->TipoArticulo->ViewCustomAttributes = "";

			// Id_Proveedor
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial`";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Proveedor->ViewValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Proveedor->ViewValue = $this->Id_Proveedor->CurrentValue;
				}
			} else {
				$this->Id_Proveedor->ViewValue = NULL;
			}
			$this->Id_Proveedor->ViewCustomAttributes = "";

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Id_Acabado_eq
			$this->Id_Acabado_eq->LinkCustomAttributes = "";
			$this->Id_Acabado_eq->HrefValue = "";
			$this->Id_Acabado_eq->TooltipValue = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Num_ICCID
			$this->Num_ICCID->LinkCustomAttributes = "";
			$this->Num_ICCID->HrefValue = "";
			$this->Num_ICCID->TooltipValue = "";

			// Num_CEL
			$this->Num_CEL->LinkCustomAttributes = "";
			$this->Num_CEL->HrefValue = "";
			$this->Num_CEL->TooltipValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->LinkCustomAttributes = "";
			$this->Id_Proveedor->HrefValue = "";
			$this->Id_Proveedor->TooltipValue = "";
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
				$sThisKey .= $row['Id_Tel_SIM'];
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
if (!isset($cap_inventario_inicial_tienda_delete)) $cap_inventario_inicial_tienda_delete = new ccap_inventario_inicial_tienda_delete();

// Page init
$cap_inventario_inicial_tienda_delete->Page_Init();

// Page main
$cap_inventario_inicial_tienda_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_inventario_inicial_tienda_delete = new ew_Page("cap_inventario_inicial_tienda_delete");
cap_inventario_inicial_tienda_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = cap_inventario_inicial_tienda_delete.PageID; // For backward compatibility

// Form object
var fcap_inventario_inicial_tiendadelete = new ew_Form("fcap_inventario_inicial_tiendadelete");

// Form_CustomValidate event
fcap_inventario_inicial_tiendadelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_inventario_inicial_tiendadelete.ValidateRequired = true;
<?php } else { ?>
fcap_inventario_inicial_tiendadelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_inventario_inicial_tiendadelete.Lists["x_Id_Articulo"] = {"LinkField":"x_Id_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Codigo","x_Articulo","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_inicial_tiendadelete.Lists["x_Id_Acabado_eq"] = {"LinkField":"x_Id_Acabado_eq","Ajax":null,"AutoFill":false,"DisplayFields":["x_Acabado_eq","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcap_inventario_inicial_tiendadelete.Lists["x_Id_Proveedor"] = {"LinkField":"x_Id_Proveedor","Ajax":null,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($cap_inventario_inicial_tienda_delete->Recordset = $cap_inventario_inicial_tienda_delete->LoadRecordset())
	$cap_inventario_inicial_tienda_deleteTotalRecs = $cap_inventario_inicial_tienda_delete->Recordset->RecordCount(); // Get record count
if ($cap_inventario_inicial_tienda_deleteTotalRecs <= 0) { // No record found, exit
	if ($cap_inventario_inicial_tienda_delete->Recordset)
		$cap_inventario_inicial_tienda_delete->Recordset->Close();
	$cap_inventario_inicial_tienda_delete->Page_Terminate("cap_inventario_inicial_tiendalist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_inventario_inicial_tienda->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_inventario_inicial_tienda->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_inventario_inicial_tienda_delete->ShowPageHeader(); ?>
<?php
$cap_inventario_inicial_tienda_delete->ShowMessage();
?>
<form name="fcap_inventario_inicial_tiendadelete" id="fcap_inventario_inicial_tiendadelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="cap_inventario_inicial_tienda">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cap_inventario_inicial_tienda_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_inventario_inicial_tiendadelete" class="ewTable ewTableSeparate">
<?php echo $cap_inventario_inicial_tienda->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_cap_inventario_inicial_tienda_Id_Articulo" class="cap_inventario_inicial_tienda_Id_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_inicial_tienda->Id_Articulo->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_inventario_inicial_tienda_Id_Acabado_eq" class="cap_inventario_inicial_tienda_Id_Acabado_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_inventario_inicial_tienda_Num_IMEI" class="cap_inventario_inicial_tienda_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_inicial_tienda->Num_IMEI->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_inventario_inicial_tienda_Num_ICCID" class="cap_inventario_inicial_tienda_Num_ICCID"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_inicial_tienda->Num_ICCID->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_inventario_inicial_tienda_Num_CEL" class="cap_inventario_inicial_tienda_Num_CEL"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_inicial_tienda->Num_CEL->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_inventario_inicial_tienda_Id_Proveedor" class="cap_inventario_inicial_tienda_Id_Proveedor"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_inventario_inicial_tienda->Id_Proveedor->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$cap_inventario_inicial_tienda_delete->RecCnt = 0;
$i = 0;
while (!$cap_inventario_inicial_tienda_delete->Recordset->EOF) {
	$cap_inventario_inicial_tienda_delete->RecCnt++;
	$cap_inventario_inicial_tienda_delete->RowCnt++;

	// Set row properties
	$cap_inventario_inicial_tienda->ResetAttrs();
	$cap_inventario_inicial_tienda->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cap_inventario_inicial_tienda_delete->LoadRowValues($cap_inventario_inicial_tienda_delete->Recordset);

	// Render row
	$cap_inventario_inicial_tienda_delete->RenderRow();
?>
	<tr<?php echo $cap_inventario_inicial_tienda->RowAttributes() ?>>
		<td<?php echo $cap_inventario_inicial_tienda->Id_Articulo->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_delete->RowCnt ?>_cap_inventario_inicial_tienda_Id_Articulo" class="cap_inventario_inicial_tienda_Id_Articulo">
<span<?php echo $cap_inventario_inicial_tienda->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Articulo->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_delete->RowCnt ?>_cap_inventario_inicial_tienda_Id_Acabado_eq" class="cap_inventario_inicial_tienda_Id_Acabado_eq">
<span<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Acabado_eq->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_inventario_inicial_tienda->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_delete->RowCnt ?>_cap_inventario_inicial_tienda_Num_IMEI" class="cap_inventario_inicial_tienda_Num_IMEI">
<span<?php echo $cap_inventario_inicial_tienda->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Num_IMEI->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_inventario_inicial_tienda->Num_ICCID->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_delete->RowCnt ?>_cap_inventario_inicial_tienda_Num_ICCID" class="cap_inventario_inicial_tienda_Num_ICCID">
<span<?php echo $cap_inventario_inicial_tienda->Num_ICCID->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Num_ICCID->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_inventario_inicial_tienda->Num_CEL->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_delete->RowCnt ?>_cap_inventario_inicial_tienda_Num_CEL" class="cap_inventario_inicial_tienda_Num_CEL">
<span<?php echo $cap_inventario_inicial_tienda->Num_CEL->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Num_CEL->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->CellAttributes() ?>><span id="el<?php echo $cap_inventario_inicial_tienda_delete->RowCnt ?>_cap_inventario_inicial_tienda_Id_Proveedor" class="cap_inventario_inicial_tienda_Id_Proveedor">
<span<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_inventario_inicial_tienda->Id_Proveedor->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$cap_inventario_inicial_tienda_delete->Recordset->MoveNext();
}
$cap_inventario_inicial_tienda_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fcap_inventario_inicial_tiendadelete.Init();
</script>
<?php
$cap_inventario_inicial_tienda_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_inventario_inicial_tienda_delete->Page_Terminate();
?>
