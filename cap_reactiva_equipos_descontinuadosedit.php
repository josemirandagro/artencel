<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "cap_reactiva_equipos_descontinuadosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$cap_reactiva_equipos_descontinuados_edit = NULL; // Initialize page object first

class ccap_reactiva_equipos_descontinuados_edit extends ccap_reactiva_equipos_descontinuados {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'cap_reactiva_equipos_descontinuados';

	// Page object name
	var $PageObjName = 'cap_reactiva_equipos_descontinuados_edit';

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

		// Table object (cap_reactiva_equipos_descontinuados)
		if (!isset($GLOBALS["cap_reactiva_equipos_descontinuados"])) {
			$GLOBALS["cap_reactiva_equipos_descontinuados"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cap_reactiva_equipos_descontinuados"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cap_reactiva_equipos_descontinuados', TRUE);

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
			$this->Page_Terminate("cap_reactiva_equipos_descontinuadoslist.php");
		}
		$Security->UserID_Loading();
		if ($Security->IsLoggedIn()) $Security->LoadUserID();
		$Security->UserID_Loaded();

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->Id_Articulo->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["Id_Articulo"] <> "")
			$this->Id_Articulo->setQueryStringValue($_GET["Id_Articulo"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->Id_Articulo->CurrentValue == "")
			$this->Page_Terminate("cap_reactiva_equipos_descontinuadoslist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("cap_reactiva_equipos_descontinuadoslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cap_reactiva_equipos_descontinuadosview.php")
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
		if (!$this->Id_Articulo->FldIsDetailKey)
			$this->Id_Articulo->setFormValue($objForm->GetValue("x_Id_Articulo"));
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->COD_Marca_eq->FldIsDetailKey) {
			$this->COD_Marca_eq->setFormValue($objForm->GetValue("x_COD_Marca_eq"));
		}
		if (!$this->COD_Modelo_eq->FldIsDetailKey) {
			$this->COD_Modelo_eq->setFormValue($objForm->GetValue("x_COD_Modelo_eq"));
		}
		if (!$this->COD_Compania_eq->FldIsDetailKey) {
			$this->COD_Compania_eq->setFormValue($objForm->GetValue("x_COD_Compania_eq"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
		if (!$this->Apodo_eq->FldIsDetailKey) {
			$this->Apodo_eq->setFormValue($objForm->GetValue("x_Apodo_eq"));
		}
		if (!$this->Status->FldIsDetailKey) {
			$this->Status->setFormValue($objForm->GetValue("x_Status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->Id_Articulo->CurrentValue = $this->Id_Articulo->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->COD_Marca_eq->CurrentValue = $this->COD_Marca_eq->FormValue;
		$this->COD_Modelo_eq->CurrentValue = $this->COD_Modelo_eq->FormValue;
		$this->COD_Compania_eq->CurrentValue = $this->COD_Compania_eq->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
		$this->Apodo_eq->CurrentValue = $this->Apodo_eq->FormValue;
		$this->Status->CurrentValue = $this->Status->FormValue;
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
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->COD_Compania_eq->setDbValue($rs->fields('COD_Compania_eq'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Apodo_eq->setDbValue($rs->fields('Apodo_eq'));
		$this->Status->setDbValue($rs->fields('Status'));
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
		// Articulo
		// COD_Marca_eq
		// COD_Modelo_eq
		// COD_Compania_eq
		// Codigo
		// Apodo_eq
		// Status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->CurrentValue;
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->ViewValue = $this->COD_Compania_eq->CurrentValue;
			$this->COD_Compania_eq->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

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

			// Id_Articulo
			$this->Id_Articulo->LinkCustomAttributes = "";
			$this->Id_Articulo->HrefValue = "";
			$this->Id_Articulo->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

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

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Apodo_eq
			$this->Apodo_eq->LinkCustomAttributes = "";
			$this->Apodo_eq->HrefValue = "";
			$this->Apodo_eq->TooltipValue = "";

			// Status
			$this->Status->LinkCustomAttributes = "";
			$this->Status->HrefValue = "";
			$this->Status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Articulo
			$this->Id_Articulo->EditCustomAttributes = "";
			$this->Id_Articulo->EditValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			$this->COD_Marca_eq->EditValue = ew_HtmlEncode($this->COD_Marca_eq->CurrentValue);

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			$this->COD_Modelo_eq->EditValue = ew_HtmlEncode($this->COD_Modelo_eq->CurrentValue);

			// COD_Compania_eq
			$this->COD_Compania_eq->EditCustomAttributes = "";
			$this->COD_Compania_eq->EditValue = ew_HtmlEncode($this->COD_Compania_eq->CurrentValue);

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// Apodo_eq
			$this->Apodo_eq->EditCustomAttributes = "";
			$this->Apodo_eq->EditValue = ew_HtmlEncode($this->Apodo_eq->CurrentValue);

			// Status
			$this->Status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Status->FldTagValue(1), $this->Status->FldTagCaption(1) <> "" ? $this->Status->FldTagCaption(1) : $this->Status->FldTagValue(1));
			$arwrk[] = array($this->Status->FldTagValue(2), $this->Status->FldTagCaption(2) <> "" ? $this->Status->FldTagCaption(2) : $this->Status->FldTagValue(2));
			$this->Status->EditValue = $arwrk;

			// Edit refer script
			// Id_Articulo

			$this->Id_Articulo->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// COD_Compania_eq
			$this->COD_Compania_eq->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Apodo_eq
			$this->Apodo_eq->HrefValue = "";

			// Status
			$this->Status->HrefValue = "";
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
		if (!is_null($this->Articulo->FormValue) && $this->Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Articulo->FldCaption());
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
			if ($this->Articulo->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Articulo` = '" . ew_AdjustSql($this->Articulo->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Articulo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Articulo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
			if ($this->Codigo->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`Codigo` = '" . ew_AdjustSql($this->Codigo->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Codigo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Codigo->CurrentValue, $sIdxErrMsg);
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

			// Articulo
			$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", $this->Articulo->ReadOnly);

			// COD_Marca_eq
			$this->COD_Marca_eq->SetDbValueDef($rsnew, $this->COD_Marca_eq->CurrentValue, NULL, $this->COD_Marca_eq->ReadOnly);

			// COD_Modelo_eq
			$this->COD_Modelo_eq->SetDbValueDef($rsnew, $this->COD_Modelo_eq->CurrentValue, NULL, $this->COD_Modelo_eq->ReadOnly);

			// COD_Compania_eq
			$this->COD_Compania_eq->SetDbValueDef($rsnew, $this->COD_Compania_eq->CurrentValue, NULL, $this->COD_Compania_eq->ReadOnly);

			// Codigo
			$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, $this->Codigo->ReadOnly);

			// Apodo_eq
			$this->Apodo_eq->SetDbValueDef($rsnew, $this->Apodo_eq->CurrentValue, NULL, $this->Apodo_eq->ReadOnly);

			// Status
			$this->Status->SetDbValueDef($rsnew, $this->Status->CurrentValue, NULL, $this->Status->ReadOnly);

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
if (!isset($cap_reactiva_equipos_descontinuados_edit)) $cap_reactiva_equipos_descontinuados_edit = new ccap_reactiva_equipos_descontinuados_edit();

// Page init
$cap_reactiva_equipos_descontinuados_edit->Page_Init();

// Page main
$cap_reactiva_equipos_descontinuados_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var cap_reactiva_equipos_descontinuados_edit = new ew_Page("cap_reactiva_equipos_descontinuados_edit");
cap_reactiva_equipos_descontinuados_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = cap_reactiva_equipos_descontinuados_edit.PageID; // For backward compatibility

// Form object
var fcap_reactiva_equipos_descontinuadosedit = new ew_Form("fcap_reactiva_equipos_descontinuadosedit");

// Validate form
fcap_reactiva_equipos_descontinuadosedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($cap_reactiva_equipos_descontinuados->Articulo->FldCaption()) ?>");

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
fcap_reactiva_equipos_descontinuadosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcap_reactiva_equipos_descontinuadosedit.ValidateRequired = true;
<?php } else { ?>
fcap_reactiva_equipos_descontinuadosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeVIEW") ?><?php echo $cap_reactiva_equipos_descontinuados->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $cap_reactiva_equipos_descontinuados->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $cap_reactiva_equipos_descontinuados_edit->ShowPageHeader(); ?>
<?php
$cap_reactiva_equipos_descontinuados_edit->ShowMessage();
?>
<form name="fcap_reactiva_equipos_descontinuadosedit" id="fcap_reactiva_equipos_descontinuadosedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="cap_reactiva_equipos_descontinuados">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_cap_reactiva_equipos_descontinuadosedit" class="ewTable">
<?php if ($cap_reactiva_equipos_descontinuados->Id_Articulo->Visible) { // Id_Articulo ?>
	<tr id="r_Id_Articulo"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_Id_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Id_Articulo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Id_Articulo->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_Id_Articulo">
<span<?php echo $cap_reactiva_equipos_descontinuados->Id_Articulo->ViewAttributes() ?>>
<?php echo $cap_reactiva_equipos_descontinuados->Id_Articulo->EditValue ?></span>
<input type="hidden" name="x_Id_Articulo" id="x_Id_Articulo" value="<?php echo ew_HtmlEncode($cap_reactiva_equipos_descontinuados->Id_Articulo->CurrentValue) ?>">
</span><?php echo $cap_reactiva_equipos_descontinuados->Id_Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->Articulo->Visible) { // Articulo ?>
	<tr id="r_Articulo"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Articulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Articulo->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_Articulo">
<input type="text" name="x_Articulo" id="x_Articulo" size="30" maxlength="100" value="<?php echo $cap_reactiva_equipos_descontinuados->Articulo->EditValue ?>"<?php echo $cap_reactiva_equipos_descontinuados->Articulo->EditAttributes() ?>>
</span><?php echo $cap_reactiva_equipos_descontinuados->Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->COD_Marca_eq->Visible) { // COD_Marca_eq ?>
	<tr id="r_COD_Marca_eq"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_COD_Marca_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_COD_Marca_eq">
<input type="text" name="x_COD_Marca_eq" id="x_COD_Marca_eq" size="30" maxlength="3" value="<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditValue ?>"<?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->EditAttributes() ?>>
</span><?php echo $cap_reactiva_equipos_descontinuados->COD_Marca_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->COD_Modelo_eq->Visible) { // COD_Modelo_eq ?>
	<tr id="r_COD_Modelo_eq"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_COD_Modelo_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_COD_Modelo_eq">
<input type="text" name="x_COD_Modelo_eq" id="x_COD_Modelo_eq" size="30" maxlength="6" value="<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->EditValue ?>"<?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->EditAttributes() ?>>
</span><?php echo $cap_reactiva_equipos_descontinuados->COD_Modelo_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->COD_Compania_eq->Visible) { // COD_Compania_eq ?>
	<tr id="r_COD_Compania_eq"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_COD_Compania_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_COD_Compania_eq">
<input type="text" name="x_COD_Compania_eq" id="x_COD_Compania_eq" size="30" maxlength="1" value="<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditValue ?>"<?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->EditAttributes() ?>>
</span><?php echo $cap_reactiva_equipos_descontinuados->COD_Compania_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->Codigo->Visible) { // Codigo ?>
	<tr id="r_Codigo"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Codigo->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Codigo->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_Codigo">
<input type="text" name="x_Codigo" id="x_Codigo" size="30" maxlength="22" value="<?php echo $cap_reactiva_equipos_descontinuados->Codigo->EditValue ?>"<?php echo $cap_reactiva_equipos_descontinuados->Codigo->EditAttributes() ?>>
</span><?php echo $cap_reactiva_equipos_descontinuados->Codigo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->Apodo_eq->Visible) { // Apodo_eq ?>
	<tr id="r_Apodo_eq"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_Apodo_eq"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Apodo_eq->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Apodo_eq->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_Apodo_eq">
<input type="text" name="x_Apodo_eq" id="x_Apodo_eq" size="30" maxlength="20" value="<?php echo $cap_reactiva_equipos_descontinuados->Apodo_eq->EditValue ?>"<?php echo $cap_reactiva_equipos_descontinuados->Apodo_eq->EditAttributes() ?>>
</span><?php echo $cap_reactiva_equipos_descontinuados->Apodo_eq->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($cap_reactiva_equipos_descontinuados->Status->Visible) { // Status ?>
	<tr id="r_Status"<?php echo $cap_reactiva_equipos_descontinuados->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_cap_reactiva_equipos_descontinuados_Status"><table class="ewTableHeaderBtn"><tr><td><?php echo $cap_reactiva_equipos_descontinuados->Status->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $cap_reactiva_equipos_descontinuados->Status->CellAttributes() ?>><span id="el_cap_reactiva_equipos_descontinuados_Status">
<div id="tp_x_Status" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Status" id="x_Status" value="{value}"<?php echo $cap_reactiva_equipos_descontinuados->Status->EditAttributes() ?>></div>
<div id="dsl_x_Status" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cap_reactiva_equipos_descontinuados->Status->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cap_reactiva_equipos_descontinuados->Status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Status" id="x_Status" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cap_reactiva_equipos_descontinuados->Status->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $cap_reactiva_equipos_descontinuados->Status->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fcap_reactiva_equipos_descontinuadosedit.Init();
</script>
<?php
$cap_reactiva_equipos_descontinuados_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cap_reactiva_equipos_descontinuados_edit->Page_Terminate();
?>
