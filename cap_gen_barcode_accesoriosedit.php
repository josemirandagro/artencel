<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_gen_barcode_accesoriosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "cap_gen_barcode_accesorios_detailgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_gen_barcode_accesorios_edit = NULL; // Initialize page object first

class ccap_gen_barcode_accesorios_edit extends ccap_gen_barcode_accesorios {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_gen_barcode_accesorios';

	// Page object name
	var $PageObjName = 'cap_gen_barcode_accesorios_edit';

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

		// Table object (cap_gen_barcode_accesorios)
		if (!isset($GLOBALS["cap_gen_barcode_accesorios"])) {
			$GLOBALS["cap_gen_barcode_accesorios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_gen_barcode_accesorios"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_gen_barcode_accesorios', TRUE);

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
			$this->Page_Terminate("cap_gen_barcode_accesorioslist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->Id_Compra->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["Id_Compra"] <> "")
			$this->Id_Compra->setQueryStringValue($_GET["Id_Compra"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Id_Compra->CurrentValue == "")
			$this->Page_Terminate("cap_gen_barcode_accesorioslist.php"); // Invalid key, return to list

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cap_gen_barcode_accesorioslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_gen_barcode_accesoriosview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to View page directly
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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
		if (!$this->Id_Compra->FldIsDetailKey)
			$this->Id_Compra->setFormValue($objForm->GetValue("x_Id_Compra"));
		if (!$this->Id_Proveedor->FldIsDetailKey) {
			$this->Id_Proveedor->setFormValue($objForm->GetValue("x_Id_Proveedor"));
		}
		if (!$this->FechaEntrega->FldIsDetailKey) {
			$this->FechaEntrega->setFormValue($objForm->GetValue("x_FechaEntrega"));
			$this->FechaEntrega->CurrentValue = ew_UnFormatDateTime($this->FechaEntrega->CurrentValue, 7);
		}
		if (!$this->Status_Recepcion->FldIsDetailKey) {
			$this->Status_Recepcion->setFormValue($objForm->GetValue("x_Status_Recepcion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Compra->CurrentValue = $this->Id_Compra->FormValue;
		$this->Id_Proveedor->CurrentValue = $this->Id_Proveedor->FormValue;
		$this->FechaEntrega->CurrentValue = $this->FechaEntrega->FormValue;
		$this->FechaEntrega->CurrentValue = ew_UnFormatDateTime($this->FechaEntrega->CurrentValue, 7);
		$this->Status_Recepcion->CurrentValue = $this->Status_Recepcion->FormValue;
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
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->FechaEntrega->setDbValue($rs->fields('FechaEntrega'));
		$this->Status_Recepcion->setDbValue($rs->fields('Status_Recepcion'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Compra
		// Id_Proveedor
		// FechaEntrega
		// Status_Recepcion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Compra
			$this->Id_Compra->ViewValue = $this->Id_Compra->CurrentValue;
			$this->Id_Compra->ViewCustomAttributes = "";

			// Id_Proveedor
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial` Asc";
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

			// FechaEntrega
			$this->FechaEntrega->ViewValue = $this->FechaEntrega->CurrentValue;
			$this->FechaEntrega->ViewValue = ew_FormatDateTime($this->FechaEntrega->ViewValue, 7);
			$this->FechaEntrega->ViewCustomAttributes = "";

			// Status_Recepcion
			if (strval($this->Status_Recepcion->CurrentValue) <> "") {
				switch ($this->Status_Recepcion->CurrentValue) {
					case $this->Status_Recepcion->FldTagValue(1):
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(1) <> "" ? $this->Status_Recepcion->FldTagCaption(1) : $this->Status_Recepcion->CurrentValue;
						break;
					case $this->Status_Recepcion->FldTagValue(2):
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(2) <> "" ? $this->Status_Recepcion->FldTagCaption(2) : $this->Status_Recepcion->CurrentValue;
						break;
					case $this->Status_Recepcion->FldTagValue(3):
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->FldTagCaption(3) <> "" ? $this->Status_Recepcion->FldTagCaption(3) : $this->Status_Recepcion->CurrentValue;
						break;
					default:
						$this->Status_Recepcion->ViewValue = $this->Status_Recepcion->CurrentValue;
				}
			} else {
				$this->Status_Recepcion->ViewValue = NULL;
			}
			$this->Status_Recepcion->ViewCustomAttributes = "";

			// Id_Compra
			$this->Id_Compra->LinkCustomAttributes = "";
			$this->Id_Compra->HrefValue = "";
			$this->Id_Compra->TooltipValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->LinkCustomAttributes = "";
			$this->Id_Proveedor->HrefValue = "";
			$this->Id_Proveedor->TooltipValue = "";

			// FechaEntrega
			$this->FechaEntrega->LinkCustomAttributes = "";
			$this->FechaEntrega->HrefValue = "";
			$this->FechaEntrega->TooltipValue = "";

			// Status_Recepcion
			$this->Status_Recepcion->LinkCustomAttributes = "";
			$this->Status_Recepcion->HrefValue = "";
			$this->Status_Recepcion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Compra
			$this->Id_Compra->EditCustomAttributes = "";
			$this->Id_Compra->EditValue = $this->Id_Compra->CurrentValue;
			$this->Id_Compra->ViewCustomAttributes = "";

			// Id_Proveedor
			$this->Id_Proveedor->EditCustomAttributes = "";
			if (strval($this->Id_Proveedor->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Proveedor`" . ew_SearchString("=", $this->Id_Proveedor->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Proveedor->EditValue = strtoupper($rswrk->fields('DispFld'));
					$rswrk->Close();
				} else {
					$this->Id_Proveedor->EditValue = $this->Id_Proveedor->CurrentValue;
				}
			} else {
				$this->Id_Proveedor->EditValue = NULL;
			}
			$this->Id_Proveedor->ViewCustomAttributes = "";

			// FechaEntrega
			$this->FechaEntrega->EditCustomAttributes = "";
			$this->FechaEntrega->EditValue = $this->FechaEntrega->CurrentValue;
			$this->FechaEntrega->EditValue = ew_FormatDateTime($this->FechaEntrega->EditValue, 7);
			$this->FechaEntrega->ViewCustomAttributes = "";

			// Status_Recepcion
			$this->Status_Recepcion->EditCustomAttributes = "";
			if (strval($this->Status_Recepcion->CurrentValue) <> "") {
				switch ($this->Status_Recepcion->CurrentValue) {
					case $this->Status_Recepcion->FldTagValue(1):
						$this->Status_Recepcion->EditValue = $this->Status_Recepcion->FldTagCaption(1) <> "" ? $this->Status_Recepcion->FldTagCaption(1) : $this->Status_Recepcion->CurrentValue;
						break;
					case $this->Status_Recepcion->FldTagValue(2):
						$this->Status_Recepcion->EditValue = $this->Status_Recepcion->FldTagCaption(2) <> "" ? $this->Status_Recepcion->FldTagCaption(2) : $this->Status_Recepcion->CurrentValue;
						break;
					case $this->Status_Recepcion->FldTagValue(3):
						$this->Status_Recepcion->EditValue = $this->Status_Recepcion->FldTagCaption(3) <> "" ? $this->Status_Recepcion->FldTagCaption(3) : $this->Status_Recepcion->CurrentValue;
						break;
					default:
						$this->Status_Recepcion->EditValue = $this->Status_Recepcion->CurrentValue;
				}
			} else {
				$this->Status_Recepcion->EditValue = NULL;
			}
			$this->Status_Recepcion->ViewCustomAttributes = "";

			// Edit refer script
			// Id_Compra

			$this->Id_Compra->HrefValue = "";

			// Id_Proveedor
			$this->Id_Proveedor->HrefValue = "";

			// FechaEntrega
			$this->FechaEntrega->HrefValue = "";

			// Status_Recepcion
			$this->Status_Recepcion->HrefValue = "";
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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Validate detail grid
		if ($this->getCurrentDetailTable() == "cap_gen_barcode_accesorios_detail" && $GLOBALS["cap_gen_barcode_accesorios_detail"]->DetailEdit) {
			if (!isset($GLOBALS["cap_gen_barcode_accesorios_detail_grid"])) $GLOBALS["cap_gen_barcode_accesorios_detail_grid"] = new ccap_gen_barcode_accesorios_detail_grid(); // get detail page object
			$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->ValidateGridForm();
		}

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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';

				// Update detail records
				if ($EditRow) {
					if ($this->getCurrentDetailTable() == "cap_gen_barcode_accesorios_detail" && $GLOBALS["cap_gen_barcode_accesorios_detail"]->DetailEdit) {
						if (!isset($GLOBALS["cap_gen_barcode_accesorios_detail_grid"])) $GLOBALS["cap_gen_barcode_accesorios_detail_grid"] = new ccap_gen_barcode_accesorios_detail_grid(); // get detail page object
						$EditRow = $GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
				}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			if ($sDetailTblVar == "cap_gen_barcode_accesorios_detail") {
				if (!isset($GLOBALS["cap_gen_barcode_accesorios_detail_grid"]))
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"] = new ccap_gen_barcode_accesorios_detail_grid;
				if ($GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->DetailEdit) {
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->CurrentMode = "edit";
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->Id_Compra->FldIsDetailKey = TRUE;
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->Id_Compra->CurrentValue = $this->Id_Compra->CurrentValue;
					$GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->Id_Compra->setSessionValue($GLOBALS["cap_gen_barcode_accesorios_detail_grid"]->Id_Compra->CurrentValue);
				}
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	  $GLOBALS["Language"]->setPhrase("Edit", "");
	  $GLOBALS["Language"]->setPhrase("EditBtn", "GENERAR"); 
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
if (!isset($cap_gen_barcode_accesorios_edit)) $cap_gen_barcode_accesorios_edit = new ccap_gen_barcode_accesorios_edit();

// Page init
$cap_gen_barcode_accesorios_edit->Page_Init();

// Page main
$cap_gen_barcode_accesorios_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_gen_barcode_accesorios_edit = new ew_Page("cap_gen_barcode_accesorios_edit");
cap_gen_barcode_accesorios_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cap_gen_barcode_accesorios_edit.PageID; // For backward compatibility

// Form object
var fcap_gen_barcode_accesoriosedit = new ew_Form("fcap_gen_barcode_accesoriosedit");

// Validate form
fcap_gen_barcode_accesoriosedit.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
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

	// Process detail page
	if (fobj.detailpage && fobj.detailpage.value && ewForms[fobj.detailpage.value])
		return ewForms[fobj.detailpage.value].Validate(fobj);
	return true;
}

// Form_CustomValidate event
fcap_gen_barcode_accesoriosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_gen_barcode_accesoriosedit.ValidateRequired = true;
<?php } else { ?>
fcap_gen_barcode_accesoriosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_gen_barcode_accesoriosedit.Lists["x_Id_Proveedor"] = {"LinkField":"x_Id_Proveedor","Ajax":null,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_gen_barcode_accesorios->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_gen_barcode_accesorios->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_gen_barcode_accesorios_edit->ShowPageHeader(); ?>
<?php
$cap_gen_barcode_accesorios_edit->ShowMessage();
?>
<form name="fcap_gen_barcode_accesoriosedit" id="fcap_gen_barcode_accesoriosedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_gen_barcode_accesorios">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_gen_barcode_accesoriosedit" class="ewTable">
<?php if ($cap_gen_barcode_accesorios->Id_Compra->Visible) { // Id_Compra ?>
	<tr id="r_Id_Compra"<?php echo $cap_gen_barcode_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_gen_barcode_accesorios_Id_Compra"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->Id_Compra->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_gen_barcode_accesorios->Id_Compra->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_Id_Compra">
<span<?php echo $cap_gen_barcode_accesorios->Id_Compra->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Id_Compra->EditValue ?></span>
<input type="hidden" name="x_Id_Compra" id="x_Id_Compra" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios->Id_Compra->CurrentValue) ?>">
</span><?php echo $cap_gen_barcode_accesorios->Id_Compra->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios->Id_Proveedor->Visible) { // Id_Proveedor ?>
	<tr id="r_Id_Proveedor"<?php echo $cap_gen_barcode_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_gen_barcode_accesorios_Id_Proveedor"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->Id_Proveedor->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_Id_Proveedor">
<span<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Id_Proveedor->EditValue ?></span>
<input type="hidden" name="x_Id_Proveedor" id="x_Id_Proveedor" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios->Id_Proveedor->CurrentValue) ?>">
</span><?php echo $cap_gen_barcode_accesorios->Id_Proveedor->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios->FechaEntrega->Visible) { // FechaEntrega ?>
	<tr id="r_FechaEntrega"<?php echo $cap_gen_barcode_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_gen_barcode_accesorios_FechaEntrega"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->FechaEntrega->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_gen_barcode_accesorios->FechaEntrega->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_FechaEntrega">
<span<?php echo $cap_gen_barcode_accesorios->FechaEntrega->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->FechaEntrega->EditValue ?></span>
<input type="hidden" name="x_FechaEntrega" id="x_FechaEntrega" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios->FechaEntrega->CurrentValue) ?>">
</span><?php echo $cap_gen_barcode_accesorios->FechaEntrega->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_gen_barcode_accesorios->Status_Recepcion->Visible) { // Status_Recepcion ?>
	<tr id="r_Status_Recepcion"<?php echo $cap_gen_barcode_accesorios->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_gen_barcode_accesorios_Status_Recepcion"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_gen_barcode_accesorios->Status_Recepcion->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->CellAttributes() ?>><span id="el_cap_gen_barcode_accesorios_Status_Recepcion">
<span<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->ViewAttributes() ?>>
<?php echo $cap_gen_barcode_accesorios->Status_Recepcion->EditValue ?></span>
<input type="hidden" name="x_Status_Recepcion" id="x_Status_Recepcion" value="<?php echo ew_HtmlEncode($cap_gen_barcode_accesorios->Status_Recepcion->CurrentValue) ?>">
</span><?php echo $cap_gen_barcode_accesorios->Status_Recepcion->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<?php if ($cap_gen_barcode_accesorios->getCurrentDetailTable() == "cap_gen_barcode_accesorios_detail" && $cap_gen_barcode_accesorios_detail->DetailEdit) { ?>
<br>
<?php include_once "cap_gen_barcode_accesorios_detailgrid.php" ?>
<br>
<?php } ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fcap_gen_barcode_accesoriosedit.Init();
</script>
<?php
$cap_gen_barcode_accesorios_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_gen_barcode_accesorios_edit->Page_Terminate();
?>
