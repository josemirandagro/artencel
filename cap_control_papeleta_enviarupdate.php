<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_control_papeleta_enviarinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_control_papeleta_enviar_update = NULL; // Initialize page object first

class ccap_control_papeleta_enviar_update extends ccap_control_papeleta_enviar {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_control_papeleta_enviar';

	// Page object name
	var $PageObjName = 'cap_control_papeleta_enviar_update';

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

		// Table object (cap_control_papeleta_enviar)
		if (!isset($GLOBALS["cap_control_papeleta_enviar"])) {
			$GLOBALS["cap_control_papeleta_enviar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_control_papeleta_enviar"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_control_papeleta_enviar', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("cap_control_papeleta_enviarlist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
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
	var $RecKeys;
	var $Disabled;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("cap_control_papeleta_enviarlist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->StatusPapeleta->setDbValue($this->Recordset->fields('StatusPapeleta'));
				} else {
					if (!ew_CompareValue($this->StatusPapeleta->DbValue, $this->Recordset->fields('StatusPapeleta')))
						$this->StatusPapeleta->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->Id_Venta_Eq->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $conn, $Language;
		$conn->BeginTrans();

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
		} else {
			$conn->RollbackTrans(); // Rollback transaction
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
		$index = $objForm->Index; // Save form index
		$objForm->Index = -1;
		$confirmPage = (strval($objForm->GetValue("a_confirm")) <> "");
		$objForm->Index = $index; // Restore form index
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->StatusPapeleta->FldIsDetailKey) {
			$this->StatusPapeleta->setFormValue($objForm->GetValue("x_StatusPapeleta"));
		}
		$this->StatusPapeleta->MultiUpdate = $objForm->GetValue("u_StatusPapeleta");
		if (!$this->Id_Venta_Eq->FldIsDetailKey)
			$this->Id_Venta_Eq->setFormValue($objForm->GetValue("x_Id_Venta_Eq"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Id_Venta_Eq->CurrentValue = $this->Id_Venta_Eq->FormValue;
		$this->StatusPapeleta->CurrentValue = $this->StatusPapeleta->FormValue;
	}

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
		$this->Id_Venta_Eq->setDbValue($rs->fields('Id_Venta_Eq'));
		$this->StatusPapeleta->setDbValue($rs->fields('StatusPapeleta'));
		$this->FechaAviso->setDbValue($rs->fields('FechaAviso'));
		$this->Tipo_Papeleta->setDbValue($rs->fields('Tipo Papeleta'));
		$this->Num_IMEI->setDbValue($rs->fields('Num_IMEI'));
		$this->Num_CEL->setDbValue($rs->fields('Num_CEL'));
		$this->FolioImpresoPapeleta->setDbValue($rs->fields('FolioImpresoPapeleta'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Venta_Eq
		// StatusPapeleta
		// FechaAviso
		// Tipo Papeleta
		// Num_IMEI
		// Num_CEL
		// FolioImpresoPapeleta

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Venta_Eq
			$this->Id_Venta_Eq->ViewValue = $this->Id_Venta_Eq->CurrentValue;
			$this->Id_Venta_Eq->ViewCustomAttributes = "";

			// StatusPapeleta
			if (strval($this->StatusPapeleta->CurrentValue) <> "") {
				switch ($this->StatusPapeleta->CurrentValue) {
					case $this->StatusPapeleta->FldTagValue(1):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(1) <> "" ? $this->StatusPapeleta->FldTagCaption(1) : $this->StatusPapeleta->CurrentValue;
						break;
					case $this->StatusPapeleta->FldTagValue(2):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(2) <> "" ? $this->StatusPapeleta->FldTagCaption(2) : $this->StatusPapeleta->CurrentValue;
						break;
					case $this->StatusPapeleta->FldTagValue(3):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(3) <> "" ? $this->StatusPapeleta->FldTagCaption(3) : $this->StatusPapeleta->CurrentValue;
						break;
					case $this->StatusPapeleta->FldTagValue(4):
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->FldTagCaption(4) <> "" ? $this->StatusPapeleta->FldTagCaption(4) : $this->StatusPapeleta->CurrentValue;
						break;
					default:
						$this->StatusPapeleta->ViewValue = $this->StatusPapeleta->CurrentValue;
				}
			} else {
				$this->StatusPapeleta->ViewValue = NULL;
			}
			$this->StatusPapeleta->ViewCustomAttributes = "";

			// FechaAviso
			$this->FechaAviso->ViewValue = $this->FechaAviso->CurrentValue;
			$this->FechaAviso->ViewValue = ew_FormatDateTime($this->FechaAviso->ViewValue, 7);
			$this->FechaAviso->ViewCustomAttributes = "";

			// Tipo Papeleta
			if (strval($this->Tipo_Papeleta->CurrentValue) <> "") {
				switch ($this->Tipo_Papeleta->CurrentValue) {
					case $this->Tipo_Papeleta->FldTagValue(1):
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(1) <> "" ? $this->Tipo_Papeleta->FldTagCaption(1) : $this->Tipo_Papeleta->CurrentValue;
						break;
					case $this->Tipo_Papeleta->FldTagValue(2):
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(2) <> "" ? $this->Tipo_Papeleta->FldTagCaption(2) : $this->Tipo_Papeleta->CurrentValue;
						break;
					case $this->Tipo_Papeleta->FldTagValue(3):
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->FldTagCaption(3) <> "" ? $this->Tipo_Papeleta->FldTagCaption(3) : $this->Tipo_Papeleta->CurrentValue;
						break;
					default:
						$this->Tipo_Papeleta->ViewValue = $this->Tipo_Papeleta->CurrentValue;
				}
			} else {
				$this->Tipo_Papeleta->ViewValue = NULL;
			}
			$this->Tipo_Papeleta->ViewCustomAttributes = "";

			// Num_IMEI
			$this->Num_IMEI->ViewValue = $this->Num_IMEI->CurrentValue;
			$this->Num_IMEI->ViewCustomAttributes = "";

			// Num_CEL
			$this->Num_CEL->ViewValue = $this->Num_CEL->CurrentValue;
			$this->Num_CEL->ViewCustomAttributes = "";

			// FolioImpresoPapeleta
			$this->FolioImpresoPapeleta->ViewValue = $this->FolioImpresoPapeleta->CurrentValue;
			$this->FolioImpresoPapeleta->ViewCustomAttributes = "";

			// StatusPapeleta
			$this->StatusPapeleta->LinkCustomAttributes = "";
			$this->StatusPapeleta->HrefValue = "";
			$this->StatusPapeleta->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// StatusPapeleta
			$this->StatusPapeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(1), $this->StatusPapeleta->FldTagCaption(1) <> "" ? $this->StatusPapeleta->FldTagCaption(1) : $this->StatusPapeleta->FldTagValue(1));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(2), $this->StatusPapeleta->FldTagCaption(2) <> "" ? $this->StatusPapeleta->FldTagCaption(2) : $this->StatusPapeleta->FldTagValue(2));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(3), $this->StatusPapeleta->FldTagCaption(3) <> "" ? $this->StatusPapeleta->FldTagCaption(3) : $this->StatusPapeleta->FldTagValue(3));
			$arwrk[] = array($this->StatusPapeleta->FldTagValue(4), $this->StatusPapeleta->FldTagCaption(4) <> "" ? $this->StatusPapeleta->FldTagCaption(4) : $this->StatusPapeleta->FldTagValue(4));
			$this->StatusPapeleta->EditValue = $arwrk;

			// Edit refer script
			// StatusPapeleta

			$this->StatusPapeleta->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($this->StatusPapeleta->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
			if ($this->Num_IMEI->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Num_IMEI` = '" . ew_AdjustSql($this->Num_IMEI->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Num_IMEI->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Num_IMEI->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// StatusPapeleta
			$this->StatusPapeleta->SetDbValueDef($rsnew, $this->StatusPapeleta->CurrentValue, NULL, $this->StatusPapeleta->ReadOnly || $this->StatusPapeleta->MultiUpdate <> "1");

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($cap_control_papeleta_enviar_update)) $cap_control_papeleta_enviar_update = new ccap_control_papeleta_enviar_update();

// Page init
$cap_control_papeleta_enviar_update->Page_Init();

// Page main
$cap_control_papeleta_enviar_update->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_control_papeleta_enviar_update = new ew_Page("cap_control_papeleta_enviar_update");
cap_control_papeleta_enviar_update.PageID = "update"; // Page ID
var EW_PAGE_ID = cap_control_papeleta_enviar_update.PageID; // For backward compatibility

// Form object
var fcap_control_papeleta_enviarupdate = new ew_Form("fcap_control_papeleta_enviarupdate");

// Validate form
fcap_control_papeleta_enviarupdate.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var uelm;
	var elm, aelm;
	var rowcnt = 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = "";

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
fcap_control_papeleta_enviarupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_control_papeleta_enviarupdate.ValidateRequired = true;
<?php } else { ?>
fcap_control_papeleta_enviarupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Update") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_control_papeleta_enviar->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_control_papeleta_enviar->getReturnUrl() ?>" id="a_BackToList" class="ewLink"><?php echo $Language->Phrase("BackToList") ?></a></p>
<?php $cap_control_papeleta_enviar_update->ShowPageHeader(); ?>
<?php
$cap_control_papeleta_enviar_update->ShowMessage();
?>
<form name="fcap_control_papeleta_enviarupdate" id="fcap_control_papeleta_enviarupdate" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_control_papeleta_enviar">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php foreach ($cap_control_papeleta_enviar_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_control_papeleta_enviarupdate" class="ewTable ewTableSeparate">
	<tr class="ewTableHeader">
		<td><table class="ewTableHeaderBtn"><tr><td><?php echo $Language->Phrase("UpdateValue") ?><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"></td></tr></table></td>
		<td><table class="ewTableHeaderBtn"><tr><td><?php echo $Language->Phrase("FieldName") ?></td></tr></table></td>
		<td><table class="ewTableHeaderBtn"><tr><td><?php echo $Language->Phrase("NewValue") ?></td></tr></table></td>
	</tr>
<?php if ($cap_control_papeleta_enviar->StatusPapeleta->Visible) { // StatusPapeleta ?>
	<tr id="r_StatusPapeleta"<?php echo $cap_control_papeleta_enviar->RowAttributes() ?>>
		<td class="ewCheckbox"<?php echo $cap_control_papeleta_enviar->StatusPapeleta->CellAttributes() ?>>
<input type="checkbox" name="u_StatusPapeleta" id="u_StatusPapeleta" value="1"<?php echo ($cap_control_papeleta_enviar->StatusPapeleta->MultiUpdate == "1") ? " checked=\"checked\"" : "" ?>>
</td>
		<td<?php echo $cap_control_papeleta_enviar->StatusPapeleta->CellAttributes() ?>><span id="elh_cap_control_papeleta_enviar_StatusPapeleta"><?php echo $cap_control_papeleta_enviar->StatusPapeleta->FldCaption() ?></span></td>
		<td<?php echo $cap_control_papeleta_enviar->StatusPapeleta->CellAttributes() ?>><span id="el_cap_control_papeleta_enviar_StatusPapeleta">
<div id="tp_x_StatusPapeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_StatusPapeleta" id="x_StatusPapeleta" value="{value}"<?php echo $cap_control_papeleta_enviar->StatusPapeleta->EditAttributes() ?>></div>
<div id="dsl_x_StatusPapeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_control_papeleta_enviar->StatusPapeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_control_papeleta_enviar->StatusPapeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_StatusPapeleta" id="x_StatusPapeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_control_papeleta_enviar->StatusPapeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cap_control_papeleta_enviar->StatusPapeleta->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("UpdateBtn")) ?>">
</form>
<script type="text/javascript">
fcap_control_papeleta_enviarupdate.Init();
</script>
<?php
$cap_control_papeleta_enviar_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_control_papeleta_enviar_update->Page_Terminate();
?>
