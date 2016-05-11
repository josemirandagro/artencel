<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "aux_sel_equiposinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$aux_sel_equipos_addopt = NULL; // Initialize page object first

class caux_sel_equipos_addopt extends caux_sel_equipos {

	// Page ID
	var $PageID = 'addopt';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'aux_sel_equipos';

	// Page object name
	var $PageObjName = 'aux_sel_equipos_addopt';

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

		// Table object (aux_sel_equipos)
		if (!isset($GLOBALS["aux_sel_equipos"])) {
			$GLOBALS["aux_sel_equipos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["aux_sel_equipos"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'addopt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'aux_sel_equipos', TRUE);

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
			$this->Page_Terminate("aux_sel_equiposlist.php");
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

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		set_error_handler("ew_ErrorHandler");

		// Process form if post back
		if ($objForm->GetValue("a_addopt") <> "") {
			$this->CurrentAction = $objForm->GetValue("a_addopt"); // Get form action
			$this->LoadFormValues(); // Load form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else { // Not post back
			$this->CurrentAction = "I"; // Display blank record
			$this->LoadDefaultValues(); // Load default values
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow()) { // Add successful
					$row = array();
					$row["x_Id_Articulo"] = $this->Id_Articulo->DbValue;
					$row["x_Articulo"] = $this->Articulo->DbValue;
					$row["x_Codigo"] = $this->Codigo->DbValue;
					$row["x_Marca_eq"] = $this->Marca_eq->DbValue;
					$row["x_COD_Modelo_eq"] = $this->COD_Modelo_eq->DbValue;
					$row["x_Apodo_eq"] = $this->Apodo_eq->DbValue;
					$row["x_COD_Marca_eq"] = $this->COD_Marca_eq->DbValue;
					$row["x_Precio_compra"] = $this->Precio_compra->DbValue;
					if (!EW_DEBUG_ENABLED && ob_get_length())
						ob_end_clean();
					echo ew_ArrayToJson(array($row));
				} else {
					$this->ShowMessage();
				}
				$this->Page_Terminate();
				exit();
		}

		// Render row
		$this->RowType = EW_ROWTYPE_ADD; // Render add type
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
		$this->Articulo->CurrentValue = NULL;
		$this->Articulo->OldValue = $this->Articulo->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
		$this->Marca_eq->CurrentValue = NULL;
		$this->Marca_eq->OldValue = $this->Marca_eq->CurrentValue;
		$this->COD_Modelo_eq->CurrentValue = NULL;
		$this->COD_Modelo_eq->OldValue = $this->COD_Modelo_eq->CurrentValue;
		$this->Apodo_eq->CurrentValue = NULL;
		$this->Apodo_eq->OldValue = $this->Apodo_eq->CurrentValue;
		$this->COD_Marca_eq->CurrentValue = NULL;
		$this->COD_Marca_eq->OldValue = $this->COD_Marca_eq->CurrentValue;
		$this->Precio_compra->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Articulo")));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Codigo")));
		}
		if (!$this->Marca_eq->FldIsDetailKey) {
			$this->Marca_eq->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Marca_eq")));
		}
		if (!$this->COD_Modelo_eq->FldIsDetailKey) {
			$this->COD_Modelo_eq->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_COD_Modelo_eq")));
		}
		if (!$this->Apodo_eq->FldIsDetailKey) {
			$this->Apodo_eq->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Apodo_eq")));
		}
		if (!$this->COD_Marca_eq->FldIsDetailKey) {
			$this->COD_Marca_eq->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_COD_Marca_eq")));
		}
		if (!$this->Precio_compra->FldIsDetailKey) {
			$this->Precio_compra->setFormValue(ew_ConvertFromUtf8($objForm->GetValue("x_Precio_compra")));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Articulo->CurrentValue = ew_ConvertToUtf8($this->Articulo->FormValue);
		$this->Codigo->CurrentValue = ew_ConvertToUtf8($this->Codigo->FormValue);
		$this->Marca_eq->CurrentValue = ew_ConvertToUtf8($this->Marca_eq->FormValue);
		$this->COD_Modelo_eq->CurrentValue = ew_ConvertToUtf8($this->COD_Modelo_eq->FormValue);
		$this->Apodo_eq->CurrentValue = ew_ConvertToUtf8($this->Apodo_eq->FormValue);
		$this->COD_Marca_eq->CurrentValue = ew_ConvertToUtf8($this->COD_Marca_eq->FormValue);
		$this->Precio_compra->CurrentValue = ew_ConvertToUtf8($this->Precio_compra->FormValue);
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
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Marca_eq->setDbValue($rs->fields('Marca_eq'));
		$this->COD_Modelo_eq->setDbValue($rs->fields('COD_Modelo_eq'));
		$this->Apodo_eq->setDbValue($rs->fields('Apodo_eq'));
		$this->COD_Marca_eq->setDbValue($rs->fields('COD_Marca_eq'));
		$this->Precio_compra->setDbValue($rs->fields('Precio_compra'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Precio_compra->FormValue == $this->Precio_compra->CurrentValue && is_numeric(ew_StrToFloat($this->Precio_compra->CurrentValue)))
			$this->Precio_compra->CurrentValue = ew_StrToFloat($this->Precio_compra->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Articulo
		// Articulo
		// Codigo
		// Marca_eq
		// COD_Modelo_eq
		// Apodo_eq
		// COD_Marca_eq
		// Precio_compra

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Articulo
			$this->Id_Articulo->ViewValue = $this->Id_Articulo->CurrentValue;
			$this->Id_Articulo->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

			// Marca_eq
			$this->Marca_eq->ViewValue = $this->Marca_eq->CurrentValue;
			$this->Marca_eq->ViewCustomAttributes = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->ViewValue = $this->COD_Modelo_eq->CurrentValue;
			$this->COD_Modelo_eq->ViewCustomAttributes = "";

			// Apodo_eq
			$this->Apodo_eq->ViewValue = $this->Apodo_eq->CurrentValue;
			$this->Apodo_eq->ViewCustomAttributes = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->ViewValue = $this->COD_Marca_eq->CurrentValue;
			$this->COD_Marca_eq->ViewCustomAttributes = "";

			// Precio_compra
			$this->Precio_compra->ViewValue = $this->Precio_compra->CurrentValue;
			$this->Precio_compra->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";

			// Marca_eq
			$this->Marca_eq->LinkCustomAttributes = "";
			$this->Marca_eq->HrefValue = "";
			$this->Marca_eq->TooltipValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->LinkCustomAttributes = "";
			$this->COD_Modelo_eq->HrefValue = "";
			$this->COD_Modelo_eq->TooltipValue = "";

			// Apodo_eq
			$this->Apodo_eq->LinkCustomAttributes = "";
			$this->Apodo_eq->HrefValue = "";
			$this->Apodo_eq->TooltipValue = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->LinkCustomAttributes = "";
			$this->COD_Marca_eq->HrefValue = "";
			$this->COD_Marca_eq->TooltipValue = "";

			// Precio_compra
			$this->Precio_compra->LinkCustomAttributes = "";
			$this->Precio_compra->HrefValue = "";
			$this->Precio_compra->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// Marca_eq
			$this->Marca_eq->EditCustomAttributes = "";
			$this->Marca_eq->EditValue = ew_HtmlEncode($this->Marca_eq->CurrentValue);

			// COD_Modelo_eq
			$this->COD_Modelo_eq->EditCustomAttributes = "";
			$this->COD_Modelo_eq->EditValue = ew_HtmlEncode($this->COD_Modelo_eq->CurrentValue);

			// Apodo_eq
			$this->Apodo_eq->EditCustomAttributes = "";
			$this->Apodo_eq->EditValue = ew_HtmlEncode($this->Apodo_eq->CurrentValue);

			// COD_Marca_eq
			$this->COD_Marca_eq->EditCustomAttributes = "";
			$this->COD_Marca_eq->EditValue = ew_HtmlEncode($this->COD_Marca_eq->CurrentValue);

			// Precio_compra
			$this->Precio_compra->EditCustomAttributes = "";
			$this->Precio_compra->EditValue = ew_HtmlEncode($this->Precio_compra->CurrentValue);
			if (strval($this->Precio_compra->EditValue) <> "" && is_numeric($this->Precio_compra->EditValue)) $this->Precio_compra->EditValue = ew_FormatNumber($this->Precio_compra->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// Articulo

			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";

			// Marca_eq
			$this->Marca_eq->HrefValue = "";

			// COD_Modelo_eq
			$this->COD_Modelo_eq->HrefValue = "";

			// Apodo_eq
			$this->Apodo_eq->HrefValue = "";

			// COD_Marca_eq
			$this->COD_Marca_eq->HrefValue = "";

			// Precio_compra
			$this->Precio_compra->HrefValue = "";
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
		if (!is_null($this->Codigo->FormValue) && $this->Codigo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Codigo->FldCaption());
		}
		if (!is_null($this->Marca_eq->FormValue) && $this->Marca_eq->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Marca_eq->FldCaption());
		}
		if (!is_null($this->Precio_compra->FormValue) && $this->Precio_compra->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Precio_compra->FldCaption());
		}
		if (!ew_CheckNumber($this->Precio_compra->FormValue)) {
			ew_AddMessage($gsFormError, $this->Precio_compra->FldErrMsg());
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
		if ($this->Articulo->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Articulo = '" . ew_AdjustSql($this->Articulo->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Articulo->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Articulo->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, NULL, FALSE);

		// Marca_eq
		$this->Marca_eq->SetDbValueDef($rsnew, $this->Marca_eq->CurrentValue, "", FALSE);

		// COD_Modelo_eq
		$this->COD_Modelo_eq->SetDbValueDef($rsnew, $this->COD_Modelo_eq->CurrentValue, NULL, FALSE);

		// Apodo_eq
		$this->Apodo_eq->SetDbValueDef($rsnew, $this->Apodo_eq->CurrentValue, NULL, FALSE);

		// COD_Marca_eq
		$this->COD_Marca_eq->SetDbValueDef($rsnew, $this->COD_Marca_eq->CurrentValue, NULL, FALSE);

		// Precio_compra
		$this->Precio_compra->SetDbValueDef($rsnew, $this->Precio_compra->CurrentValue, 0, strval($this->Precio_compra->CurrentValue) == "");

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
			$this->Id_Articulo->setDbValue($conn->Insert_ID());
			$rsnew['Id_Articulo'] = $this->Id_Articulo->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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

	// Custom validate event
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
if (!isset($aux_sel_equipos_addopt)) $aux_sel_equipos_addopt = new caux_sel_equipos_addopt();

// Page init
$aux_sel_equipos_addopt->Page_Init();

// Page main
$aux_sel_equipos_addopt->Page_Main();
?>
<script type="text/javascript">

// Page object
var aux_sel_equipos_addopt = new ew_Page("aux_sel_equipos_addopt");
aux_sel_equipos_addopt.PageID = "addopt"; // Page ID
var EW_PAGE_ID = aux_sel_equipos_addopt.PageID; // For backward compatibility

// Form object
var faux_sel_equiposaddopt = new ew_Form("faux_sel_equiposaddopt");

// Validate form
faux_sel_equiposaddopt.Validate = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($aux_sel_equipos->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($aux_sel_equipos->Codigo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Marca_eq"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($aux_sel_equipos->Marca_eq->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_compra"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($aux_sel_equipos->Precio_compra->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Precio_compra"];
		if (elm && !ew_CheckNumber(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($aux_sel_equipos->Precio_compra->FldErrMsg()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}
	return true;
}

// Form_CustomValidate event
faux_sel_equiposaddopt.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faux_sel_equiposaddopt.ValidateRequired = true;
<?php } else { ?>
faux_sel_equiposaddopt.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
$aux_sel_equipos_addopt->ShowMessage();
?>
<form name="faux_sel_equiposaddopt" id="faux_sel_equiposaddopt" class="ewForm" action="aux_sel_equiposaddopt.php" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="aux_sel_equipos">
<input type="hidden" name="a_addopt" id="a_addopt" value="A">
<table id="tbl_aux_sel_equiposaddopt" class="ewTableAddOpt">
	<tr>
		<td><span id="elh_aux_sel_equipos_Articulo"><?php echo $aux_sel_equipos->Articulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_aux_sel_equipos_Articulo">
<input type="text" name="x_Articulo" id="x_Articulo" size="30" maxlength="100" value="<?php echo $aux_sel_equipos->Articulo->EditValue ?>"<?php echo $aux_sel_equipos->Articulo->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_aux_sel_equipos_Codigo"><?php echo $aux_sel_equipos->Codigo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_aux_sel_equipos_Codigo">
<input type="text" name="x_Codigo" id="x_Codigo" size="30" maxlength="9" value="<?php echo $aux_sel_equipos->Codigo->EditValue ?>"<?php echo $aux_sel_equipos->Codigo->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_aux_sel_equipos_Marca_eq"><?php echo $aux_sel_equipos->Marca_eq->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_aux_sel_equipos_Marca_eq">
<input type="text" name="x_Marca_eq" id="x_Marca_eq" size="30" maxlength="15" value="<?php echo $aux_sel_equipos->Marca_eq->EditValue ?>"<?php echo $aux_sel_equipos->Marca_eq->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_aux_sel_equipos_COD_Modelo_eq"><?php echo $aux_sel_equipos->COD_Modelo_eq->FldCaption() ?></span></td>
		<td><span id="el_aux_sel_equipos_COD_Modelo_eq">
<input type="text" name="x_COD_Modelo_eq" id="x_COD_Modelo_eq" size="30" maxlength="6" value="<?php echo $aux_sel_equipos->COD_Modelo_eq->EditValue ?>"<?php echo $aux_sel_equipos->COD_Modelo_eq->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_aux_sel_equipos_Apodo_eq"><?php echo $aux_sel_equipos->Apodo_eq->FldCaption() ?></span></td>
		<td><span id="el_aux_sel_equipos_Apodo_eq">
<input type="text" name="x_Apodo_eq" id="x_Apodo_eq" size="30" maxlength="20" value="<?php echo $aux_sel_equipos->Apodo_eq->EditValue ?>"<?php echo $aux_sel_equipos->Apodo_eq->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_aux_sel_equipos_COD_Marca_eq"><?php echo $aux_sel_equipos->COD_Marca_eq->FldCaption() ?></span></td>
		<td><span id="el_aux_sel_equipos_COD_Marca_eq">
<input type="text" name="x_COD_Marca_eq" id="x_COD_Marca_eq" size="30" maxlength="3" value="<?php echo $aux_sel_equipos->COD_Marca_eq->EditValue ?>"<?php echo $aux_sel_equipos->COD_Marca_eq->EditAttributes() ?>>
</span></td>
	</tr>
	<tr>
		<td><span id="elh_aux_sel_equipos_Precio_compra"><?php echo $aux_sel_equipos->Precio_compra->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td><span id="el_aux_sel_equipos_Precio_compra">
<input type="text" name="x_Precio_compra" id="x_Precio_compra" size="30" value="<?php echo $aux_sel_equipos->Precio_compra->EditValue ?>"<?php echo $aux_sel_equipos->Precio_compra->EditAttributes() ?>>
</span></td>
	</tr>
</table>
<br>
</form>
<script type="text/javascript">
faux_sel_equiposaddopt.Init();
</script>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php
$aux_sel_equipos_addopt->Page_Terminate();
?>
