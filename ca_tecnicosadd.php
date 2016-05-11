<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_tecnicosinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_tecnicos_add = NULL; // Initialize page object first

class cca_tecnicos_add extends cca_tecnicos {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_tecnicos';

	// Page object name
	var $PageObjName = 'ca_tecnicos_add';

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

		// Table object (ca_tecnicos)
		if (!isset($GLOBALS["ca_tecnicos"])) {
			$GLOBALS["ca_tecnicos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_tecnicos"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_tecnicos', TRUE);

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
			$this->Page_Terminate("ca_tecnicoslist.php");
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
			if (@$_GET["Id_Tecnico"] != "") {
				$this->Id_Tecnico->setQueryStringValue($_GET["Id_Tecnico"]);
				$this->setKey("Id_Tecnico", $this->Id_Tecnico->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Tecnico", ""); // Clear key
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
					$this->Page_Terminate("ca_tecnicoslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ca_tecnicosview.php")
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
		$this->Nombre->CurrentValue = NULL;
		$this->Nombre->OldValue = $this->Nombre->CurrentValue;
		$this->RFC->CurrentValue = NULL;
		$this->RFC->OldValue = $this->RFC->CurrentValue;
		$this->Domicilio->CurrentValue = NULL;
		$this->Domicilio->OldValue = $this->Domicilio->CurrentValue;
		$this->Poblacion->CurrentValue = NULL;
		$this->Poblacion->OldValue = $this->Poblacion->CurrentValue;
		$this->Municipio_Delegacion->CurrentValue = NULL;
		$this->Municipio_Delegacion->OldValue = $this->Municipio_Delegacion->CurrentValue;
		$this->Estado->CurrentValue = NULL;
		$this->Estado->OldValue = $this->Estado->CurrentValue;
		$this->CP->CurrentValue = NULL;
		$this->CP->OldValue = $this->CP->CurrentValue;
		$this->_EMail->CurrentValue = NULL;
		$this->_EMail->OldValue = $this->_EMail->CurrentValue;
		$this->Telefonos->CurrentValue = NULL;
		$this->Telefonos->OldValue = $this->Telefonos->CurrentValue;
		$this->Celular->CurrentValue = NULL;
		$this->Celular->OldValue = $this->Celular->CurrentValue;
		$this->Comentarios->CurrentValue = NULL;
		$this->Comentarios->OldValue = $this->Comentarios->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Nombre->FldIsDetailKey) {
			$this->Nombre->setFormValue($objForm->GetValue("x_Nombre"));
		}
		if (!$this->RFC->FldIsDetailKey) {
			$this->RFC->setFormValue($objForm->GetValue("x_RFC"));
		}
		if (!$this->Domicilio->FldIsDetailKey) {
			$this->Domicilio->setFormValue($objForm->GetValue("x_Domicilio"));
		}
		if (!$this->Poblacion->FldIsDetailKey) {
			$this->Poblacion->setFormValue($objForm->GetValue("x_Poblacion"));
		}
		if (!$this->Municipio_Delegacion->FldIsDetailKey) {
			$this->Municipio_Delegacion->setFormValue($objForm->GetValue("x_Municipio_Delegacion"));
		}
		if (!$this->Estado->FldIsDetailKey) {
			$this->Estado->setFormValue($objForm->GetValue("x_Estado"));
		}
		if (!$this->CP->FldIsDetailKey) {
			$this->CP->setFormValue($objForm->GetValue("x_CP"));
		}
		if (!$this->_EMail->FldIsDetailKey) {
			$this->_EMail->setFormValue($objForm->GetValue("x__EMail"));
		}
		if (!$this->Telefonos->FldIsDetailKey) {
			$this->Telefonos->setFormValue($objForm->GetValue("x_Telefonos"));
		}
		if (!$this->Celular->FldIsDetailKey) {
			$this->Celular->setFormValue($objForm->GetValue("x_Celular"));
		}
		if (!$this->Comentarios->FldIsDetailKey) {
			$this->Comentarios->setFormValue($objForm->GetValue("x_Comentarios"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->Nombre->CurrentValue = $this->Nombre->FormValue;
		$this->RFC->CurrentValue = $this->RFC->FormValue;
		$this->Domicilio->CurrentValue = $this->Domicilio->FormValue;
		$this->Poblacion->CurrentValue = $this->Poblacion->FormValue;
		$this->Municipio_Delegacion->CurrentValue = $this->Municipio_Delegacion->FormValue;
		$this->Estado->CurrentValue = $this->Estado->FormValue;
		$this->CP->CurrentValue = $this->CP->FormValue;
		$this->_EMail->CurrentValue = $this->_EMail->FormValue;
		$this->Telefonos->CurrentValue = $this->Telefonos->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Comentarios->CurrentValue = $this->Comentarios->FormValue;
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
		$this->Id_Tecnico->setDbValue($rs->fields('Id_Tecnico'));
		$this->Nombre->setDbValue($rs->fields('Nombre'));
		$this->RFC->setDbValue($rs->fields('RFC'));
		$this->Domicilio->setDbValue($rs->fields('Domicilio'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->Municipio_Delegacion->setDbValue($rs->fields('Municipio_Delegacion'));
		$this->Estado->setDbValue($rs->fields('Estado'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Telefonos->setDbValue($rs->fields('Telefonos'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Comentarios->setDbValue($rs->fields('Comentarios'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Tecnico")) <> "")
			$this->Id_Tecnico->CurrentValue = $this->getKey("Id_Tecnico"); // Id_Tecnico
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
		// Id_Tecnico
		// Nombre
		// RFC
		// Domicilio
		// Poblacion
		// Municipio_Delegacion
		// Estado
		// CP
		// EMail
		// Telefonos
		// Celular
		// Comentarios

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// Nombre
			$this->Nombre->ViewValue = $this->Nombre->CurrentValue;
			$this->Nombre->ViewCustomAttributes = "";

			// RFC
			$this->RFC->ViewValue = $this->RFC->CurrentValue;
			$this->RFC->ViewCustomAttributes = "";

			// Domicilio
			$this->Domicilio->ViewValue = $this->Domicilio->CurrentValue;
			$this->Domicilio->ViewCustomAttributes = "";

			// Poblacion
			$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
			$this->Poblacion->ViewCustomAttributes = "";

			// Municipio_Delegacion
			$this->Municipio_Delegacion->ViewValue = $this->Municipio_Delegacion->CurrentValue;
			$this->Municipio_Delegacion->ViewCustomAttributes = "";

			// Estado
			if (strval($this->Estado->CurrentValue) <> "") {
				$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Estado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Estado->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Estado->ViewValue = $this->Estado->CurrentValue;
				}
			} else {
				$this->Estado->ViewValue = NULL;
			}
			$this->Estado->ViewCustomAttributes = "";

			// CP
			$this->CP->ViewValue = $this->CP->CurrentValue;
			$this->CP->ViewCustomAttributes = "";

			// EMail
			$this->_EMail->ViewValue = $this->_EMail->CurrentValue;
			$this->_EMail->ViewCustomAttributes = "";

			// Telefonos
			$this->Telefonos->ViewValue = $this->Telefonos->CurrentValue;
			$this->Telefonos->ViewCustomAttributes = "";

			// Celular
			$this->Celular->ViewValue = $this->Celular->CurrentValue;
			$this->Celular->ViewCustomAttributes = "";

			// Comentarios
			$this->Comentarios->ViewValue = $this->Comentarios->CurrentValue;
			$this->Comentarios->ViewCustomAttributes = "";

			// Nombre
			$this->Nombre->LinkCustomAttributes = "";
			$this->Nombre->HrefValue = "";
			$this->Nombre->TooltipValue = "";

			// RFC
			$this->RFC->LinkCustomAttributes = "";
			$this->RFC->HrefValue = "";
			$this->RFC->TooltipValue = "";

			// Domicilio
			$this->Domicilio->LinkCustomAttributes = "";
			$this->Domicilio->HrefValue = "";
			$this->Domicilio->TooltipValue = "";

			// Poblacion
			$this->Poblacion->LinkCustomAttributes = "";
			$this->Poblacion->HrefValue = "";
			$this->Poblacion->TooltipValue = "";

			// Municipio_Delegacion
			$this->Municipio_Delegacion->LinkCustomAttributes = "";
			$this->Municipio_Delegacion->HrefValue = "";
			$this->Municipio_Delegacion->TooltipValue = "";

			// Estado
			$this->Estado->LinkCustomAttributes = "";
			$this->Estado->HrefValue = "";
			$this->Estado->TooltipValue = "";

			// CP
			$this->CP->LinkCustomAttributes = "";
			$this->CP->HrefValue = "";
			$this->CP->TooltipValue = "";

			// EMail
			$this->_EMail->LinkCustomAttributes = "";
			$this->_EMail->HrefValue = "";
			$this->_EMail->TooltipValue = "";

			// Telefonos
			$this->Telefonos->LinkCustomAttributes = "";
			$this->Telefonos->HrefValue = "";
			$this->Telefonos->TooltipValue = "";

			// Celular
			$this->Celular->LinkCustomAttributes = "";
			$this->Celular->HrefValue = "";
			$this->Celular->TooltipValue = "";

			// Comentarios
			$this->Comentarios->LinkCustomAttributes = "";
			$this->Comentarios->HrefValue = "";
			$this->Comentarios->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Nombre
			$this->Nombre->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Nombre->EditValue = ew_HtmlEncode($this->Nombre->CurrentValue);

			// RFC
			$this->RFC->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->RFC->EditValue = ew_HtmlEncode($this->RFC->CurrentValue);

			// Domicilio
			$this->Domicilio->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Domicilio->EditValue = ew_HtmlEncode($this->Domicilio->CurrentValue);

			// Poblacion
			$this->Poblacion->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Poblacion->EditValue = ew_HtmlEncode($this->Poblacion->CurrentValue);

			// Municipio_Delegacion
			$this->Municipio_Delegacion->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Municipio_Delegacion->EditValue = ew_HtmlEncode($this->Municipio_Delegacion->CurrentValue);

			// Estado
			$this->Estado->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Estado->EditValue = $arwrk;

			// CP
			$this->CP->EditCustomAttributes = "";
			$this->CP->EditValue = ew_HtmlEncode($this->CP->CurrentValue);

			// EMail
			$this->_EMail->EditCustomAttributes = "";
			$this->_EMail->EditValue = ew_HtmlEncode($this->_EMail->CurrentValue);

			// Telefonos
			$this->Telefonos->EditCustomAttributes = "";
			$this->Telefonos->EditValue = ew_HtmlEncode($this->Telefonos->CurrentValue);

			// Celular
			$this->Celular->EditCustomAttributes = "";
			$this->Celular->EditValue = ew_HtmlEncode($this->Celular->CurrentValue);

			// Comentarios
			$this->Comentarios->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Comentarios->EditValue = ew_HtmlEncode($this->Comentarios->CurrentValue);

			// Edit refer script
			// Nombre

			$this->Nombre->HrefValue = "";

			// RFC
			$this->RFC->HrefValue = "";

			// Domicilio
			$this->Domicilio->HrefValue = "";

			// Poblacion
			$this->Poblacion->HrefValue = "";

			// Municipio_Delegacion
			$this->Municipio_Delegacion->HrefValue = "";

			// Estado
			$this->Estado->HrefValue = "";

			// CP
			$this->CP->HrefValue = "";

			// EMail
			$this->_EMail->HrefValue = "";

			// Telefonos
			$this->Telefonos->HrefValue = "";

			// Celular
			$this->Celular->HrefValue = "";

			// Comentarios
			$this->Comentarios->HrefValue = "";
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
		if ($this->Nombre->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Nombre = '" . ew_AdjustSql($this->Nombre->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Nombre->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Nombre->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// Nombre
		$this->Nombre->SetDbValueDef($rsnew, $this->Nombre->CurrentValue, NULL, FALSE);

		// RFC
		$this->RFC->SetDbValueDef($rsnew, $this->RFC->CurrentValue, NULL, FALSE);

		// Domicilio
		$this->Domicilio->SetDbValueDef($rsnew, $this->Domicilio->CurrentValue, NULL, FALSE);

		// Poblacion
		$this->Poblacion->SetDbValueDef($rsnew, $this->Poblacion->CurrentValue, NULL, FALSE);

		// Municipio_Delegacion
		$this->Municipio_Delegacion->SetDbValueDef($rsnew, $this->Municipio_Delegacion->CurrentValue, NULL, FALSE);

		// Estado
		$this->Estado->SetDbValueDef($rsnew, $this->Estado->CurrentValue, NULL, FALSE);

		// CP
		$this->CP->SetDbValueDef($rsnew, $this->CP->CurrentValue, NULL, FALSE);

		// EMail
		$this->_EMail->SetDbValueDef($rsnew, $this->_EMail->CurrentValue, NULL, FALSE);

		// Telefonos
		$this->Telefonos->SetDbValueDef($rsnew, $this->Telefonos->CurrentValue, NULL, FALSE);

		// Celular
		$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, FALSE);

		// Comentarios
		$this->Comentarios->SetDbValueDef($rsnew, $this->Comentarios->CurrentValue, NULL, FALSE);

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
			$this->Id_Tecnico->setDbValue($conn->Insert_ID());
			$rsnew['Id_Tecnico'] = $this->Id_Tecnico->DbValue;
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
if (!isset($ca_tecnicos_add)) $ca_tecnicos_add = new cca_tecnicos_add();

// Page init
$ca_tecnicos_add->Page_Init();

// Page main
$ca_tecnicos_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var ca_tecnicos_add = new ew_Page("ca_tecnicos_add");
ca_tecnicos_add.PageID = "add"; // Page ID
var EW_PAGE_ID = ca_tecnicos_add.PageID; // For backward compatibility

// Form object
var fca_tecnicosadd = new ew_Form("fca_tecnicosadd");

// Validate form
fca_tecnicosadd.Validate = function(fobj) {
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
fca_tecnicosadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_tecnicosadd.ValidateRequired = true;
<?php } else { ?>
fca_tecnicosadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_tecnicosadd.Lists["x_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_tecnicos->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $ca_tecnicos->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $ca_tecnicos_add->ShowPageHeader(); ?>
<?php
$ca_tecnicos_add->ShowMessage();
?>
<form name="fca_tecnicosadd" id="fca_tecnicosadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="ca_tecnicos">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_ca_tecnicosadd" class="ewTable">
<?php if ($ca_tecnicos->Nombre->Visible) { // Nombre ?>
	<tr id="r_Nombre"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Nombre"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Nombre->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Nombre->CellAttributes() ?>><span id="el_ca_tecnicos_Nombre">
<input type="text" name="x_Nombre" id="x_Nombre" size="30" maxlength="50" value="<?php echo $ca_tecnicos->Nombre->EditValue ?>"<?php echo $ca_tecnicos->Nombre->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->Nombre->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->RFC->Visible) { // RFC ?>
	<tr id="r_RFC"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_RFC"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->RFC->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->RFC->CellAttributes() ?>><span id="el_ca_tecnicos_RFC">
<input type="text" name="x_RFC" id="x_RFC" size="30" maxlength="13" value="<?php echo $ca_tecnicos->RFC->EditValue ?>"<?php echo $ca_tecnicos->RFC->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->RFC->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->Domicilio->Visible) { // Domicilio ?>
	<tr id="r_Domicilio"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Domicilio"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Domicilio->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Domicilio->CellAttributes() ?>><span id="el_ca_tecnicos_Domicilio">
<input type="text" name="x_Domicilio" id="x_Domicilio" size="30" maxlength="50" value="<?php echo $ca_tecnicos->Domicilio->EditValue ?>"<?php echo $ca_tecnicos->Domicilio->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->Domicilio->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->Poblacion->Visible) { // Poblacion ?>
	<tr id="r_Poblacion"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Poblacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Poblacion->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Poblacion->CellAttributes() ?>><span id="el_ca_tecnicos_Poblacion">
<input type="text" name="x_Poblacion" id="x_Poblacion" size="30" value="<?php echo $ca_tecnicos->Poblacion->EditValue ?>"<?php echo $ca_tecnicos->Poblacion->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->Poblacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->Municipio_Delegacion->Visible) { // Municipio_Delegacion ?>
	<tr id="r_Municipio_Delegacion"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Municipio_Delegacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Municipio_Delegacion->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Municipio_Delegacion->CellAttributes() ?>><span id="el_ca_tecnicos_Municipio_Delegacion">
<input type="text" name="x_Municipio_Delegacion" id="x_Municipio_Delegacion" size="30" value="<?php echo $ca_tecnicos->Municipio_Delegacion->EditValue ?>"<?php echo $ca_tecnicos->Municipio_Delegacion->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->Municipio_Delegacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->Estado->Visible) { // Estado ?>
	<tr id="r_Estado"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Estado"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Estado->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Estado->CellAttributes() ?>><span id="el_ca_tecnicos_Estado">
<select id="x_Estado" name="x_Estado"<?php echo $ca_tecnicos->Estado->EditAttributes() ?>>
<?php
if (is_array($ca_tecnicos->Estado->EditValue)) {
	$arwrk = $ca_tecnicos->Estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_tecnicos->Estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_tecnicosadd.Lists["x_Estado"].Options = <?php echo (is_array($ca_tecnicos->Estado->EditValue)) ? ew_ArrayToJson($ca_tecnicos->Estado->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $ca_tecnicos->Estado->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->CP->Visible) { // CP ?>
	<tr id="r_CP"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_CP"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->CP->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->CP->CellAttributes() ?>><span id="el_ca_tecnicos_CP">
<input type="text" name="x_CP" id="x_CP" size="30" maxlength="5" value="<?php echo $ca_tecnicos->CP->EditValue ?>"<?php echo $ca_tecnicos->CP->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->CP->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->_EMail->Visible) { // EMail ?>
	<tr id="r__EMail"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos__EMail"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->_EMail->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->_EMail->CellAttributes() ?>><span id="el_ca_tecnicos__EMail">
<input type="text" name="x__EMail" id="x__EMail" size="30" maxlength="30" value="<?php echo $ca_tecnicos->_EMail->EditValue ?>"<?php echo $ca_tecnicos->_EMail->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->_EMail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->Telefonos->Visible) { // Telefonos ?>
	<tr id="r_Telefonos"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Telefonos"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Telefonos->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Telefonos->CellAttributes() ?>><span id="el_ca_tecnicos_Telefonos">
<input type="text" name="x_Telefonos" id="x_Telefonos" size="30" maxlength="50" value="<?php echo $ca_tecnicos->Telefonos->EditValue ?>"<?php echo $ca_tecnicos->Telefonos->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->Telefonos->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->Celular->Visible) { // Celular ?>
	<tr id="r_Celular"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Celular"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Celular->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Celular->CellAttributes() ?>><span id="el_ca_tecnicos_Celular">
<input type="text" name="x_Celular" id="x_Celular" size="30" maxlength="50" value="<?php echo $ca_tecnicos->Celular->EditValue ?>"<?php echo $ca_tecnicos->Celular->EditAttributes() ?>>
</span><?php echo $ca_tecnicos->Celular->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_tecnicos->Comentarios->Visible) { // Comentarios ?>
	<tr id="r_Comentarios"<?php echo $ca_tecnicos->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_tecnicos_Comentarios"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_tecnicos->Comentarios->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_tecnicos->Comentarios->CellAttributes() ?>><span id="el_ca_tecnicos_Comentarios">
<textarea name="x_Comentarios" id="x_Comentarios" cols="35" rows="4"<?php echo $ca_tecnicos->Comentarios->EditAttributes() ?>><?php echo $ca_tecnicos->Comentarios->EditValue ?></textarea>
</span><?php echo $ca_tecnicos->Comentarios->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fca_tecnicosadd.Init();
</script>
<?php
$ca_tecnicos_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ca_tecnicos_add->Page_Terminate();
?>
