<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "ca_proveedoresinfo.php" ?>
<?php include_once "sys_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$ca_proveedores_add = NULL; // Initialize page object first

class cca_proveedores_add extends cca_proveedores {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{088194B1-0859-48EB-80AB-AC982CB21F9E}";

	// Table name
	var $TableName = 'ca_proveedores';

	// Page object name
	var $PageObjName = 'ca_proveedores_add';

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

		// Table object (ca_proveedores)
		if (!isset($GLOBALS["ca_proveedores"])) {
			$GLOBALS["ca_proveedores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["ca_proveedores"];
		}

		// Table object (sys_user)
		if (!isset($GLOBALS['sys_user'])) $GLOBALS['sys_user'] = new csys_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'ca_proveedores', TRUE);

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
			$this->Page_Terminate("ca_proveedoreslist.php");
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
			if (@$_GET["Id_Proveedor"] != "") {
				$this->Id_Proveedor->setQueryStringValue($_GET["Id_Proveedor"]);
				$this->setKey("Id_Proveedor", $this->Id_Proveedor->CurrentValue); // Set up key
			} else {
				$this->setKey("Id_Proveedor", ""); // Clear key
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
					$this->Page_Terminate("ca_proveedoreslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "ca_proveedoresview.php")
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
		$this->RazonSocial->CurrentValue = NULL;
		$this->RazonSocial->OldValue = $this->RazonSocial->CurrentValue;
		$this->RFC->CurrentValue = NULL;
		$this->RFC->OldValue = $this->RFC->CurrentValue;
		$this->NombreContacto->CurrentValue = NULL;
		$this->NombreContacto->OldValue = $this->NombreContacto->CurrentValue;
		$this->CalleYNumero->CurrentValue = NULL;
		$this->CalleYNumero->OldValue = $this->CalleYNumero->CurrentValue;
		$this->Colonia->CurrentValue = NULL;
		$this->Colonia->OldValue = $this->Colonia->CurrentValue;
		$this->Poblacion->CurrentValue = NULL;
		$this->Poblacion->OldValue = $this->Poblacion->CurrentValue;
		$this->Municipio_Delegacion->CurrentValue = NULL;
		$this->Municipio_Delegacion->OldValue = $this->Municipio_Delegacion->CurrentValue;
		$this->Id_Estado->CurrentValue = NULL;
		$this->Id_Estado->OldValue = $this->Id_Estado->CurrentValue;
		$this->CP->CurrentValue = NULL;
		$this->CP->OldValue = $this->CP->CurrentValue;
		$this->_EMail->CurrentValue = NULL;
		$this->_EMail->OldValue = $this->_EMail->CurrentValue;
		$this->Telefonos->CurrentValue = NULL;
		$this->Telefonos->OldValue = $this->Telefonos->CurrentValue;
		$this->Celular->CurrentValue = NULL;
		$this->Celular->OldValue = $this->Celular->CurrentValue;
		$this->Fax->CurrentValue = NULL;
		$this->Fax->OldValue = $this->Fax->CurrentValue;
		$this->Banco->CurrentValue = NULL;
		$this->Banco->OldValue = $this->Banco->CurrentValue;
		$this->NumCuenta->CurrentValue = NULL;
		$this->NumCuenta->OldValue = $this->NumCuenta->CurrentValue;
		$this->CLABE->CurrentValue = NULL;
		$this->CLABE->OldValue = $this->CLABE->CurrentValue;
		$this->Maneja_Papeleta->CurrentValue = "NO";
		$this->Observaciones->CurrentValue = NULL;
		$this->Observaciones->OldValue = $this->Observaciones->CurrentValue;
		$this->Maneja_Activacion_Movi->CurrentValue = "NO";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->RazonSocial->FldIsDetailKey) {
			$this->RazonSocial->setFormValue($objForm->GetValue("x_RazonSocial"));
		}
		if (!$this->RFC->FldIsDetailKey) {
			$this->RFC->setFormValue($objForm->GetValue("x_RFC"));
		}
		if (!$this->NombreContacto->FldIsDetailKey) {
			$this->NombreContacto->setFormValue($objForm->GetValue("x_NombreContacto"));
		}
		if (!$this->CalleYNumero->FldIsDetailKey) {
			$this->CalleYNumero->setFormValue($objForm->GetValue("x_CalleYNumero"));
		}
		if (!$this->Colonia->FldIsDetailKey) {
			$this->Colonia->setFormValue($objForm->GetValue("x_Colonia"));
		}
		if (!$this->Poblacion->FldIsDetailKey) {
			$this->Poblacion->setFormValue($objForm->GetValue("x_Poblacion"));
		}
		if (!$this->Municipio_Delegacion->FldIsDetailKey) {
			$this->Municipio_Delegacion->setFormValue($objForm->GetValue("x_Municipio_Delegacion"));
		}
		if (!$this->Id_Estado->FldIsDetailKey) {
			$this->Id_Estado->setFormValue($objForm->GetValue("x_Id_Estado"));
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
		if (!$this->Fax->FldIsDetailKey) {
			$this->Fax->setFormValue($objForm->GetValue("x_Fax"));
		}
		if (!$this->Banco->FldIsDetailKey) {
			$this->Banco->setFormValue($objForm->GetValue("x_Banco"));
		}
		if (!$this->NumCuenta->FldIsDetailKey) {
			$this->NumCuenta->setFormValue($objForm->GetValue("x_NumCuenta"));
		}
		if (!$this->CLABE->FldIsDetailKey) {
			$this->CLABE->setFormValue($objForm->GetValue("x_CLABE"));
		}
		if (!$this->Maneja_Papeleta->FldIsDetailKey) {
			$this->Maneja_Papeleta->setFormValue($objForm->GetValue("x_Maneja_Papeleta"));
		}
		if (!$this->Observaciones->FldIsDetailKey) {
			$this->Observaciones->setFormValue($objForm->GetValue("x_Observaciones"));
		}
		if (!$this->Maneja_Activacion_Movi->FldIsDetailKey) {
			$this->Maneja_Activacion_Movi->setFormValue($objForm->GetValue("x_Maneja_Activacion_Movi"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->RazonSocial->CurrentValue = $this->RazonSocial->FormValue;
		$this->RFC->CurrentValue = $this->RFC->FormValue;
		$this->NombreContacto->CurrentValue = $this->NombreContacto->FormValue;
		$this->CalleYNumero->CurrentValue = $this->CalleYNumero->FormValue;
		$this->Colonia->CurrentValue = $this->Colonia->FormValue;
		$this->Poblacion->CurrentValue = $this->Poblacion->FormValue;
		$this->Municipio_Delegacion->CurrentValue = $this->Municipio_Delegacion->FormValue;
		$this->Id_Estado->CurrentValue = $this->Id_Estado->FormValue;
		$this->CP->CurrentValue = $this->CP->FormValue;
		$this->_EMail->CurrentValue = $this->_EMail->FormValue;
		$this->Telefonos->CurrentValue = $this->Telefonos->FormValue;
		$this->Celular->CurrentValue = $this->Celular->FormValue;
		$this->Fax->CurrentValue = $this->Fax->FormValue;
		$this->Banco->CurrentValue = $this->Banco->FormValue;
		$this->NumCuenta->CurrentValue = $this->NumCuenta->FormValue;
		$this->CLABE->CurrentValue = $this->CLABE->FormValue;
		$this->Maneja_Papeleta->CurrentValue = $this->Maneja_Papeleta->FormValue;
		$this->Observaciones->CurrentValue = $this->Observaciones->FormValue;
		$this->Maneja_Activacion_Movi->CurrentValue = $this->Maneja_Activacion_Movi->FormValue;
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
		$this->Id_Proveedor->setDbValue($rs->fields('Id_Proveedor'));
		$this->RazonSocial->setDbValue($rs->fields('RazonSocial'));
		$this->RFC->setDbValue($rs->fields('RFC'));
		$this->NombreContacto->setDbValue($rs->fields('NombreContacto'));
		$this->CalleYNumero->setDbValue($rs->fields('CalleYNumero'));
		$this->Colonia->setDbValue($rs->fields('Colonia'));
		$this->Poblacion->setDbValue($rs->fields('Poblacion'));
		$this->Municipio_Delegacion->setDbValue($rs->fields('Municipio_Delegacion'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->CP->setDbValue($rs->fields('CP'));
		$this->_EMail->setDbValue($rs->fields('EMail'));
		$this->Telefonos->setDbValue($rs->fields('Telefonos'));
		$this->Celular->setDbValue($rs->fields('Celular'));
		$this->Fax->setDbValue($rs->fields('Fax'));
		$this->Banco->setDbValue($rs->fields('Banco'));
		$this->NumCuenta->setDbValue($rs->fields('NumCuenta'));
		$this->CLABE->setDbValue($rs->fields('CLABE'));
		$this->Maneja_Papeleta->setDbValue($rs->fields('Maneja_Papeleta'));
		$this->Observaciones->setDbValue($rs->fields('Observaciones'));
		$this->Maneja_Activacion_Movi->setDbValue($rs->fields('Maneja_Activacion_Movi'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Proveedor")) <> "")
			$this->Id_Proveedor->CurrentValue = $this->getKey("Id_Proveedor"); // Id_Proveedor
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
		// Id_Proveedor
		// RazonSocial
		// RFC
		// NombreContacto
		// CalleYNumero
		// Colonia
		// Poblacion
		// Municipio_Delegacion
		// Id_Estado
		// CP
		// EMail
		// Telefonos
		// Celular
		// Fax
		// Banco
		// NumCuenta
		// CLABE
		// Maneja_Papeleta
		// Observaciones
		// Maneja_Activacion_Movi

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// RazonSocial
			$this->RazonSocial->ViewValue = $this->RazonSocial->CurrentValue;
			$this->RazonSocial->ViewValue = strtoupper($this->RazonSocial->ViewValue);
			$this->RazonSocial->ViewCustomAttributes = "";

			// RFC
			$this->RFC->ViewValue = $this->RFC->CurrentValue;
			$this->RFC->ViewValue = strtoupper($this->RFC->ViewValue);
			$this->RFC->ViewCustomAttributes = "";

			// NombreContacto
			$this->NombreContacto->ViewValue = $this->NombreContacto->CurrentValue;
			$this->NombreContacto->ViewValue = strtoupper($this->NombreContacto->ViewValue);
			$this->NombreContacto->ViewCustomAttributes = "";

			// CalleYNumero
			$this->CalleYNumero->ViewValue = $this->CalleYNumero->CurrentValue;
			$this->CalleYNumero->ViewValue = strtoupper($this->CalleYNumero->ViewValue);
			$this->CalleYNumero->ViewCustomAttributes = "";

			// Colonia
			$this->Colonia->ViewValue = $this->Colonia->CurrentValue;
			$this->Colonia->ViewValue = strtoupper($this->Colonia->ViewValue);
			$this->Colonia->ViewCustomAttributes = "";

			// Poblacion
			$this->Poblacion->ViewValue = $this->Poblacion->CurrentValue;
			$this->Poblacion->ViewValue = strtoupper($this->Poblacion->ViewValue);
			$this->Poblacion->ViewCustomAttributes = "";

			// Municipio_Delegacion
			$this->Municipio_Delegacion->ViewValue = $this->Municipio_Delegacion->CurrentValue;
			$this->Municipio_Delegacion->ViewCustomAttributes = "";

			// Id_Estado
			if (strval($this->Id_Estado->CurrentValue) <> "") {
				$sFilterWrk = "`Id_estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Estado` Asc";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->Id_Estado->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
				}
			} else {
				$this->Id_Estado->ViewValue = NULL;
			}
			$this->Id_Estado->ViewCustomAttributes = "";

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

			// Fax
			$this->Fax->ViewValue = $this->Fax->CurrentValue;
			$this->Fax->ViewCustomAttributes = "";

			// Banco
			$this->Banco->ViewValue = $this->Banco->CurrentValue;
			$this->Banco->ViewCustomAttributes = "";

			// NumCuenta
			$this->NumCuenta->ViewValue = $this->NumCuenta->CurrentValue;
			$this->NumCuenta->ViewCustomAttributes = "";

			// CLABE
			$this->CLABE->ViewValue = $this->CLABE->CurrentValue;
			$this->CLABE->ViewCustomAttributes = "";

			// Maneja_Papeleta
			if (strval($this->Maneja_Papeleta->CurrentValue) <> "") {
				switch ($this->Maneja_Papeleta->CurrentValue) {
					case $this->Maneja_Papeleta->FldTagValue(1):
						$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->FldTagCaption(1) <> "" ? $this->Maneja_Papeleta->FldTagCaption(1) : $this->Maneja_Papeleta->CurrentValue;
						break;
					case $this->Maneja_Papeleta->FldTagValue(2):
						$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->FldTagCaption(2) <> "" ? $this->Maneja_Papeleta->FldTagCaption(2) : $this->Maneja_Papeleta->CurrentValue;
						break;
					default:
						$this->Maneja_Papeleta->ViewValue = $this->Maneja_Papeleta->CurrentValue;
				}
			} else {
				$this->Maneja_Papeleta->ViewValue = NULL;
			}
			$this->Maneja_Papeleta->ViewCustomAttributes = "";

			// Observaciones
			$this->Observaciones->ViewValue = $this->Observaciones->CurrentValue;
			$this->Observaciones->ViewValue = strtoupper($this->Observaciones->ViewValue);
			$this->Observaciones->ViewCustomAttributes = "";

			// Maneja_Activacion_Movi
			if (strval($this->Maneja_Activacion_Movi->CurrentValue) <> "") {
				switch ($this->Maneja_Activacion_Movi->CurrentValue) {
					case $this->Maneja_Activacion_Movi->FldTagValue(1):
						$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->FldTagCaption(1) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(1) : $this->Maneja_Activacion_Movi->CurrentValue;
						break;
					case $this->Maneja_Activacion_Movi->FldTagValue(2):
						$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->FldTagCaption(2) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(2) : $this->Maneja_Activacion_Movi->CurrentValue;
						break;
					default:
						$this->Maneja_Activacion_Movi->ViewValue = $this->Maneja_Activacion_Movi->CurrentValue;
				}
			} else {
				$this->Maneja_Activacion_Movi->ViewValue = NULL;
			}
			$this->Maneja_Activacion_Movi->ViewCustomAttributes = "";

			// RazonSocial
			$this->RazonSocial->LinkCustomAttributes = "";
			$this->RazonSocial->HrefValue = "";
			$this->RazonSocial->TooltipValue = "";

			// RFC
			$this->RFC->LinkCustomAttributes = "";
			$this->RFC->HrefValue = "";
			$this->RFC->TooltipValue = "";

			// NombreContacto
			$this->NombreContacto->LinkCustomAttributes = "";
			$this->NombreContacto->HrefValue = "";
			$this->NombreContacto->TooltipValue = "";

			// CalleYNumero
			$this->CalleYNumero->LinkCustomAttributes = "";
			$this->CalleYNumero->HrefValue = "";
			$this->CalleYNumero->TooltipValue = "";

			// Colonia
			$this->Colonia->LinkCustomAttributes = "";
			$this->Colonia->HrefValue = "";
			$this->Colonia->TooltipValue = "";

			// Poblacion
			$this->Poblacion->LinkCustomAttributes = "";
			$this->Poblacion->HrefValue = "";
			$this->Poblacion->TooltipValue = "";

			// Municipio_Delegacion
			$this->Municipio_Delegacion->LinkCustomAttributes = "";
			$this->Municipio_Delegacion->HrefValue = "";
			$this->Municipio_Delegacion->TooltipValue = "";

			// Id_Estado
			$this->Id_Estado->LinkCustomAttributes = "";
			$this->Id_Estado->HrefValue = "";
			$this->Id_Estado->TooltipValue = "";

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

			// Fax
			$this->Fax->LinkCustomAttributes = "";
			$this->Fax->HrefValue = "";
			$this->Fax->TooltipValue = "";

			// Banco
			$this->Banco->LinkCustomAttributes = "";
			$this->Banco->HrefValue = "";
			$this->Banco->TooltipValue = "";

			// NumCuenta
			$this->NumCuenta->LinkCustomAttributes = "";
			$this->NumCuenta->HrefValue = "";
			$this->NumCuenta->TooltipValue = "";

			// CLABE
			$this->CLABE->LinkCustomAttributes = "";
			$this->CLABE->HrefValue = "";
			$this->CLABE->TooltipValue = "";

			// Maneja_Papeleta
			$this->Maneja_Papeleta->LinkCustomAttributes = "";
			$this->Maneja_Papeleta->HrefValue = "";
			$this->Maneja_Papeleta->TooltipValue = "";

			// Observaciones
			$this->Observaciones->LinkCustomAttributes = "";
			$this->Observaciones->HrefValue = "";
			$this->Observaciones->TooltipValue = "";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->LinkCustomAttributes = "";
			$this->Maneja_Activacion_Movi->HrefValue = "";
			$this->Maneja_Activacion_Movi->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// RazonSocial
			$this->RazonSocial->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->RazonSocial->EditValue = ew_HtmlEncode($this->RazonSocial->CurrentValue);

			// RFC
			$this->RFC->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->RFC->EditValue = ew_HtmlEncode($this->RFC->CurrentValue);

			// NombreContacto
			$this->NombreContacto->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->NombreContacto->EditValue = ew_HtmlEncode($this->NombreContacto->CurrentValue);

			// CalleYNumero
			$this->CalleYNumero->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->CalleYNumero->EditValue = ew_HtmlEncode($this->CalleYNumero->CurrentValue);

			// Colonia
			$this->Colonia->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Colonia->EditValue = ew_HtmlEncode($this->Colonia->CurrentValue);

			// Poblacion
			$this->Poblacion->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Poblacion->EditValue = ew_HtmlEncode($this->Poblacion->CurrentValue);

			// Municipio_Delegacion
			$this->Municipio_Delegacion->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Municipio_Delegacion->EditValue = ew_HtmlEncode($this->Municipio_Delegacion->CurrentValue);

			// Id_Estado
			$this->Id_Estado->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `Id_estado`, `Estado` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `li_estados`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Estado` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->Id_Estado->EditValue = $arwrk;

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

			// Fax
			$this->Fax->EditCustomAttributes = "";
			$this->Fax->EditValue = ew_HtmlEncode($this->Fax->CurrentValue);

			// Banco
			$this->Banco->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Banco->EditValue = ew_HtmlEncode($this->Banco->CurrentValue);

			// NumCuenta
			$this->NumCuenta->EditCustomAttributes = "";
			$this->NumCuenta->EditValue = ew_HtmlEncode($this->NumCuenta->CurrentValue);

			// CLABE
			$this->CLABE->EditCustomAttributes = "";
			$this->CLABE->EditValue = ew_HtmlEncode($this->CLABE->CurrentValue);

			// Maneja_Papeleta
			$this->Maneja_Papeleta->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Maneja_Papeleta->FldTagValue(1), $this->Maneja_Papeleta->FldTagCaption(1) <> "" ? $this->Maneja_Papeleta->FldTagCaption(1) : $this->Maneja_Papeleta->FldTagValue(1));
			$arwrk[] = array($this->Maneja_Papeleta->FldTagValue(2), $this->Maneja_Papeleta->FldTagCaption(2) <> "" ? $this->Maneja_Papeleta->FldTagCaption(2) : $this->Maneja_Papeleta->FldTagValue(2));
			$this->Maneja_Papeleta->EditValue = $arwrk;

			// Observaciones
			$this->Observaciones->EditCustomAttributes = 'class="mayusculas" onchange="conMayusculas(this)" autocomplete="off" ';
			$this->Observaciones->EditValue = ew_HtmlEncode($this->Observaciones->CurrentValue);

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->Maneja_Activacion_Movi->FldTagValue(1), $this->Maneja_Activacion_Movi->FldTagCaption(1) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(1) : $this->Maneja_Activacion_Movi->FldTagValue(1));
			$arwrk[] = array($this->Maneja_Activacion_Movi->FldTagValue(2), $this->Maneja_Activacion_Movi->FldTagCaption(2) <> "" ? $this->Maneja_Activacion_Movi->FldTagCaption(2) : $this->Maneja_Activacion_Movi->FldTagValue(2));
			$this->Maneja_Activacion_Movi->EditValue = $arwrk;

			// Edit refer script
			// RazonSocial

			$this->RazonSocial->HrefValue = "";

			// RFC
			$this->RFC->HrefValue = "";

			// NombreContacto
			$this->NombreContacto->HrefValue = "";

			// CalleYNumero
			$this->CalleYNumero->HrefValue = "";

			// Colonia
			$this->Colonia->HrefValue = "";

			// Poblacion
			$this->Poblacion->HrefValue = "";

			// Municipio_Delegacion
			$this->Municipio_Delegacion->HrefValue = "";

			// Id_Estado
			$this->Id_Estado->HrefValue = "";

			// CP
			$this->CP->HrefValue = "";

			// EMail
			$this->_EMail->HrefValue = "";

			// Telefonos
			$this->Telefonos->HrefValue = "";

			// Celular
			$this->Celular->HrefValue = "";

			// Fax
			$this->Fax->HrefValue = "";

			// Banco
			$this->Banco->HrefValue = "";

			// NumCuenta
			$this->NumCuenta->HrefValue = "";

			// CLABE
			$this->CLABE->HrefValue = "";

			// Maneja_Papeleta
			$this->Maneja_Papeleta->HrefValue = "";

			// Observaciones
			$this->Observaciones->HrefValue = "";

			// Maneja_Activacion_Movi
			$this->Maneja_Activacion_Movi->HrefValue = "";
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
		if ($this->RazonSocial->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(RazonSocial = '" . ew_AdjustSql($this->RazonSocial->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->RazonSocial->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->RazonSocial->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->RFC->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(RFC = '" . ew_AdjustSql($this->RFC->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->RFC->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->RFC->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		if ($this->NombreContacto->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(NombreContacto = '" . ew_AdjustSql($this->NombreContacto->CurrentValue) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->NombreContacto->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->NombreContacto->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$rsnew = array();

		// RazonSocial
		$this->RazonSocial->SetDbValueDef($rsnew, $this->RazonSocial->CurrentValue, NULL, FALSE);

		// RFC
		$this->RFC->SetDbValueDef($rsnew, $this->RFC->CurrentValue, NULL, FALSE);

		// NombreContacto
		$this->NombreContacto->SetDbValueDef($rsnew, $this->NombreContacto->CurrentValue, NULL, FALSE);

		// CalleYNumero
		$this->CalleYNumero->SetDbValueDef($rsnew, $this->CalleYNumero->CurrentValue, NULL, FALSE);

		// Colonia
		$this->Colonia->SetDbValueDef($rsnew, $this->Colonia->CurrentValue, NULL, FALSE);

		// Poblacion
		$this->Poblacion->SetDbValueDef($rsnew, $this->Poblacion->CurrentValue, NULL, FALSE);

		// Municipio_Delegacion
		$this->Municipio_Delegacion->SetDbValueDef($rsnew, $this->Municipio_Delegacion->CurrentValue, NULL, FALSE);

		// Id_Estado
		$this->Id_Estado->SetDbValueDef($rsnew, $this->Id_Estado->CurrentValue, NULL, FALSE);

		// CP
		$this->CP->SetDbValueDef($rsnew, $this->CP->CurrentValue, NULL, FALSE);

		// EMail
		$this->_EMail->SetDbValueDef($rsnew, $this->_EMail->CurrentValue, NULL, FALSE);

		// Telefonos
		$this->Telefonos->SetDbValueDef($rsnew, $this->Telefonos->CurrentValue, NULL, FALSE);

		// Celular
		$this->Celular->SetDbValueDef($rsnew, $this->Celular->CurrentValue, NULL, FALSE);

		// Fax
		$this->Fax->SetDbValueDef($rsnew, $this->Fax->CurrentValue, NULL, FALSE);

		// Banco
		$this->Banco->SetDbValueDef($rsnew, $this->Banco->CurrentValue, NULL, FALSE);

		// NumCuenta
		$this->NumCuenta->SetDbValueDef($rsnew, $this->NumCuenta->CurrentValue, NULL, FALSE);

		// CLABE
		$this->CLABE->SetDbValueDef($rsnew, $this->CLABE->CurrentValue, NULL, FALSE);

		// Maneja_Papeleta
		$this->Maneja_Papeleta->SetDbValueDef($rsnew, $this->Maneja_Papeleta->CurrentValue, NULL, strval($this->Maneja_Papeleta->CurrentValue) == "");

		// Observaciones
		$this->Observaciones->SetDbValueDef($rsnew, $this->Observaciones->CurrentValue, NULL, FALSE);

		// Maneja_Activacion_Movi
		$this->Maneja_Activacion_Movi->SetDbValueDef($rsnew, $this->Maneja_Activacion_Movi->CurrentValue, NULL, strval($this->Maneja_Activacion_Movi->CurrentValue) == "");

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
			$this->Id_Proveedor->setDbValue($conn->Insert_ID());
			$rsnew['Id_Proveedor'] = $this->Id_Proveedor->DbValue;
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
if (!isset($ca_proveedores_add)) $ca_proveedores_add = new cca_proveedores_add();

// Page init
$ca_proveedores_add->Page_Init();

// Page main
$ca_proveedores_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var ca_proveedores_add = new ew_Page("ca_proveedores_add");
ca_proveedores_add.PageID = "add"; // Page ID
var EW_PAGE_ID = ca_proveedores_add.PageID; // For backward compatibility

// Form object
var fca_proveedoresadd = new ew_Form("fca_proveedoresadd");

// Validate form
fca_proveedoresadd.Validate = function(fobj) {
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
fca_proveedoresadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fca_proveedoresadd.ValidateRequired = true;
<?php } else { ?>
fca_proveedoresadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fca_proveedoresadd.Lists["x_Id_Estado"] = {"LinkField":"x_Id_estado","Ajax":null,"AutoFill":false,"DisplayFields":["x_Estado","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span id="ewPageCaption" class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $ca_proveedores->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $ca_proveedores->getReturnUrl() ?>" id="a_GoBack" class="ewLink"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $ca_proveedores_add->ShowPageHeader(); ?>
<?php
$ca_proveedores_add->ShowMessage();
?>
<form name="fca_proveedoresadd" id="fca_proveedoresadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<br>
<input type="hidden" name="t" value="ca_proveedores">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_ca_proveedoresadd" class="ewTable">
<?php if ($ca_proveedores->RazonSocial->Visible) { // RazonSocial ?>
	<tr id="r_RazonSocial"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_RazonSocial"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->RazonSocial->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->RazonSocial->CellAttributes() ?>><span id="el_ca_proveedores_RazonSocial">
<input type="text" name="x_RazonSocial" id="x_RazonSocial" size="30" maxlength="50" value="<?php echo $ca_proveedores->RazonSocial->EditValue ?>"<?php echo $ca_proveedores->RazonSocial->EditAttributes() ?>>
</span><?php echo $ca_proveedores->RazonSocial->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->RFC->Visible) { // RFC ?>
	<tr id="r_RFC"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_RFC"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->RFC->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->RFC->CellAttributes() ?>><span id="el_ca_proveedores_RFC">
<input type="text" name="x_RFC" id="x_RFC" size="15" maxlength="15" value="<?php echo $ca_proveedores->RFC->EditValue ?>"<?php echo $ca_proveedores->RFC->EditAttributes() ?>>
</span><?php echo $ca_proveedores->RFC->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->NombreContacto->Visible) { // NombreContacto ?>
	<tr id="r_NombreContacto"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_NombreContacto"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->NombreContacto->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->NombreContacto->CellAttributes() ?>><span id="el_ca_proveedores_NombreContacto">
<input type="text" name="x_NombreContacto" id="x_NombreContacto" size="50" maxlength="50" value="<?php echo $ca_proveedores->NombreContacto->EditValue ?>"<?php echo $ca_proveedores->NombreContacto->EditAttributes() ?>>
</span><?php echo $ca_proveedores->NombreContacto->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->CalleYNumero->Visible) { // CalleYNumero ?>
	<tr id="r_CalleYNumero"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_CalleYNumero"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->CalleYNumero->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->CalleYNumero->CellAttributes() ?>><span id="el_ca_proveedores_CalleYNumero">
<input type="text" name="x_CalleYNumero" id="x_CalleYNumero" size="50" maxlength="50" value="<?php echo $ca_proveedores->CalleYNumero->EditValue ?>"<?php echo $ca_proveedores->CalleYNumero->EditAttributes() ?>>
</span><?php echo $ca_proveedores->CalleYNumero->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Colonia->Visible) { // Colonia ?>
	<tr id="r_Colonia"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Colonia"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Colonia->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Colonia->CellAttributes() ?>><span id="el_ca_proveedores_Colonia">
<input type="text" name="x_Colonia" id="x_Colonia" size="50" maxlength="50" value="<?php echo $ca_proveedores->Colonia->EditValue ?>"<?php echo $ca_proveedores->Colonia->EditAttributes() ?>>
</span><?php echo $ca_proveedores->Colonia->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Poblacion->Visible) { // Poblacion ?>
	<tr id="r_Poblacion"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Poblacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Poblacion->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Poblacion->CellAttributes() ?>><span id="el_ca_proveedores_Poblacion">
<input type="text" name="x_Poblacion" id="x_Poblacion" size="50" maxlength="50" value="<?php echo $ca_proveedores->Poblacion->EditValue ?>"<?php echo $ca_proveedores->Poblacion->EditAttributes() ?>>
</span><?php echo $ca_proveedores->Poblacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Municipio_Delegacion->Visible) { // Municipio_Delegacion ?>
	<tr id="r_Municipio_Delegacion"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Municipio_Delegacion"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Municipio_Delegacion->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Municipio_Delegacion->CellAttributes() ?>><span id="el_ca_proveedores_Municipio_Delegacion">
<input type="text" name="x_Municipio_Delegacion" id="x_Municipio_Delegacion" size="50" maxlength="50" value="<?php echo $ca_proveedores->Municipio_Delegacion->EditValue ?>"<?php echo $ca_proveedores->Municipio_Delegacion->EditAttributes() ?>>
</span><?php echo $ca_proveedores->Municipio_Delegacion->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Id_Estado->Visible) { // Id_Estado ?>
	<tr id="r_Id_Estado"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Id_Estado"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Id_Estado->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Id_Estado->CellAttributes() ?>><span id="el_ca_proveedores_Id_Estado">
<select id="x_Id_Estado" name="x_Id_Estado"<?php echo $ca_proveedores->Id_Estado->EditAttributes() ?>>
<?php
if (is_array($ca_proveedores->Id_Estado->EditValue)) {
	$arwrk = $ca_proveedores->Id_Estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_proveedores->Id_Estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fca_proveedoresadd.Lists["x_Id_Estado"].Options = <?php echo (is_array($ca_proveedores->Id_Estado->EditValue)) ? ew_ArrayToJson($ca_proveedores->Id_Estado->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $ca_proveedores->Id_Estado->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->CP->Visible) { // CP ?>
	<tr id="r_CP"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_CP"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->CP->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->CP->CellAttributes() ?>><span id="el_ca_proveedores_CP">
<input type="text" name="x_CP" id="x_CP" size="6" maxlength="5" value="<?php echo $ca_proveedores->CP->EditValue ?>"<?php echo $ca_proveedores->CP->EditAttributes() ?>>
</span><?php echo $ca_proveedores->CP->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->_EMail->Visible) { // EMail ?>
	<tr id="r__EMail"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores__EMail"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->_EMail->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->_EMail->CellAttributes() ?>><span id="el_ca_proveedores__EMail">
<input type="text" name="x__EMail" id="x__EMail" size="50" maxlength="50" value="<?php echo $ca_proveedores->_EMail->EditValue ?>"<?php echo $ca_proveedores->_EMail->EditAttributes() ?>>
</span><?php echo $ca_proveedores->_EMail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Telefonos->Visible) { // Telefonos ?>
	<tr id="r_Telefonos"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Telefonos"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Telefonos->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Telefonos->CellAttributes() ?>><span id="el_ca_proveedores_Telefonos">
<textarea name="x_Telefonos" id="x_Telefonos" cols="15" rows="3"<?php echo $ca_proveedores->Telefonos->EditAttributes() ?>><?php echo $ca_proveedores->Telefonos->EditValue ?></textarea>
</span><?php echo $ca_proveedores->Telefonos->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Celular->Visible) { // Celular ?>
	<tr id="r_Celular"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Celular"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Celular->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Celular->CellAttributes() ?>><span id="el_ca_proveedores_Celular">
<input type="text" name="x_Celular" id="x_Celular" size="30" maxlength="30" value="<?php echo $ca_proveedores->Celular->EditValue ?>"<?php echo $ca_proveedores->Celular->EditAttributes() ?>>
</span><?php echo $ca_proveedores->Celular->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Fax->Visible) { // Fax ?>
	<tr id="r_Fax"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Fax"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Fax->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Fax->CellAttributes() ?>><span id="el_ca_proveedores_Fax">
<input type="text" name="x_Fax" id="x_Fax" size="30" maxlength="30" value="<?php echo $ca_proveedores->Fax->EditValue ?>"<?php echo $ca_proveedores->Fax->EditAttributes() ?>>
</span><?php echo $ca_proveedores->Fax->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Banco->Visible) { // Banco ?>
	<tr id="r_Banco"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Banco"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Banco->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Banco->CellAttributes() ?>><span id="el_ca_proveedores_Banco">
<input type="text" name="x_Banco" id="x_Banco" size="30" maxlength="30" value="<?php echo $ca_proveedores->Banco->EditValue ?>"<?php echo $ca_proveedores->Banco->EditAttributes() ?>>
</span><?php echo $ca_proveedores->Banco->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->NumCuenta->Visible) { // NumCuenta ?>
	<tr id="r_NumCuenta"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_NumCuenta"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->NumCuenta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->NumCuenta->CellAttributes() ?>><span id="el_ca_proveedores_NumCuenta">
<input type="text" name="x_NumCuenta" id="x_NumCuenta" size="30" maxlength="20" value="<?php echo $ca_proveedores->NumCuenta->EditValue ?>"<?php echo $ca_proveedores->NumCuenta->EditAttributes() ?>>
</span><?php echo $ca_proveedores->NumCuenta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->CLABE->Visible) { // CLABE ?>
	<tr id="r_CLABE"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_CLABE"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->CLABE->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->CLABE->CellAttributes() ?>><span id="el_ca_proveedores_CLABE">
<input type="text" name="x_CLABE" id="x_CLABE" size="30" maxlength="20" value="<?php echo $ca_proveedores->CLABE->EditValue ?>"<?php echo $ca_proveedores->CLABE->EditAttributes() ?>>
</span><?php echo $ca_proveedores->CLABE->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Maneja_Papeleta->Visible) { // Maneja_Papeleta ?>
	<tr id="r_Maneja_Papeleta"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Maneja_Papeleta"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Maneja_Papeleta->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Maneja_Papeleta->CellAttributes() ?>><span id="el_ca_proveedores_Maneja_Papeleta">
<div id="tp_x_Maneja_Papeleta" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Maneja_Papeleta" id="x_Maneja_Papeleta" value="{value}"<?php echo $ca_proveedores->Maneja_Papeleta->EditAttributes() ?>></div>
<div id="dsl_x_Maneja_Papeleta" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_proveedores->Maneja_Papeleta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_proveedores->Maneja_Papeleta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Maneja_Papeleta" id="x_Maneja_Papeleta" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_proveedores->Maneja_Papeleta->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $ca_proveedores->Maneja_Papeleta->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Observaciones->Visible) { // Observaciones ?>
	<tr id="r_Observaciones"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Observaciones"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Observaciones->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Observaciones->CellAttributes() ?>><span id="el_ca_proveedores_Observaciones">
<textarea name="x_Observaciones" id="x_Observaciones" cols="80" rows="6"<?php echo $ca_proveedores->Observaciones->EditAttributes() ?>><?php echo $ca_proveedores->Observaciones->EditValue ?></textarea>
</span><?php echo $ca_proveedores->Observaciones->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($ca_proveedores->Maneja_Activacion_Movi->Visible) { // Maneja_Activacion_Movi ?>
	<tr id="r_Maneja_Activacion_Movi"<?php echo $ca_proveedores->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_ca_proveedores_Maneja_Activacion_Movi"><table class="ewTableHeaderBtn"><tr><td><?php echo $ca_proveedores->Maneja_Activacion_Movi->FldCaption() ?></td></tr></table></span></td>
		<td<?php echo $ca_proveedores->Maneja_Activacion_Movi->CellAttributes() ?>><span id="el_ca_proveedores_Maneja_Activacion_Movi">
<div id="tp_x_Maneja_Activacion_Movi" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_Maneja_Activacion_Movi" id="x_Maneja_Activacion_Movi" value="{value}"<?php echo $ca_proveedores->Maneja_Activacion_Movi->EditAttributes() ?>></div>
<div id="dsl_x_Maneja_Activacion_Movi" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $ca_proveedores->Maneja_Activacion_Movi->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($ca_proveedores->Maneja_Activacion_Movi->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label><input type="radio" name="x_Maneja_Activacion_Movi" id="x_Maneja_Activacion_Movi" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $ca_proveedores->Maneja_Activacion_Movi->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span><?php echo $ca_proveedores->Maneja_Activacion_Movi->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<br>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fca_proveedoresadd.Init();
</script>
<?php
$ca_proveedores_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$ca_proveedores_add->Page_Terminate();
?>
