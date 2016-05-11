<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_recep_accesorioinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "cap_recep_accesorio_detailgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_recep_accesorio_add = NULL; // Initialize page object first

class ccap_recep_accesorio_add extends ccap_recep_accesorio {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_recep_accesorio';

	// Page object name
	var $PageObjName = 'cap_recep_accesorio_add';

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

		// Table object (cap_recep_accesorio)
		if (!isset($GLOBALS["cap_recep_accesorio"])) {
			$GLOBALS["cap_recep_accesorio"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_recep_accesorio"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_recep_accesorio', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("cap_recep_accesoriolist.php");
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["Id_Compra"] != "") {
				$this->Id_Compra->setQueryStringValue($_GET["Id_Compra"]);
				$this->setKey("Id_Compra", $this->Id_Compra->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Compra", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("cap_recep_accesoriolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_recep_accesorioview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
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

	// Load default values
	function LoadDefaultValues() {
		$this->Id_Proveedor->CurrentValue = 0;
		$this->FechaEntrega->CurrentValue = date('d/m/Y');
		$this->Observaciones->CurrentValue = NULL;
		$this->Observaciones->OldValue = $this->Observaciones->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Proveedor->FldIsDetailKey) {
			$this->Id_Proveedor->setFormValue($objForm->GetValue("x_Id_Proveedor"));
		}
		if (!$this->FechaEntrega->FldIsDetailKey) {
			$this->FechaEntrega->setFormValue($objForm->GetValue("x_FechaEntrega"));
			$this->FechaEntrega->CurrentValue = ew_UnFormatDateTime($this->FechaEntrega->CurrentValue, 7);
		}
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Proveedor->CurrentValue = $this->Id_Proveedor->FormValue;
		$this->FechaEntrega->CurrentValue = $this->FechaEntrega->FormValue;
		$this->FechaEntrega->CurrentValue = ew_UnFormatDateTime($this->FechaEntrega->CurrentValue, 7);
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
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
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->MontoTotal->setDbValue($rs->fields('MontoTotal'));
		$this->Status_Recepcion->setDbValue($rs->fields('Status_Recepcion'));
		$this->TipoArticulo->setDbValue($rs->fields('TipoArticulo'));
		$this->Id_Empleado_Recibe->setDbValue($rs->fields('Id_Empleado_Recibe'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Compra")) <> "")
			$this->Id_Compra->CurrentValue = $this->getKey("Id_Compra"); // Id_Compra
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		// Observaciones
		// MontoTotal
		// Status_Recepcion
		// TipoArticulo
		// Id_Empleado_Recibe

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// Observaciones
			$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
			$this->Observaciones->ViewCustomAttributes = "";

			// MontoTotal
			$this->MontoTotal->ViewValue = $this->MontoTotal->CurrentValue;
			$this->MontoTotal->ViewValue = ew_FormatCurrency($this->MontoTotal->ViewValue, 2, -2, -2, -2);
			$this->MontoTotal->ViewCustomAttributes = "";

			// Id_Empleado_Recibe
			$this->Id_Empleado_Recibe->ViewValue = $this->Id_Empleado_Recibe->CurrentValue;
			$this->Id_Empleado_Recibe->ViewCustomAttributes = "";

			// Id_Proveedor
			$this->Id_Proveedor->LinkCustomAttributes = "";
			$this->Id_Proveedor->HrefValue = "";
			$this->Id_Proveedor->TooltipValue = "";

			// FechaEntrega
			$this->FechaEntrega->LinkCustomAttributes = "";
			$this->FechaEntrega->HrefValue = "";
			$this->FechaEntrega->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Proveedor
			$this->Id_Proveedor->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_Proveedor`, `RazonSocial` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `ca_proveedores`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `RazonSocial` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$rowswrk = count($arwrk);
			for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
				$arwrk[$rowcntwrk][1] = strtoupper($arwrk[$rowcntwrk][1]);
			}
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Proveedor->EditValue = $arwrk;

			// FechaEntrega
			$this->FechaEntrega->EditCustomAttributes = "";
			$this->FechaEntrega->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->FechaEntrega->CurrentValue, 7));

			// Observaciones
			$this->Observaciones->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);

			// Edit refer script
			// Id_Proveedor

			$this->Id_Proveedor->HrefValue = "";

			// FechaEntrega
			$this->FechaEntrega->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";
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
		if (!is_null($this->Id_Proveedor->FormValue) && $this->Id_Proveedor->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Proveedor->FldCaption());
		}
		if (!is_null($this->FechaEntrega->FormValue) && $this->FechaEntrega->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->FechaEntrega->FldCaption());
		}
		if (!ew_CheckEuroDate($this->FechaEntrega->FormValue)) {
			ew_AddMessage($gsFormError, $this->FechaEntrega->FldErrMsg());
		}

		// Validate detail grid
		if ($this->getCurrentDetailTable() == "cap_recep_accesorio_detail" && $GLOBALS["cap_recep_accesorio_detail"]->DetailAdd) {
			if (!isset($GLOBALS["cap_recep_accesorio_detail_grid"])) $GLOBALS["cap_recep_accesorio_detail_grid"] = new ccap_recep_accesorio_detail_grid(); // get detail page object
			$GLOBALS["cap_recep_accesorio_detail_grid"]->ValidateGridForm();
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();
		$rsnew = array();

		// Id_Proveedor
		$this->Id_Proveedor->SetDbValueDef($rsnew, $this->Id_Proveedor->CurrentValue, 0, strval($this->Id_Proveedor->CurrentValue) == "");

		// FechaEntrega
		$this->FechaEntrega->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->FechaEntrega->CurrentValue, 7), NULL, FALSE);

		// Observaciones
		$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->Id_Compra->setDbValue($conn->Insert_ID());
			$rsnew['Id_Compra'] = $this->Id_Compra->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			if ($this->getCurrentDetailTable() == "cap_recep_accesorio_detail" && $GLOBALS["cap_recep_accesorio_detail"]->DetailAdd) {
				$GLOBALS["cap_recep_accesorio_detail"]->Id_Compra->setSessionValue($this->Id_Compra->CurrentValue); // Set master key
				if (!isset($GLOBALS["cap_recep_accesorio_detail_grid"])) $GLOBALS["cap_recep_accesorio_detail_grid"] = new ccap_recep_accesorio_detail_grid(); // get detail page object
				$AddRow = $GLOBALS["cap_recep_accesorio_detail_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["cap_recep_accesorio_detail"]->Id_Compra->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
			if ($sDetailTblVar == "cap_recep_accesorio_detail") {
				if (!isset($GLOBALS["cap_recep_accesorio_detail_grid"]))
					$GLOBALS["cap_recep_accesorio_detail_grid"] = new ccap_recep_accesorio_detail_grid;
				if ($GLOBALS["cap_recep_accesorio_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cap_recep_accesorio_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cap_recep_accesorio_detail_grid"]->CurrentMode = "add";
					$GLOBALS["cap_recep_accesorio_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cap_recep_accesorio_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cap_recep_accesorio_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["cap_recep_accesorio_detail_grid"]->Id_Compra->FldIsDetailKey = TRUE;
					$GLOBALS["cap_recep_accesorio_detail_grid"]->Id_Compra->CurrentValue = $this->Id_Compra->CurrentValue;
					$GLOBALS["cap_recep_accesorio_detail_grid"]->Id_Compra->setSessionValue($GLOBALS["cap_recep_accesorio_detail_grid"]->Id_Compra->CurrentValue);
				}
			}
		}
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
if (!isset($cap_recep_accesorio_add)) $cap_recep_accesorio_add = new ccap_recep_accesorio_add();

// Page init
$cap_recep_accesorio_add->Page_Init();

// Page main
$cap_recep_accesorio_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_recep_accesorio_add = new ew_Page("cap_recep_accesorio_add");
cap_recep_accesorio_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cap_recep_accesorio_add.PageID; // For backward compatibility

// Form object
var fcap_recep_accesorioadd = new ew_Form("fcap_recep_accesorioadd");

// Validate form
fcap_recep_accesorioadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Proveedor"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_recep_accesorio->Id_Proveedor->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_FechaEntrega"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_recep_accesorio->FechaEntrega->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_FechaEntrega"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($cap_recep_accesorio->FechaEntrega->FldErrMsg()) ?>");

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
fcap_recep_accesorioadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_recep_accesorioadd.ValidateRequired = true;
<?php } else { ?>
fcap_recep_accesorioadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcap_recep_accesorioadd.Lists["x_Id_Proveedor"] = {"LinkField":"x_Id_Proveedor","Ajax":null,"AutoFill":false,"DisplayFields":["x_RazonSocial","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_recep_accesorio->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_recep_accesorio->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_recep_accesorio_add->ShowPageHeader(); ?>
<?php
$cap_recep_accesorio_add->ShowMessage();
?>
<form name="fcap_recep_accesorioadd" id="fcap_recep_accesorioadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_recep_accesorio">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_recep_accesorioadd" class="ewTable">
<?php if ($cap_recep_accesorio->Id_Proveedor->Visible) { // Id_Proveedor ?>
	<tr id="r_Id_Proveedor"<?php echo $cap_recep_accesorio->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_recep_accesorio_Id_Proveedor"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio->Id_Proveedor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_recep_accesorio->Id_Proveedor->CellAttributes() ?>><span id="el_cap_recep_accesorio_Id_Proveedor">
<select id="x_Id_Proveedor" name="x_Id_Proveedor"<?php echo $cap_recep_accesorio->Id_Proveedor->EditAttributes() ?>>
<?php
if (is_array($cap_recep_accesorio->Id_Proveedor->EditValue)) {
	$arwrk = $cap_recep_accesorio->Id_Proveedor->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_recep_accesorio->Id_Proveedor->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fcap_recep_accesorioadd.Lists["x_Id_Proveedor"].Options = <?php echo (is_array($cap_recep_accesorio->Id_Proveedor->EditValue)) ? ew_ArrayToJson($cap_recep_accesorio->Id_Proveedor->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $cap_recep_accesorio->Id_Proveedor->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_recep_accesorio->FechaEntrega->Visible) { // FechaEntrega ?>
	<tr id="r_FechaEntrega"<?php echo $cap_recep_accesorio->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_recep_accesorio_FechaEntrega"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio->FechaEntrega->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_recep_accesorio->FechaEntrega->CellAttributes() ?>><span id="el_cap_recep_accesorio_FechaEntrega">
<input type="text" name="x_FechaEntrega" id="x_FechaEntrega" value="<?php echo $cap_recep_accesorio->FechaEntrega->EditValue ?>"<?php echo $cap_recep_accesorio->FechaEntrega->EditAttributes() ?>>
<?php if (!$cap_recep_accesorio->FechaEntrega->ReadOnly && !$cap_recep_accesorio->FechaEntrega->Disabled && @$cap_recep_accesorio->FechaEntrega->EditAttrs["readonly"] == "" && @$cap_recep_accesorio->FechaEntrega->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fcap_recep_accesorioadd$x_FechaEntrega$" name="fcap_recep_accesorioadd$x_FechaEntrega$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar" style="border: 0;">
<script type="text/javascript">
ew_CreateCalendar("fcap_recep_accesorioadd", "x_FechaEntrega", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $cap_recep_accesorio->FechaEntrega->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_recep_accesorio->Observaciones->Visible) { // Observaciones ?>
	<tr id="r_Observaciones"<?php echo $cap_recep_accesorio->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_recep_accesorio_Observaciones"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_recep_accesorio->Observaciones->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_recep_accesorio->Observaciones->CellAttributes() ?>><span id="el_cap_recep_accesorio_Observaciones">
<textarea name="x_Observaciones" id="x_Observaciones" cols="80" rows="3"<?php echo $cap_recep_accesorio->Observaciones->EditAttributes() ?>><?php echo $cap_recep_accesorio->Observaciones->EditValue ?></textarea>
</span><?php echo $cap_recep_accesorio->Observaciones->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<?php if ($cap_recep_accesorio->getCurrentDetailTable() == "cap_recep_accesorio_detail" && $cap_recep_accesorio_detail->DetailAdd) { ?>
<br>
<?php include_once "cap_recep_accesorio_detailgrid.php" ?>
<br>
<?php } ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fcap_recep_accesorioadd.Init();
</script>
<?php
$cap_recep_accesorio_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_recep_accesorio_add->Page_Terminate();
?>
