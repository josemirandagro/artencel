<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_entrega_equipo_detinfo.php" ?>
<?php include_once "cap_entrega_equipoinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_entrega_equipo_det_delete = NULL; // Initialize page object first

class ccap_entrega_equipo_det_delete extends ccap_entrega_equipo_det {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_entrega_equipo_det';

	// Page object name
	var $PageObjName = 'cap_entrega_equipo_det_delete';

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

		// Table object (cap_entrega_equipo_det)
		if (!isset($GLOBALS["cap_entrega_equipo_det"])) {
			$GLOBALS["cap_entrega_equipo_det"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_entrega_equipo_det"];
		}

		// Table object (cap_entrega_equipo)
		if (!isset($GLOBALS['cap_entrega_equipo'])) $GLOBALS['cap_entrega_equipo'] = new ccap_entrega_equipo();

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_entrega_equipo_det', TRUE);

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
			$this->Page_Terminate("cap_entrega_equipo_detlist.php");
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
			$this->Page_Terminate("cap_entrega_equipo_detlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in cap_entrega_equipo_det class, cap_entrega_equipo_detinfo.php

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
		$this->Id_Traspaso->setDbValue($rs->fields('Id_Traspaso'));
		$this->Id_Traspaso_Det->setDbValue($rs->fields('Id_Traspaso_Det'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Id_Tel_SIM->setDbValue($rs->fields('Id_Tel_SIM'));
		$this->Fecha->setDbValue($rs->fields('Fecha'));
		$this->Hora->setDbValue($rs->fields('Hora'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Traspaso
		// Id_Traspaso_Det

		$this->Id_Traspaso_Det->CellCssStyle = "white-space: nowrap;";

		// Num_IMEI
		// Id_Tel_SIM
		// Fecha
		// Hora

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Id_Tel_SIM
			if (strval($this->Id_Tel_SIM->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Tel_SIM`" . ew_SearchString("=", $this->Id_Tel_SIM->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Tel_SIM`, `EquipoAcabado` AS `DispFld`, `Num_IMEI` AS `Disp2Fld`, `Status` AS `Disp3Fld`, `Num_ICCID` AS `Disp4Fld` FROM `aux_sel_equipo_venta`";
			$sWhereWrk = "";
			$lookuptblfilter = "Id_Almacen=".Id_Tienda_actual();
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Num_IMEI` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Tel_SIM->ViewValue = $rswrk->fields('DispFld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(1,$this->Id_Tel_SIM) . $rswrk->fields('Disp2Fld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(2,$this->Id_Tel_SIM) . $rswrk->fields('Disp3Fld');
					$this->Id_Tel_SIM->ViewValue .= ew_ValueSeparator(3,$this->Id_Tel_SIM) . $rswrk->fields('Disp4Fld');
					$rswrk->Close();
				} else {
					$this->Id_Tel_SIM->ViewValue = $this->Id_Tel_SIM->CurrentValue;
				}
			} else {
				$this->Id_Tel_SIM->ViewValue = NULL;
			}
			$this->Id_Tel_SIM->ViewCustomAttributes = "";

			// Fecha
			$this->Fecha->ViewValue = $this->Fecha->CurrentValue;
			$this->Fecha->ViewValue = ew_FormatDateTime($this->Fecha->ViewValue, 7);
			$this->Fecha->ViewCustomAttributes = "";

			// Hora
			$this->Hora->ViewValue = $this->Hora->CurrentValue;
			$this->Hora->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->LinkCustomAttributes = "";
			$this->Num_IMEI->HrefValue = "";
			$this->Num_IMEI->TooltipValue = "";

			// Id_Tel_SIM
			$this->Id_Tel_SIM->LinkCustomAttributes = "";
			$this->Id_Tel_SIM->HrefValue = "";
			$this->Id_Tel_SIM->TooltipValue = "";

			// Fecha
			$this->Fecha->LinkCustomAttributes = "";
			$this->Fecha->HrefValue = "";
			$this->Fecha->TooltipValue = "";

			// Hora
			$this->Hora->LinkCustomAttributes = "";
			$this->Hora->HrefValue = "";
			$this->Hora->TooltipValue = "";
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
				$sThisKey .= $row['Id_Traspaso_Det'];
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
if (!isset($cap_entrega_equipo_det_delete)) $cap_entrega_equipo_det_delete = new ccap_entrega_equipo_det_delete();

// Page init
$cap_entrega_equipo_det_delete->Page_Init();

// Page main
$cap_entrega_equipo_det_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_entrega_equipo_det_delete = new ew_Page("cap_entrega_equipo_det_delete");
cap_entrega_equipo_det_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = cap_entrega_equipo_det_delete.PageID; // For backward compatibility

// Form object
var fcap_entrega_equipo_detdelete = new ew_Form("fcap_entrega_equipo_detdelete");

// Form_CustomValidate event
fcap_entrega_equipo_detdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_entrega_equipo_detdelete.ValidateRequired = true;
<?php } else { ?>
fcap_entrega_equipo_detdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_entrega_equipo_detdelete.Lists["x_Id_Tel_SIM"] = {"LinkField":"x_Id_Tel_SIM","Ajax":true,"AutoFill":false,"DisplayFields":["x_EquipoAcabado","x_Num_IMEI","x_Status","x_Num_ICCID"],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($cap_entrega_equipo_det_delete->Recordset = $cap_entrega_equipo_det_delete->LoadRecordset())
	$cap_entrega_equipo_det_deleteTotalRecs = $cap_entrega_equipo_det_delete->Recordset->RecordCount(); // Get record count
if ($cap_entrega_equipo_det_deleteTotalRecs <= 0) { // No record found, exit
	if ($cap_entrega_equipo_det_delete->Recordset)
		$cap_entrega_equipo_det_delete->Recordset->Close();
	$cap_entrega_equipo_det_delete->Page_Terminate("cap_entrega_equipo_detlist.php"); // Return to list
}
?>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_entrega_equipo_det->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_entrega_equipo_det->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_entrega_equipo_det_delete->ShowPageHeader(); ?>
<?php
$cap_entrega_equipo_det_delete->ShowMessage();
?>
<form name="fcap_entrega_equipo_detdelete" id="fcap_entrega_equipo_detdelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<br>
<input type="hidden" name="t" value="cap_entrega_equipo_det">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($cap_entrega_equipo_det_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_entrega_equipo_detdelete" class="ewTable ewTableSeparate">
<?php echo $cap_entrega_equipo_det->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_cap_entrega_equipo_det_Num_IMEI" class="cap_entrega_equipo_det_Num_IMEI"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo_det->Num_IMEI->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_entrega_equipo_det_Id_Tel_SIM" class="cap_entrega_equipo_det_Id_Tel_SIM"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo_det->Id_Tel_SIM->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_entrega_equipo_det_Fecha" class="cap_entrega_equipo_det_Fecha"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo_det->Fecha->FldCaption() ?></td></tr></table></span></td>
		<td><span id="elh_cap_entrega_equipo_det_Hora" class="cap_entrega_equipo_det_Hora"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_entrega_equipo_det->Hora->FldCaption() ?></td></tr></table></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$cap_entrega_equipo_det_delete->RecCnt = 0;
$i = 0;
while (!$cap_entrega_equipo_det_delete->Recordset->EOF) {
	$cap_entrega_equipo_det_delete->RecCnt++;
	$cap_entrega_equipo_det_delete->RowCnt++;

	// Set row properties
	$cap_entrega_equipo_det->ResetAttrs();
	$cap_entrega_equipo_det->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$cap_entrega_equipo_det_delete->LoadRowValues($cap_entrega_equipo_det_delete->Recordset);

	// Render row
	$cap_entrega_equipo_det_delete->RenderRow();
?>
	<tr<?php echo $cap_entrega_equipo_det->RowAttributes() ?>>
		<td<?php echo $cap_entrega_equipo_det->Num_IMEI->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_delete->RowCnt ?>_cap_entrega_equipo_det_Num_IMEI" class="cap_entrega_equipo_det_Num_IMEI">
<span<?php echo $cap_entrega_equipo_det->Num_IMEI->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Num_IMEI->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_delete->RowCnt ?>_cap_entrega_equipo_det_Id_Tel_SIM" class="cap_entrega_equipo_det_Id_Tel_SIM">
<span<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Id_Tel_SIM->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_entrega_equipo_det->Fecha->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_delete->RowCnt ?>_cap_entrega_equipo_det_Fecha" class="cap_entrega_equipo_det_Fecha">
<span<?php echo $cap_entrega_equipo_det->Fecha->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Fecha->ListViewValue() ?></span>
</span></td>
		<td<?php echo $cap_entrega_equipo_det->Hora->CellAttributes() ?>><span id="el<?php echo $cap_entrega_equipo_det_delete->RowCnt ?>_cap_entrega_equipo_det_Hora" class="cap_entrega_equipo_det_Hora">
<span<?php echo $cap_entrega_equipo_det->Hora->ViewAttributes() ?>>
<?php echo $cap_entrega_equipo_det->Hora->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$cap_entrega_equipo_det_delete->Recordset->MoveNext();
}
$cap_entrega_equipo_det_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fcap_entrega_equipo_detdelete.Init();
</script>
<?php
$cap_entrega_equipo_det_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_entrega_equipo_det_delete->Page_Terminate();
?>
