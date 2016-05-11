<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "barcode_accesorioinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$barcode_accesorio_add = NULL; // Initialize page object first

class cbarcode_accesorio_add extends cbarcode_accesorio {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'barcode_accesorio';

	// Page object name
	var $PageObjName = 'barcode_accesorio_add';

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

		// Table object (barcode_accesorio)
		if (!isset($GLOBALS["barcode_accesorio"])) {
			$GLOBALS["barcode_accesorio"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["barcode_accesorio"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'barcode_accesorio', TRUE);

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
			$this->Page_Terminate("barcode_accesoriolist.php");
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
			if (@$_GET["Id_Etiqueta"] != "") {
				$this->Id_Etiqueta->setQueryStringValue($_GET["Id_Etiqueta"]);
				$this->setKey("Id_Etiqueta", $this->Id_Etiqueta->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Etiqueta", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

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
					$this->Page_Terminate("barcode_accesoriolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = "barcode_accesoriolist.php";
					if (ew_GetPageName($sReturnUrl) == "barcode_accesorioview.php")
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
		$this->Id_Compra_Det->CurrentValue = 0;
		$this->Articulo->CurrentValue = NULL;
		$this->Articulo->OldValue = $this->Articulo->CurrentValue;
		$this->Codigo->CurrentValue = NULL;
		$this->Codigo->OldValue = $this->Codigo->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Compra_Det->FldIsDetailKey) {
			$this->Id_Compra_Det->setFormValue($objForm->GetValue("x_Id_Compra_Det"));
		}
		if (!$this->Articulo->FldIsDetailKey) {
			$this->Articulo->setFormValue($objForm->GetValue("x_Articulo"));
		}
		if (!$this->Codigo->FldIsDetailKey) {
			$this->Codigo->setFormValue($objForm->GetValue("x_Codigo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Id_Compra_Det->CurrentValue = $this->Id_Compra_Det->FormValue;
		$this->Articulo->CurrentValue = $this->Articulo->FormValue;
		$this->Codigo->CurrentValue = $this->Codigo->FormValue;
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
		$this->Id_Etiqueta->setDbValue($rs->fields('Id_Etiqueta'));
		$this->Id_Compra->setDbValue($rs->fields('Id_Compra'));
		$this->Id_Compra_Det->setDbValue($rs->fields('Id_Compra_Det'));
		$this->Articulo->setDbValue($rs->fields('Articulo'));
		$this->Codigo->setDbValue($rs->fields('Codigo'));
		$this->Status->setDbValue($rs->fields('Status'));
		$this->Articulo_L1->setDbValue($rs->fields('Articulo_L1'));
		$this->Articulo_L2->setDbValue($rs->fields('Articulo_L2'));
		$this->Articulo_L3->setDbValue($rs->fields('Articulo_L3'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Etiqueta")) <> "")
			$this->Id_Etiqueta->CurrentValue = $this->getKey("Id_Etiqueta"); // Id_Etiqueta
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
		// Id_Etiqueta
		// Id_Compra
		// Id_Compra_Det
		// Articulo
		// Codigo
		// Status
		// Articulo_L1
		// Articulo_L2
		// Articulo_L3

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Id_Etiqueta
			$this->Id_Etiqueta->ViewValue = $this->Id_Etiqueta->CurrentValue;
			$this->Id_Etiqueta->ViewCustomAttributes = "";

			// Id_Compra
			$this->Id_Compra->ViewValue = $this->Id_Compra->CurrentValue;
			$this->Id_Compra->ViewCustomAttributes = "";

			// Id_Compra_Det
			if (strval($this->Id_Compra_Det->CurrentValue) <> "") {
				$sFilterWrk = "`Id_Etiqueta`" . ew_SearchString("=", $this->Id_Compra_Det->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT DISTINCT `Id_Etiqueta`, `Id_Etiqueta` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `barcode_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Etiqueta` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Compra_Det->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Compra_Det->ViewValue = $this->Id_Compra_Det->CurrentValue;
				}
			} else {
				$this->Id_Compra_Det->ViewValue = NULL;
			}
			$this->Id_Compra_Det->ViewCustomAttributes = "";

			// Articulo
			$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->ViewValue = $this->Articulo->CurrentValue;
				}
			} else {
				$this->Articulo->ViewValue = NULL;
			}
			$this->Articulo->ViewCustomAttributes = "";

			// Codigo
			$this->Codigo->ViewValue = $this->Codigo->CurrentValue;
			$this->Codigo->ViewCustomAttributes = "";

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

			// Articulo_L1
			$this->Articulo_L1->ViewValue = $this->Articulo_L1->CurrentValue;
			$this->Articulo_L1->ViewCustomAttributes = "";

			// Articulo_L2
			$this->Articulo_L2->ViewValue = $this->Articulo_L2->CurrentValue;
			$this->Articulo_L2->ViewCustomAttributes = "";

			// Articulo_L3
			$this->Articulo_L3->ViewValue = $this->Articulo_L3->CurrentValue;
			$this->Articulo_L3->ViewCustomAttributes = "";

			// Id_Compra_Det
			$this->Id_Compra_Det->LinkCustomAttributes = "";
			$this->Id_Compra_Det->HrefValue = "";
			$this->Id_Compra_Det->TooltipValue = "";

			// Articulo
			$this->Articulo->LinkCustomAttributes = "";
			$this->Articulo->HrefValue = "";
			$this->Articulo->TooltipValue = "";

			// Codigo
			$this->Codigo->LinkCustomAttributes = "";
			$this->Codigo->HrefValue = "";
			$this->Codigo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Compra_Det
			$this->Id_Compra_Det->EditCustomAttributes = "";
			if (trim(strval($this->Id_Compra_Det->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Etiqueta`" . ew_SearchString("=", $this->Id_Compra_Det->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT DISTINCT `Id_Etiqueta`, `Id_Etiqueta` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `barcode_accesorio`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Id_Etiqueta` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Compra_Det->EditValue = $arwrk;

			// Articulo
			$this->Articulo->EditCustomAttributes = "";
			$this->Articulo->EditValue = ew_HtmlEncode($this->Articulo->CurrentValue);
			if (strval($this->Articulo->CurrentValue) <> "") {
				$sFilterWrk = "`Articulo`" . ew_SearchString("=", $this->Articulo->CurrentValue, EW_DATATYPE_STRING);
			$sSqlWrk = "SELECT `Articulo`, `Articulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `ca_articulos`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Articulo` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Articulo->EditValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Articulo->EditValue = $this->Articulo->CurrentValue;
				}
			} else {
				$this->Articulo->EditValue = NULL;
			}

			// Codigo
			$this->Codigo->EditCustomAttributes = "";
			$this->Codigo->EditValue = ew_HtmlEncode($this->Codigo->CurrentValue);

			// Edit refer script
			// Id_Compra_Det

			$this->Id_Compra_Det->HrefValue = "";

			// Articulo
			$this->Articulo->HrefValue = "";

			// Codigo
			$this->Codigo->HrefValue = "";
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
		if (!is_null($this->Id_Compra_Det->FormValue) && $this->Id_Compra_Det->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Id_Compra_Det->FldCaption());
		}
		if (!is_null($this->Articulo->FormValue) && $this->Articulo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Articulo->FldCaption());
		}
		if (!is_null($this->Codigo->FormValue) && $this->Codigo->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->Codigo->FldCaption());
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
		$rsnew = array();

		// Id_Compra_Det
		$this->Id_Compra_Det->SetDbValueDef($rsnew, $this->Id_Compra_Det->CurrentValue, 0, strval($this->Id_Compra_Det->CurrentValue) == "");

		// Articulo
		$this->Articulo->SetDbValueDef($rsnew, $this->Articulo->CurrentValue, "", FALSE);

		// Codigo
		$this->Codigo->SetDbValueDef($rsnew, $this->Codigo->CurrentValue, "", FALSE);

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
			$this->Id_Etiqueta->setDbValue($conn->Insert_ID());
			$rsnew['Id_Etiqueta'] = $this->Id_Etiqueta->DbValue;
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
	  $GLOBALS["Language"]->setPhrase("Add", "");
	  $GLOBALS["Language"]->setPhrase("AddBtn", "GENERAR");  
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
if (!isset($barcode_accesorio_add)) $barcode_accesorio_add = new cbarcode_accesorio_add();

// Page init
$barcode_accesorio_add->Page_Init();

// Page main
$barcode_accesorio_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var barcode_accesorio_add = new ew_Page("barcode_accesorio_add");
barcode_accesorio_add.PageID = "add"; // Page ID
var EW_PAGE_ID = barcode_accesorio_add.PageID; // For backward compatibility

// Form object
var fbarcode_accesorioadd = new ew_Form("fbarcode_accesorioadd");

// Validate form
fbarcode_accesorioadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_Id_Compra_Det"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($barcode_accesorio->Id_Compra_Det->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Articulo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($barcode_accesorio->Articulo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_Codigo"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($barcode_accesorio->Codigo->FldCaption()) ?>");

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
fbarcode_accesorioadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbarcode_accesorioadd.ValidateRequired = true;
<?php } else { ?>
fbarcode_accesorioadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbarcode_accesorioadd.Lists["x_Id_Compra_Det"] = {"LinkField":"x_Id_Etiqueta","Ajax":true,"AutoFill":true,"DisplayFields":["x_Id_Etiqueta","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fbarcode_accesorioadd.Lists["x_Articulo"] = {"LinkField":"x_Articulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_Articulo","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $barcode_accesorio->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $barcode_accesorio->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $barcode_accesorio_add->ShowPageHeader(); ?>
<?php
$barcode_accesorio_add->ShowMessage();
?>
<form name="fbarcode_accesorioadd" id="fbarcode_accesorioadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="barcode_accesorio">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_barcode_accesorioadd" class="ewTable">
<?php if ($barcode_accesorio->Id_Compra_Det->Visible) { // Id_Compra_Det ?>
	<tr id="r_Id_Compra_Det"<?php echo $barcode_accesorio->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_barcode_accesorio_Id_Compra_Det"><table class="ewTableHeaderBtn"><tr><td><?php echo $barcode_accesorio->Id_Compra_Det->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $barcode_accesorio->Id_Compra_Det->CellAttributes() ?>><span id="el_barcode_accesorio_Id_Compra_Det">
<?php $barcode_accesorio->Id_Compra_Det->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$barcode_accesorio->Id_Compra_Det->EditAttrs["onchange"]; ?>
<select id="x_Id_Compra_Det" name="x_Id_Compra_Det"<?php echo $barcode_accesorio->Id_Compra_Det->EditAttributes() ?>>
<?php
if (is_array($barcode_accesorio->Id_Compra_Det->EditValue)) {
	$arwrk = $barcode_accesorio->Id_Compra_Det->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($barcode_accesorio->Id_Compra_Det->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<?php
$sSqlWrk = "SELECT DISTINCT `Id_Etiqueta`, `Id_Etiqueta` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `barcode_accesorio`";
$sWhereWrk = "";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Id_Etiqueta` ASC";
?>
<input type="hidden" name="s_x_Id_Compra_Det" id="s_x_Id_Compra_Det" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($barcode_accesorio->Id_Compra_Det->LookupFn) ?>&f0=<?php echo TEAencrypt("`Id_Etiqueta` = {filter_value}"); ?>&t0=3">
<?php
$sSqlWrk = "SELECT `Articulo` AS FIELD0, `Codigo` AS FIELD1 FROM `barcode_accesorio`";
$sWhereWrk = "(`Id_Etiqueta` = {query_value})";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Id_Etiqueta` ASC";
$sSqlWrk = TEAencrypt($sSqlWrk, EW_RANDOM_KEY);
?>
<input type="hidden" name="sf_x_Id_Compra_Det" id="sf_x_Id_Compra_Det" value="<?php echo $sSqlWrk ?>">
<input type="hidden" name="ln_x_Id_Compra_Det" id="ln_x_Id_Compra_Det" value="x_Articulo,x_Codigo">
</span><?php echo $barcode_accesorio->Id_Compra_Det->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($barcode_accesorio->Articulo->Visible) { // Articulo ?>
	<tr id="r_Articulo"<?php echo $barcode_accesorio->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_barcode_accesorio_Articulo"><table class="ewTableHeaderBtn"><tr><td><?php echo $barcode_accesorio->Articulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $barcode_accesorio->Articulo->CellAttributes() ?>><span id="el_barcode_accesorio_Articulo">
<?php
	$wrkonchange = trim(" " . @$barcode_accesorio->Articulo->EditAttrs["onchange"]);
	if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
	$barcode_accesorio->Articulo->EditAttrs["onchange"] = "";
?>
<span id="as_x_Articulo" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_Articulo" id="sv_x_Articulo" value="<?php echo $barcode_accesorio->Articulo->EditValue ?>" size="30" maxlength="70"<?php echo $barcode_accesorio->Articulo->EditAttributes() ?>>&nbsp;<span id="em_x_Articulo" class="ewMessage" style="display: none"><?php echo str_replace("%f", "phpimages/", $Language->Phrase("UnmatchedValue")) ?></span>
	<div id="sc_x_Articulo" style="display: inline; z-index: 8960"></div>
</span>
<input type="hidden" name="x_Articulo" id="x_Articulo" value="<?php echo $barcode_accesorio->Articulo->CurrentValue ?>"<?php echo $wrkonchange ?>>
<?php
$sSqlWrk = "SELECT `Articulo`, `Articulo` FROM `ca_articulos`";
$sWhereWrk = "`Articulo` LIKE '{query_value}%'";
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `Articulo` ASC";
$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
?>
<input type="hidden" name="q_x_Articulo" id="q_x_Articulo" value="s=<?php echo TEAencrypt($sSqlWrk) ?>&fn=<?php echo urlencode($barcode_accesorio->Articulo->LookupFn) ?>">
<script type="text/javascript">
var oas = new ew_AutoSuggest("x_Articulo", fbarcode_accesorioadd, false, EW_AUTO_SUGGEST_MAX_ENTRIES);
fbarcode_accesorioadd.AutoSuggests["x_Articulo"] = oas;
</script>
</span><?php echo $barcode_accesorio->Articulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($barcode_accesorio->Codigo->Visible) { // Codigo ?>
	<tr id="r_Codigo"<?php echo $barcode_accesorio->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_barcode_accesorio_Codigo"><table class="ewTableHeaderBtn"><tr><td><?php echo $barcode_accesorio->Codigo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></td></tr></table></span></td>
		<td<?php echo $barcode_accesorio->Codigo->CellAttributes() ?>><span id="el_barcode_accesorio_Codigo">
<input type="text" name="x_Codigo" id="x_Codigo" size="30" maxlength="22" value="<?php echo $barcode_accesorio->Codigo->EditValue ?>"<?php echo $barcode_accesorio->Codigo->EditAttributes() ?>>
</span><?php echo $barcode_accesorio->Codigo->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fbarcode_accesorioadd.Init();
</script>
<?php
$barcode_accesorio_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$barcode_accesorio_add->Page_Terminate();
?>
